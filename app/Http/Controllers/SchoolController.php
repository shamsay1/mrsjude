<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\School;
use App\Models\SystemUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::with('district')->latest()->get();

        $districts = District::all();

        return view('school', compact(
            'schools',
            'districts'
        ));
    }
    public function store(Request $request)
    {
        $request->validate([
            'school_name' => 'required',
            'school_code' => 'required',
            'district_id' => 'required'
        ]);

        School::create([
            'school_name' => $request->school_name,
            'school_code' => $request->school_code,
            'district_id' => $request->district_id
        ]);

        return redirect()->back()
            ->with('success', 'School added successfully');
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'school_name' => 'required',
            'school_code' => 'required',
            'district_id' => 'required'
        ]);

        $school = School::findOrFail($id);

        $school->update([
            'school_name' => $request->school_name,
            'school_code' => $request->school_code,
            'district_id' => $request->district_id
        ]);

        return redirect()->back()
            ->with('success', 'School updated successfully');
    }

    // Delete data
    public function destroy($id)
    {
        $school = School::findOrFail($id);

        $school->delete();

        return redirect()->back()
            ->with('success', 'School deleted successfully');
    }

    public function schoold()
{
    $districts = District::with('schools')->orderBy('district_name')->get();

    return view('districtSchool', compact('districts'));
}
    public function teachers($id)
{
    $school = School::findOrFail($id);

    $teachers = SystemUser::where('school_id', $id)->get();

    return view('viewteacher', compact('school', 'teachers'));
}

 public function showtl(){
    $school = School::where('id', Auth::user()->school_id)->get();
    $teachers = SystemUser::where('role','teacher')->where('school_id', Auth::user()->school_id)->get();
    return view('viewteacher', compact('school', 'teachers'));

 }
}
