<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\School;
use App\Models\Student;
use App\Models\SystemUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserController extends Controller
{
    public function dashboard(){
        
        $schools = School::all();
        $total_school = School::all()->count();
        $total_district = District::all()->count();
        $total_school_teachers = SystemUser::where("role","teacher")->where("school_id",Auth::user()->school_id)->count();
        $total_school_students = Student::where("school_id",Auth::user()->school_id)->count();
        $total_school_class = Student::where("school_id",Auth::user()->school_id)->count();
        if(Auth::user()->role=="d_officer"){
        $total_teachers = SystemUser::where("role","teacher")->where('district_id',Auth::user()->district_id)->count();
        $total_school = School::all()->where('district_id',Auth::user()->district_id)->count();
        }
        $total_teachers = SystemUser::where("role","teacher")->count();
        $total_headmaster = SystemUser::where("role","headmaster")->count();
        $schoolNames = [];
    $teacherCounts = [];

    foreach ($schools as $school) {

        $schoolNames[] = $school->school_name;

        $teacherCounts[] = SystemUser::where('role', 'teacher')
            ->where('school_id', $school->id)
            ->count();
    }
        $districts = District::withCount('schools')->get();

        $districtNames = [];
        $schoolCounts = [];

        foreach ($districts as $district) {

            $districtNames[] = $district->district_name;

            $schoolCounts[] = $district->schools_count;
        }
        $recentUsers = SystemUser::where("school_id",Auth::user()->school_id)->where("role","!=","headmaster")->take(5)->get();
        return view("dashboard",compact('recentUsers','total_school','total_district','total_headmaster','total_teachers','schoolNames', 'teacherCounts','districtNames', 'schoolCounts','total_school_class','total_school_students','total_school_teachers'));
    }
    public function index(Request $request)
{
    $query = SystemUser::with([
        'district',
        'school'
    ])->where('role', '!=', 'admin');

    // FILTER BY ROLE
    if ($request->role) {

        $query->where('role', $request->role);
    }

    // FILTER BY DISTRICT
    if ($request->district_id) {

        $query->where('district_id', $request->district_id);
    }

    // FILTER BY SCHOOL
    if ($request->school_id) {

        $query->where('school_id', $request->school_id);
    }

    $users = $query->latest()->get();

    $districts = District::all();
    if(Auth::user()->role=="d_officer"){
            $schools = School::where('district_id',Auth::user()->district_id)->get();
            $users = $query->where('role','!=','d_officer')->latest()->get();
        }
    elseif(Auth::user()->role =="headmaster"){
        $users = $query->where('role','teacher')->where('school_id',Auth::user()->school_id)->latest()->get();

    }
    $schools = School::all();
    

    return view('users', compact(
        'users',
        'districts',
        'schools'
    ));
}

    // Store
 public function store(Request $request)
{
    try {

        $request->validate([
            'firstname' => 'required|string',
            'middlename' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:system_users,email',
            'gender' => 'required',
            'role' => 'required',
            'password' => 'required|min:4'
        ]);

        $districtId = Auth::user()->role == 'admin'
            ? $request->district_id
            : Auth::user()->district_id;

        $schoolId = Auth::user()->role == 'admin'
            ? $request->school_id
            : Auth::user()->school_id;

        SystemUser::create([
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'gender' => $request->gender,
            'role' => $request->role,
            'district_id' => $districtId,
            'school_id' => $schoolId,
            'password' => Hash::make($request->password),
            'status' => 'Active'
        ]);

        return redirect()->back()
            ->with('success', 'User added successfully');

    } catch (Exception $e) {

    return redirect()->back()
        ->with('error', $e->getMessage());
}
}
    // Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'firstname' => 'required',
            'middlename' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'district_id' => 'required',
            'school_id' => 'required'
        ]);

        $user = SystemUser::findOrFail($id);

        $data = [
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'gender' => $request->gender,
            'district_id' => $request->district_id,
            'school_id' => $request->school_id,
        ];

        // update password if entered
        if ($request->password) {

            $data['password'] = Hash::make($request->password);

        }

        $user->update($data);

        return redirect()->back()
            ->with('success', 'User updated successfully');
    }

    public function toggleStatus($id)
{
    $user = SystemUser::findOrFail($id);

    $user->status = $user->status == 'Active'
        ? 'Deactive'
        : 'Active';

    $user->save();

    return redirect()->back()
        ->with('success', 'User status updated successfully.');
}
    public function profile(){
        return view("profile");
    }
}
