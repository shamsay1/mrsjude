<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Order;
use App\Models\School;
use App\Models\SystemUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::with('district')->orderBy("school_code","asc")->latest()->get();
        $school = School::latest()->first();

        $nextNumber = $school
            ? (int) substr($school->school_code, -4) + 1
            : 1;

        $schoolCode = 'SCH-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        $districts = District::all();

        return view('school', compact(
            'schools',
            'districts',
            'schoolCode'
        ));
    }

public function store(Request $request)
{
    try {

        $request->validate([
            'school_name' => 'required',
            'school_code' => 'required|unique:schools,school_code',
            'district_id' => 'required'
        ]);

        School::create([
            'school_name' => $request->school_name,
            'school_code' => $request->school_code,
            'district_id' => $request->district_id
        ]);

        return redirect()->back()
            ->with('success', 'School added successfully');

    } catch (Exception $e) {

        return redirect()->back()
            ->withInput()
            ->with('error', $e->getMessage());

        // Production:
        // ->with('error', 'Failed to add school');
    }
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
   public function toggleStatus($id)
{
    $school = School::findOrFail($id);

    $school->status = $school->status == 'Active'
        ? 'Deactive'
        : 'Active';

    $school->save();

    return redirect()->back()
        ->with('success', 'School status updated successfully.');
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

public function showtl()
{
    $schoolId = Auth::user()->school_id;

    if(Auth::user()->role == 'supervisor')
    {
        $schoolId = Order::where('supervisor_id', Auth::id())
            ->latest()
            ->value('school_id');
    }

    $school = School::find($schoolId);

    $teachers = SystemUser::where('role', 'teacher')
        ->where('school_id', $schoolId)
        ->get();

    return view('viewteacher', compact(
        'school',
        'teachers'
    ));
}
}
