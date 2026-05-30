<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
     public function index()
    {
        $students = Student::with('classRoom')->latest()->get();
        $classes = ClassRoom::all();

        return view('student', compact(
            'students',
            'classes'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'middlename' => 'required',
            'lastname' => 'required',
            'gender' => 'required',
            'class_id' => 'required'
        ]);

        Student::create([
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'gender' => $request->gender,
            'class_id' => $request->class_id,
        ]);

        return redirect()->back()
            ->with('success', 'Student added successfully');
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'firstname' => 'required',
            'middlename' => 'required',
            'lastname' => 'required',
            'gender' => 'required',
            'class_id' => 'required'
        ]);

        $student->update([
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'gender' => $request->gender,
            'class_id' => $request->class_id,
        ]);

        return redirect()->back()
            ->with('success', 'Student updated successfully');
    }

    public function destroy($id)
    {
        Student::findOrFail($id)->delete();

        return redirect()->back()
            ->with('success', 'Student deleted successfully');
    }
}
