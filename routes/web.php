<?php

use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get("/",[LoginController::class,"showlogin"]);
Route::get("/dashboard",[UserController::class,"dashboard"])->name("dashboard");
Route::post("/login",[LoginController::class,"login"])->name("login1");
Route::resource('district', DistrictController::class);
Route::resource('school', SchoolController::class);
Route::resource('system-user', UserController::class);
Route::resource('school-class', ClassRoomController::class);
Route::resource('subject', SubjectController::class);