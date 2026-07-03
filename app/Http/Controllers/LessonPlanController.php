<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\LessonPlan;
use App\Models\Student;
use App\Models\Subject;
use App\Models\SubTopic;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonPlanController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $lessonPlans = LessonPlan::with([
            'subject.teacher',
            'subject.classRoom.school'
        ])
        ->whereHas('subject', function ($query) use ($user) {

            $query->where('teacher_id', $user->id);

        })
        ->latest()
        ->get();

    $male = Student::where('gender', 'Male')->count();

    $female = Student::where('gender', 'Female')->count();

    $total = Student::count();
    $subjects = Subject::where('teacher_id', $user->id)->get();

    return view('lessonplan', compact(
        'lessonPlans',
        'subjects',
        'male',
        'female',
        'total'
    ));
}

public function saveComment(Request $request)
{
    $request->validate([
        'plan_id' => 'required|exists:lesson_plans,id',
        'comment' => 'required|string',
    ]);

    // Lesson plan iliyochaguliwa
    $plan = LessonPlan::findOrFail($request->plan_id);

    // Hifadhi comment
    $plan->comments = $request->comment;
    $plan->save();

    // Pata teacher_id kupitia subject
    $teacherId = Subject::findOrFail($plan->subject_id)->teacher_id;

    // Pata subject zote za mwalimu huyo
    $subjectIds = Subject::where('teacher_id', $teacherId)
        ->pluck('id');

    // Update lesson plans zote za mwalimu huyo
    LessonPlan::whereIn('subject_id', $subjectIds)
        ->update([
            'status' => 'completed'
        ]);

    return back()->with('success', 'All lesson plans for this teacher have been completed successfully.');
}

public function approve1(Request $request)
{
    $request->validate([
        'plan_id' => 'required|exists:lesson_plans,id',
    ]);

    $plan = LessonPlan::findOrFail($request->plan_id);

    $teacherId = Subject::findOrFail($plan->subject_id)->teacher_id;

    $subjectIds = Subject::where('teacher_id', $teacherId)
        ->pluck('id');

    LessonPlan::whereIn('subject_id', $subjectIds)
        ->update([
            'status' => 'completed',
            'comments' => null,
        ]);

    return back()->with('success','Lesson plans approved successfully.');
}

public function reject(Request $request)
{
    $request->validate([
        'plan_id' => 'required|exists:lesson_plans,id',
        'comment' => 'required|string',
    ]);

    $plan = LessonPlan::findOrFail($request->plan_id);

    $teacherId = Subject::findOrFail($plan->subject_id)->teacher_id;

    $subjectIds = Subject::where('teacher_id', $teacherId)
        ->pluck('id');

    LessonPlan::whereIn('subject_id', $subjectIds)
        ->update([
            'status' => 'rejected',
            'comments' => $request->comment,
        ]);

    return back()->with('success','Lesson plans rejected successfully.');
}
public function getTopics($subjectId)
{
    return Topic::where(
        'subject_id',
        $subjectId
    )->get();
}

public function getSubTopics($topicId)
{
    return SubTopic::where(
        'topic_id',
        $topicId
    )->get();
}

    // Store Data
   public function store(Request $request)
{
    $request->validate([
        'subject_id' => 'required',
        'topic_id' => 'required',
        'sub_topic_id' => 'required',
        'objectives' => 'required',
        'teaching_methods' => 'required|array|min:1',
        'teaching_materials' => 'required',
        'lesson_date' => 'required'
    ]);

    LessonPlan::create([
        'subject_id' => $request->subject_id,
        'school_id' => Auth::user()->school_id,
        'topic_id' => $request->topic_id,
        'sub_topic_id' => $request->sub_topic_id,
        'lesson_date' => $request->lesson_date,
        'objectives' => $request->objectives,

        // Badilisha array kuwa string
        'teaching_methods' => implode(', ', $request->teaching_methods),

        'teaching_materials' => $request->teaching_materials,
        'status' => 'pending',
    ]);
     ActivityLog::create([
            
            'module' => 'Lesson plan',
            'action' => 'Upload lesson plan',
            'description' => 'The teacher '.Auth::user()->firstname.' '.Auth::user()->middlename.' have upload lesson plan',
            'ip_address' => $request->ip(),
            'browser' => $request->header('User-Agent'),
            'platform' => php_uname('s'),
            'device' => $request->header('User-Agent'),
        ]);

    return redirect()->back()
        ->with('success', 'Lesson Plan added successfully');
}

    public function approve(Request $request)
{
    $request->validate([
        'plan_id' => 'required|exists:lesson_plans,id'
    ]);

    $plan = LessonPlan::findOrFail($request->plan_id);

    $plan->status = 'completed';

    $plan->save();

    return back()->with('success', 'Plan approved successfully.');
}

    // Delete
    public function destroy($id)
    {
        $lessonPlan = LessonPlan::findOrFail($id);

        $lessonPlan->delete();

        return redirect()->back()
            ->with('success', 'Lesson Plan deleted successfully');
    }
    public function teacherLessonPlans1($id)
{
    $lessonPlans = LessonPlan::with([
        'subject.teacher',
        'subject.classRoom.school'
    ])
    ->whereHas('subject', function ($query) use ($id) {

        $query->where('teacher_id', $id);

    })
    ->latest()
    ->get();

    $subjects = Subject::where('teacher_id', $id)->get();

    return view('lessonplan', compact(
        'lessonPlans',
        'subjects'
    ));
}
}
