<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    public function showlogin(Request $request)
{
    $ip = $request->ip();
    $blockKey = "blocked_ip_" . $ip;

    if (Cache::has($blockKey)) {

        $expireTime = Cache::get($blockKey);

        if (!($expireTime instanceof \Carbon\Carbon)) {
            Cache::forget($blockKey);
            return view('login');
        }

        $seconds = floor(now()->diffInSeconds($expireTime, false));

        if ($seconds <= 0) {
            Cache::forget($blockKey);
            return view('login');
        }

        ActivityLog::create([
            'user_id' => null,
            'fullname' => 'Unknown',
            'email' => null,
            'role' => 'Guest',
            'module' => 'Authentication',
            'action' => 'Blocked Access',
            'description' => 'Blocked user attempted to access login page.',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'browser' => $request->header('User-Agent'),
            'platform' => php_uname('s'),
            'device' => $request->header('User-Agent'),
        ]);

        return view('blocked', compact('seconds'));
    }

    return view('login');
}
   public function login(Request $request)
{
    $request->validate([
        "email" => "required|string",
        "password" => "required|string",
    ]);

    $ip = $request->ip();

    $blockKey = "blocked_ip_" . $ip;
    $attemptKey = "attempts_" . $ip;
    $levelKey = "level_" . $ip;

    if (Cache::has($blockKey)) {

        $expireTime = Cache::get($blockKey);

        $seconds = floor(now()->diffInSeconds($expireTime, false));

        ActivityLog::create([
            'user_id' => null,
            'fullname' => 'Unknown',
            'email' => $request->email,
            'role' => 'Guest',
            'module' => 'Authentication',
            'action' => 'Blocked Login',
            'description' => 'Blocked IP attempted to login.',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'browser' => $request->header('User-Agent'),
            'platform' => php_uname('s'),
            'device' => $request->header('User-Agent'),
        ]);

        return view('blocked', compact('seconds'));
    }

    $credentials = $request->only("email","password");

    if(Auth::attempt($credentials)){

        Cache::forget($attemptKey);

        ActivityLog::create([
            'module' => 'Authentication',
            'action' => 'Login',
            'description' => Auth::user()->firstname.' '.Auth::user()->middlename.' whose role is '.Auth::user()->role.' logged into the system.',
            'ip_address' => $request->ip(),
            'browser' => $request->header('User-Agent'),
            'platform' => php_uname('s'),
            'device' => $request->header('User-Agent'),
        ]);
        

        return redirect()->route("dashboard");
    }

    $attempts = Cache::increment($attemptKey);

    if($attempts==1){
        Cache::put($attemptKey,1,now()->addMinutes(10));
    }

    ActivityLog::create([
        'user_id' => null,
        'fullname' => 'Unknown',
        'email' => $request->email,
        'role' => 'Guest',
        'module' => 'Authentication',
        'action' => 'Failed Login',
        'description' => 'Invalid email or password.',
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'browser' => $request->header('User-Agent'),
        'platform' => php_uname('s'),
        'device' => $request->header('User-Agent'),
    ]);

    if($attempts>=3){

        Cache::forget($attemptKey);

        if(!Cache::has($levelKey)){

            Cache::put($levelKey,true,now()->addDay());

            $expire = now()->addSeconds(30);

            Cache::put($blockKey,$expire,$expire);

            ActivityLog::create([
                'module' => 'Authentication',
                'action' => 'Account Blocked',
                'description' => 'IP Address blocked for 30 seconds after 3 failed login attempts.',
                'ip_address' => $request->ip(),
                'browser' => $request->header('User-Agent'),
                'platform' => php_uname('s'),
                'device' => $request->header('User-Agent'),
            ]);

        }else{

            $expire = now()->addMinutes(5);

            Cache::put($blockKey,$expire,$expire);

            ActivityLog::create([
                'module' => 'Authentication',
                'action' => 'Account Blocked',
                'description' => 'IP Address blocked for 5 minutes after repeated failed login attempts.',
                'ip_address' => $request->ip(),
                'browser' => $request->header('User-Agent'),
                'platform' => php_uname('s'),
                'device' => $request->header('User-Agent'),
            ]);
        }

        return redirect()->route("login");
    }

    return back()->with("error","Wrong username/password");
}
     public function destroy(Request $request)
    {
    //      ActivityLog::create([
    //     'module' => 'Authentication',
    //     'action' => 'Logout',
    //     'description' => Auth::user()->firstname.' logged out from the system.',
    //     'ip_address' => $request->ip(),
        
    //     'browser' => $request->header('User-Agent'),
    //     'platform' => php_uname('s'),
    //     'device' => $request->header('User-Agent'),
    // ]);
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
            'email' => $request->query('email') 
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
