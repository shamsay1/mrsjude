<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\SystemUser;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with([
            'classRoom',
            'teacher'
        ])->latest()->get();

        $classes = ClassRoom::all();

        $teachers = SystemUser::all();

        return view('subjects', compact(
            'subjects',
            'classes',
            'teachers'
        ));
    }

    // Store Data
    public function store(Request $request)
    {
        $request->validate([
            'subjectName' => 'required',
            'subjectCode' => 'required',
            'class_room_id' => 'required',
            'teacher_id' => 'required'
        ]);

        Subject::create([
            'subjectName' => $request->subjectName,
            'subjectCode' => $request->subjectCode,
            'class_room_id' => $request->class_room_id,
            'teacher_id' => $request->teacher_id
        ]);

        return redirect()->back()
            ->with('success', 'Subject added successfully');
    }

    // Update Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'subjectName' => 'required',
            'subjectCode' => 'required',
            'class_room_id' => 'required',
            'teacher_id' => 'required'
        ]);

        $subject = Subject::findOrFail($id);

        $subject->update([
            'subjectName' => $request->subjectName,
            'subjectCode' => $request->subjectCode,
            'class_room_id' => $request->class_room_id,
            'teacher_id' => $request->teacher_id
        ]);

        return redirect()->back()
            ->with('success', 'Subject updated successfully');
    }

    // Delete Data
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);

        $subject->delete();

        return redirect()->back()
            ->with('success', 'Subject deleted successfully');
    }
}
