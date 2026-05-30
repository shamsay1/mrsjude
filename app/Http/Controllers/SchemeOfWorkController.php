<?php

namespace App\Http\Controllers;

use App\Models\SchemeOfWork;
use App\Models\Subject;
use App\Models\SystemUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchemeOfWorkController extends Controller
{
    public function index()
    {
        $schemes = SchemeOfWork::with('subject')->get();
        $subjects = Subject::where("teacher_id",Auth::id())->get();

        return view('schemes1', compact('schemes', 'subjects'));
    }

    public function store(Request $request)
    {
        SchemeOfWork::create($request->all());

        return back()->with('success', 'Scheme of Work created successfully');
    }

    public function update(Request $request, $id)
    {
        $scheme = SchemeOfWork::findOrFail($id);
        $scheme->update($request->all());

        return back()->with('success', 'Updated successfully');
    }

    public function destroy($id)
    {
        SchemeOfWork::findOrFail($id)->delete();

        return back()->with('success', 'Deleted successfully');
    }
    public function index1($teacherId)
{
    $teacher = SystemUser::with('school')
                ->findOrFail($teacherId);

    $schemes = SchemeOfWork::whereHas('subject', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })
        ->with([
            'subject.teacher.school',
            'subject.classRoom'
        ])
        ->get();
    $subjects = Subject::where('teacher_id', $teacherId)->get();
    

    return view('schemes1', compact('schemes', 'teacher','subjects'));
}
}