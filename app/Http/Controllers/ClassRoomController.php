<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\School;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
     public function index()
    {
        $classes = ClassRoom::with('school')
            ->latest()
            ->get();

        $schools = School::all();

        return view('class_room', compact(
            'classes',
            'schools'
        ));
    }

    // Store Data
    public function store(Request $request)
    {
        $request->validate([
            'class_name' => 'required',
            'class_level' => 'required',
            'school_id' => 'required'
        ]);

        ClassRoom::create([
            'class_name' => $request->class_name,
            'class_level' => $request->class_level,
            'school_id' => $request->school_id
        ]);

        return redirect()->back()
            ->with('success', 'Class added successfully');
    }

    // Update Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'class_name' => 'required',
            'class_level' => 'required',
            'school_id' => 'required'
        ]);

        $class = ClassRoom::findOrFail($id);

        $class->update([
            'class_name' => $request->class_name,
            'class_level' => $request->class_level,
            'school_id' => $request->school_id
        ]);

        return redirect()->back()
            ->with('success', 'Class updated successfully');
    }

    // Delete Data
    public function destroy($id)
    {
        $class = ClassRoom::findOrFail($id);

        $class->delete();

        return redirect()->back()
            ->with('success', 'Class deleted successfully');
    }
}
