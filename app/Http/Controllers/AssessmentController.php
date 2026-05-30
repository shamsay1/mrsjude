<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function index()
{
    $subjects = Subject::where(
        'teacher_id',
        Auth::id()
    )->get();
    $classes = ClassRoom::all();

    return view('assessmentIndex', compact(
        'subjects',
        'classes'
    ));
}
    public function create($subjectId,$classId)
    {
        $students = Student::where(
            'class_id',
            $classId
        )->get();

        $subject = Subject::findOrFail($subjectId);

        return view(
            'assessmentCreate',
            compact(
                'students',
                'subject'
            )
        );
    }

    public function store(Request $request)
    {
        foreach ($request->student_id as $key => $studentId) {

            Assessment::updateOrCreate(

                [
                    'student_id' => $studentId,
                    'subject_id' => $request->subject_id
                ],

                [
                    'classwork1' => $request->classwork1[$key],
                    'classwork2' => $request->classwork2[$key],
                    'classwork3' => $request->classwork3[$key],
                    'classwork4' => $request->classwork4[$key],
                    'classwork5' => $request->classwork5[$key],
                    'classwork6' => $request->classwork6[$key],
                    'classwork7' => $request->classwork7[$key],
                    'classwork8' => $request->classwork8[$key],
                    'classwork9' => $request->classwork9[$key],
                    'classwork10' => $request->classwork10[$key],

                    'homework1' => $request->homework1[$key],
                    'homework2' => $request->homework2[$key],
                    'homework3' => $request->homework3[$key],
                    'homework4' => $request->homework4[$key],
                    'homework5' => $request->homework5[$key],

                    'topictest1' => $request->topictest1[$key],
                    'topictest2' => $request->topictest2[$key],
                    'topictest3' => $request->topictest3[$key],

                    'terminal_exam' => $request->terminal_exam[$key],
                ]
            );
        }

        return back()
            ->with(
                'success',
                'Marks saved successfully'
            );
    }

    public function assessmentBook($subjectId)
    {
        $records = Assessment::with([
            'student',
            'subject'
        ])
        ->where('subject_id', $subjectId)
        ->get();

        foreach ($records as $record) {

            $cw =
            (
                ($record->classwork1 ?? 0) +
                ($record->classwork2 ?? 0) +
                ($record->classwork3 ?? 0) +
                ($record->classwork4 ?? 0) +
                ($record->classwork5 ?? 0)
            ) / 5;

            $hw =
            (
                ($record->homework1 ?? 0) +
                ($record->homework2 ?? 0)
            ) / 2;

            $tt = ($record->topictest1 ?? 0);

            $record->total_marks =
                $cw +
                $hw +
                $tt +
                ($record->terminal_exam ?? 0);
        }

        $records = $records
            ->sortByDesc('total_marks')
            ->values();

        foreach ($records as $index => $record) {
            $record->position = $index + 1;
        }

        return view(
            'assessmentBook',
            compact('records')
        );
    }
    public function teacherAssessmentBook($teacherId)
{
    $subjects = Subject::where(
        'teacher_id',
        $teacherId
    )->get();

    return view(
        'AssessmentTeacher',
        compact('subjects')
    );
}
}