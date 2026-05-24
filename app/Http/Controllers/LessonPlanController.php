<?php

namespace App\Http\Controllers;

use App\Models\LessonPlan;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonPlanController extends Controller
{
    public function index()
{
    $user = Auth::user();

    // Lesson plans za teacher aliyelogin tu
    $lessonPlans = LessonPlan::with([
            'subject.teacher',
            'subject.classRoom.school'
        ])
        ->whereHas('subject', function ($query) use ($user) {

            $query->where('teacher_id', $user->id);

        })
        ->latest()
        ->get();

    // Subjects za teacher huyo tu
    $subjects = Subject::where('teacher_id', $user->id)->get();

    return view('lessonplan', compact(
        'lessonPlans',
        'subjects'
    ));
}

    // Store Data
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required',
            'topic' => 'required',
            'subtopic' => 'required',
            'objectives' => 'required',
            'teaching_methods' => 'required',
            'teaching_materials' => 'required',
            'evaluation' => 'required',
            'lesson_date' => 'required'
        ]);

        LessonPlan::create([
            'subject_id' => $request->subject_id,
            'topic' => $request->topic,
            'subtopic' => $request->subtopic,
            'objectives' => $request->objectives,
            'teaching_methods' => $request->teaching_methods,
            'teaching_materials' => $request->teaching_materials,
            'evaluation' => $request->evaluation,
            'lesson_date' => $request->lesson_date
        ]);

        return redirect()->back()
            ->with('success', 'Lesson Plan added successfully');
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
