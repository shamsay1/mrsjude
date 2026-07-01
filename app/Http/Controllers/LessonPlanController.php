<?php

namespace App\Http\Controllers;

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
            'teaching_methods' => 'required',
            'teaching_materials' => 'required',
            'evaluation' => 'required',
            'lesson_date' => 'required'
        ]);

        LessonPlan::create([
    'subject_id' => $request->subject_id,
    'school_id' => Auth::user()->school_id,
    'topic_id' => $request->topic_id,
    'sub_topic_id' => $request->sub_topic_id,
    'lesson_date' => $request->lesson_date,
    'objectives' => $request->objectives,
    'teaching_methods' => $request->teaching_methods,
    'teaching_materials' => $request->teaching_materials,
    'evaluation' => $request->evaluation,
    'status'             => 'pending',
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
