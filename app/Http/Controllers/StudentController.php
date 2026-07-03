<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
     public function index()
    {
        $students = Student::with('classRoom')->where('school_id',Auth::user()->school_id)->latest()->get();
        $classes = ClassRoom::all();

        return view('student', compact(
            'students',
            'classes'
        ));
    }

    public function store(Request $request)
{
    try {

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
            'school_id' => Auth::user()->school_id,
        ]);

        return redirect()->back()
            ->with('success', 'Student added successfully');

    } catch (Exception $e) {

        return redirect()->back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
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
