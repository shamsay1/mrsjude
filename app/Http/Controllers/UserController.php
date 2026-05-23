<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\School;
use App\Models\SystemUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function dashboard(){
        return view("dashboard");
    }
     public function index()
    {
        $users = SystemUser::with([
            'district',
            'school'
        ])->latest()->get();

        $districts = District::all();

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
        $request->validate([
            'firstname' => 'required',
            'middlename' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:system_users,email',
            'gender' => 'required',
            'district_id' => 'required',
            'role' => 'required',
            'password' => 'required'
        ]);

        SystemUser::create([
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'gender' => $request->gender,
            'role' => $request->role,
            'district_id' => $request->district_id,
            'school_id' => $request->school_id,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()
            ->with('success', 'User added successfully');
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

    // Delete
    public function destroy($id)
    {
        $user = SystemUser::findOrFail($id);

        $user->delete();

        return redirect()->back()
            ->with('success', 'User deleted successfully');
    }
}
