<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\DailyRecordController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\LessonPlanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get("/",[LoginController::class,"showlogin"])->name('login');
Route::get("/dashboard",[UserController::class,"dashboard"])->name("dashboard");
Route::post("/login",[LoginController::class,"login"])->name("login1");
Route::resource('district', DistrictController::class);
Route::resource('school', SchoolController::class);
Route::resource('system-user', UserController::class);
Route::resource('school-class', ClassRoomController::class);
Route::resource('subject', SubjectController::class);
Route::resource('lesson-plan', LessonPlanController::class);
Route::get('/teacher/{id}/lesson-plans',
    [LessonPlanController::class, 'teacherLessonPlans'])
    ->name('teacher.lesson-plans');
Route::resource('daily-record', DailyRecordController::class);
Route::resource('student', StudentController::class);
Route::get("/schhold",[SchoolController::class,"schoold"])->name("schoold");
Route::get('/school/{id}/teachers', [SchoolController::class, 'teachers'])
    ->name('school.teachers');
Route::get("/profile",[UserController::class,"profile"])->name("profile");
Route::get('/teacher/{id}/lesson-plans', [LessonPlanController::class, 'teacherLessonPlans1'])
    ->name('teacher.lesson-plans1');
Route::get("/showtl",[SchoolController::class,"showtl"])->name("showtl");
Route::get('/teacher/{id}/daily-records', [UserController::class, 'dailyRecords'])
    ->name('teacher.daily-records');
Route::post('/logout', [LoginController::class, 'destroy'])
    ->name('logout');

Route::get("/forgot",[LoginController::class,"forgot"])->name("forgot");
Route::post('/forgot-password', [LoginController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'updatePassword'])->name('password.update');


Route::get('/teacher/{id}/daily-records',
    [DailyRecordController::class, 'teacherDailyRecords'])
    ->name('teacher.daily-records');
Route::get('/assessment', [AssessmentController::class, 'index'])
    ->name('assessment.index');
Route::get(
    '/assessment/create/{subject}/{class}',
    [AssessmentController::class,'create']
)->name('assessment.create');

Route::post(
    '/assessment/store',
    [AssessmentController::class,'store']
)->name('assessment.store');

Route::get(
    '/assessment/book/{subject}',
    [AssessmentController::class, 'assessmentBook']
)->name('assessment.book');


Route::get(
    '/teacher-assessment-book/{teacher}',
    [AssessmentController::class, 'teacherAssessmentBook']
)->name('teacher.assessment.book');

use App\Http\Controllers\SchemeOfWorkController;

Route::get('/schemes', [SchemeOfWorkController::class, 'index'])->name('scheme.index');
Route::post('/schemes', [SchemeOfWorkController::class, 'store'])->name('scheme.store');
Route::put('/schemes/{id}', [SchemeOfWorkController::class, 'update'])->name('scheme.update');
Route::delete('/schemes/{id}', [SchemeOfWorkController::class, 'destroy'])->name('scheme.destroy');
Route::get('/schemes/{teacher}', [SchemeOfWorkController::class, 'index1'])
    ->name('scheme.index1');