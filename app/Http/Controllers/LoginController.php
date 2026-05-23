<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
