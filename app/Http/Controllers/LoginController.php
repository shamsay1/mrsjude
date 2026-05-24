<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showlogin(){
        return view("login");
    }
    public function login(Request $request){
        $request->validate([
            "email" => "required|string",
            "password" => "required|string"
        ]);
        $credentials = $request->only("email","password");
        if(Auth::attempt($credentials)){
            return redirect()->route("dashboard");
        }
    }
     public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
     public function forgot(){
        return view("forgotpassword");
    }
    public function sendResetLink(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $status = Password::broker('users')->sendResetLink(
    $request->only('email')
);

    return $status === Password::RESET_LINK_SENT
        ? back()->with('success', 'Link sent successfully, check your email Inbox')
        : back()->withErrors(['email' => 'Email not found.']);
}
    public function showResetForm(Request $request, $token = null)
    {
        return view('resetpassword1', [
            'token' => $token,
            'email' => $request->query('email') // email inakuja kama query param
        ]);
    }
    public function updatePassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:5|confirmed'
    ]);

    $status = Password::broker('users')->reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($teacher, $password) {
            $teacher->password = Hash::make($password);
            $teacher->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('success', 'Password changed success!')
        : back()->withErrors(['email' => __($status)]);
}
}
