<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\DailyRecordController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\LessonPlanController;
use App\Http\Controllers\LessonPlanStageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SchemeOfWorkController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get("/",[LoginController::class,"showlogin"])->name('login');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])
        ->name('dashboard');
Route::get('/admin/syllabus-report', [SupervisorController::class, 'adminSyllabusReport'])->name("adminsil");
Route::resource('system-user', UserController::class);
Route::resource('subject', SubjectController::class);
Route::get("/showtl",[SchoolController::class,"showtl"])->name("showtl");
Route::resource('lesson-plan', LessonPlanController::class);
Route::get('/assessment', [AssessmentController::class, 'index'])
    ->name('assessment.index');
Route::get('/schemes', [SchemeOfWorkController::class, 'index'])->name('scheme.index');
Route::resource('daily-record', DailyRecordController::class);


});
Route::middleware(['auth','admin'])->group(function(){
Route::resource('district', DistrictController::class);
Route::resource('school', SchoolController::class);
Route::get("/view_work",[OrderController::class,"index1"])->name("vwork");
Route::get('/admin/supervisor-reports', [SupervisorController::class, 'adminSupervisorReports'])->name("adminsupervisors.reports");
Route::get('/admin/teacher-workbook-report',[SupervisorController::class,'getTeacherWorkbookReport'])->name("performance");
Route::get("/profile",[UserController::class,"profile"])->name("profile");



});

Route::middleware(['auth','supervisor'])->group(function(){
Route::get('/orders',
    [OrderController::class,'index'])
    ->name('orders.index');
Route::get('/supervisor/student-performance-report', [SupervisorController::class, 'studentPerformanceReport'])
    ->name('supervisor.student.performance.report');


});

Route::middleware(['auth','headmaster'])->group(function(){
Route::resource('school-class', ClassRoomController::class);
Route::resource('student', StudentController::class);
Route::post('/lesson-plan/comment', [LessonPlanController::class, 'saveComment'])
    ->name('lesson-plan.comment');



});




Route::post('/plans/approve', [LessonPlanController::class, 'approve'])
    ->name('plans.approve');

Route::post("/login",[LoginController::class,"login"])->name("login1");
Route::get('/teacher/{id}/lesson-plans',
    [LessonPlanController::class, 'teacherLessonPlans'])
    ->name('teacher.lesson-plans');
Route::get("/schhold",[SchoolController::class,"schoold"])->name("schoold");
Route::get('/school/{id}/teachers', [SchoolController::class, 'teachers'])
    ->name('school.teachers');
Route::get("/profile",[UserController::class,"profile"])->name("profile");
Route::get('/teacher/{id}/lesson-plans', [LessonPlanController::class, 'teacherLessonPlans1'])
    ->name('teacher.lesson-plans1');
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




Route::post('/schemes', [SchemeOfWorkController::class, 'store'])->name('scheme.store');
Route::put('/schemes/{id}', [SchemeOfWorkController::class, 'update'])->name('scheme.update');
Route::delete('/schemes/{id}', [SchemeOfWorkController::class, 'destroy'])->name('scheme.destroy');
Route::get('/schemes/{teacher}', [SchemeOfWorkController::class, 'index1'])
    ->name('scheme.index1');
Route::patch('/district/{id}/toggle-status',
    [DistrictController::class, 'toggleStatus'])
    ->name('district.toggle-status');
Route::patch('/school/{id}/toggle-status',
    [SchoolController::class, 'toggleStatus'])
    ->name('school.toggle-status');
Route::patch('/system-user/{id}/toggle-status',
    [UserController::class, 'toggleStatus'])
    ->name('system-user.toggle-status');
Route::post('/orders/store',
    [OrderController::class,'store'])
    ->name('orders.store');

Route::get('/orders/{id}',
    [OrderController::class,'show'])
    ->name('orders.show');

Route::patch('/orders/{id}/complete',
    [OrderController::class,'complete'])
    ->name('orders.complete');
Route::get('/get-topics/{subjectId}',
    [LessonPlanController::class, 'getTopics']);

Route::get('/get-subtopics/{topicId}',
    [LessonPlanController::class, 'getSubTopics']);
Route::patch('/orders/{id}/toggle-status', [OrderController::class, 'toggleStatus'])->name('orders.toggle-status');
Route::post(
    '/lesson-plan-stage/store',
    [LessonPlanStageController::class,'store']
)->name('lesson-plan-stage.store');

Route::post('/report/send',
    [SupervisorController::class,'sendReport'])
    ->name('report.send');
Route::get('/blocked', function () {
    return view('blocked');
})->name('blocked');
Route::get('/all_logs',[UserController::class,"all_logs"])->name('all_logs');
Route::get('/data-refresh',[UserController::class,'refresh'])->name('dashboard.table');