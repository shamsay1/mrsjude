<?php

namespace App\Http\Controllers;

use App\Models\DailyRecording;
use App\Models\School;
use App\Models\Subject;
use App\Models\SystemUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyRecordController extends Controller
{
    public function index()
{
    $user = Auth::user();

    
    $records = DailyRecording::with([
            'teacher',
            'school',
            'subject.classRoom'
        ])
        ->where('teacher_id', $user->id)
        ->latest()
        ->get();
    $teachers = SystemUser::where('id', $user->id)->get();

    // School ya teacher huyo tu
    $schools = School::where('id', $user->school_id)->get();

    // Subjects za teacher huyo tu
    $subjects = Subject::where('teacher_id', $user->id)->get();

    return view('dailyrecord', compact(
        'records',
        'teachers',
        'schools',
        'subjects'
    ));
}

    // Store Data
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required',
            'school_id' => 'required',
            'subject_id' => 'required',
            'date' => 'required',
            'period' => 'required',
            'main_topic' => 'required',
            'work_done_by_teacher' => 'required',
            'work_done_by_student' => 'required'
        ]);

        DailyRecording::create([
            'teacher_id' => $request->teacher_id,
            'school_id' => $request->school_id,
            'subject_id' => $request->subject_id,
            'date' => $request->date,
            'period' => $request->period,
            'main_topic' => $request->main_topic,
            'work_done_by_teacher' => $request->work_done_by_teacher,
            'work_done_by_student' => $request->work_done_by_student,
            'remarks' => $request->remarks
        ]);

        return redirect()->back()
            ->with('success', 'Daily Record Added Successfully');
    }

    // Delete Data
    public function destroy($id)
    {
        $record = DailyRecording::findOrFail($id);

        $record->delete();

        return redirect()->back()
            ->with('success', 'Daily Record Deleted Successfully');
    }
    public function teacherDailyRecords($id)
{
    $records = DailyRecording::with([
        'teacher',
        'school',
        'subject.classRoom'
    ])
    ->where('teacher_id', $id)
    ->latest()
    ->get();

    $teachers = SystemUser::all();

    $schools = School::all();

    $subjects = Subject::where('teacher_id', $id)->get();

    return view('dailyrecord', compact(
        'records',
        'teachers',
        'schools',
        'subjects',
        
    ));
}

    public function saveComment(Request $request)
{
    $request->validate([
        'record_id' => 'required|exists:daily_recordings,id',
        'comment'   => 'required|string',
    ]);

    $record = DailyRecording::findOrFail($request->record_id);

    $record->update([
        'comments' => $request->comment,
        'status'   => 'completed',
    ]);

    return redirect()->back()->with('success', 'Comment added successfully.');
}
}
