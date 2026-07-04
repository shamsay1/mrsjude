<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\ClassRoom;
use App\Models\Order;
use App\Models\Report;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupervisorController extends Controller
{
     public function studentPerformanceReport(Request $request)
{
    $order = Order::where('supervisor_id', Auth::id())
        ->latest()
        ->first();

    if (!$order) {
        return back()->with('error', 'No school assigned to this supervisor');
    }

    $schoolId = $order->school_id;

    $school = School::find($schoolId);

    // Madarasa yote ya shule
    $classes = ClassRoom::where('school_id', $schoolId)->get();

    $classId = $request->class_id;

    // Report isionekane mpaka class ichaguliwe
    if (!$classId) {
        return view('studentperformance', compact(
            'school',
            'classes'
        ));
    }

    $formula = "
    (
        IFNULL(classwork1,0)+
        IFNULL(classwork2,0)+
        IFNULL(classwork3,0)+
        IFNULL(classwork4,0)+
        IFNULL(classwork5,0)+
        IFNULL(classwork6,0)+
        IFNULL(classwork7,0)+
        IFNULL(classwork8,0)+
        IFNULL(classwork9,0)+
        IFNULL(classwork10,0)+

        IFNULL(homework1,0)+
        IFNULL(homework2,0)+
        IFNULL(homework3,0)+
        IFNULL(homework4,0)+
        IFNULL(homework5,0)+

        IFNULL(topictest1,0)+
        IFNULL(topictest2,0)+
        IFNULL(topictest3,0)+

        IFNULL(terminal_exam,0)
    ) / 19
    ";

    $students = Student::where('school_id', $schoolId)
        ->where('class_id', $classId)
        ->count();

    $results = Assessment::join(
            'students',
            'students.id',
            '=',
            'assessments.student_id'
        )
        ->where('students.school_id', $schoolId)
        ->where('students.class_id', $classId)
        ->select(
            'students.id',
            'students.firstname',
            'students.lastname',
            DB::raw("AVG($formula) as average_score")
        )
        ->groupBy(
            'students.id',
            'students.firstname',
            'students.lastname'
        )
        ->get();

    $passed = $results->where('average_score', '>=', 50)->count();

    $failed = $results->where('average_score', '<', 50)->count();

    $passRate = $students > 0
        ? round(($passed / $students) * 100, 2)
        : 0;

    $averageScore = round($results->avg('average_score'), 2);

    $topStudents = $results
        ->sortByDesc('average_score')
        ->take(10);

    $bottomStudents = $results
        ->sortBy('average_score')
        ->take(10);

    $subjectPerformance = Assessment::join(
            'subjects',
            'subjects.id',
            '=',
            'assessments.subject_id'
        )
        ->join(
            'students',
            'students.id',
            '=',
            'assessments.student_id'
        )
        ->where('students.school_id', $schoolId)
        ->where('students.class_id', $classId)
        ->select(
            'subjects.subjectName as subject_name',
            DB::raw('COUNT(DISTINCT students.id) as students'),
            DB::raw("AVG($formula) as average")
        )
        ->groupBy(
            'subjects.id',
            'subjects.subjectName'
        )
        ->get();

    foreach ($subjectPerformance as $subject) {

        $passedStudents = Assessment::join(
                'students',
                'students.id',
                '=',
                'assessments.student_id'
            )
            ->join(
                'subjects',
                'subjects.id',
                '=',
                'assessments.subject_id'
            )
            ->where('students.school_id', $schoolId)
            ->where('students.class_id', $classId)
            ->where(
                'subjects.subjectName',
                $subject->subject_name
            )
            ->whereRaw("$formula >= 50")
            ->count();

        $subject->pass_rate =
            $subject->students > 0
            ? round(
                ($passedStudents / $subject->students) * 100,
                2
            )
            : 0;
    }

    return view(
        'studentperformance',
        compact(
            'school',
            'classes',
            'classId',
            'students',
            'passed',
            'failed',
            'passRate',
            'averageScore',
            'subjectPerformance',
            'topStudents',
            'bottomStudents'
        )
    );
}

    public function sendReport(Request $request)
{
    Report::create([
        'supervisor_id' => Auth::id(),
        'school_id' => $request->school_id,
        'class_room_id' => $request->class_id,
        'report_type' => 'Student Performance',
        'report_date' => now(),
        'average_score' => $request->average_score,
        'pass_rate' => $request->pass_rate,
        'total_students' => $request->students,
        'passed_students' => $request->passed,
        'failed_students' => $request->failed,
        'comments' => $request->comments,
    ]);

    return back()->with(
        'success',
        'Report sent successfully to Admin'
    );
}


    public function adminSyllabusReport(Request $request)
{
    $subjectId = $request->input('subject_id');
    $schoolId  = $request->input('school_id');

    // Kama hajachagua school au subject
    if (!$subjectId || !$schoolId) {
        return view('report2', [
            'topicsReport' => collect()
        ]);
    }

    // Chukua subject pamoja na class yake
    $subject = DB::table('subjects')
        ->where('id', $subjectId)
        ->first();

    if (!$subject) {
        return back()->with('error', 'Subject not found.');
    }

    $classId = $subject->class_room_id;

    // Chukua topic zote za subject
    $topics = DB::table('topics')
        ->where('subject_id', $subjectId)
        ->get();

    $topicsReport = collect();

    foreach ($topics as $topic) {

        // Jumla ya Sub Topics
        $totalSubTopics = DB::table('sub_topics')
            ->where('topic_id', $topic->id)
            ->count();

        // Zilizokamilika
        $completedSubTopics = DB::table('lesson_plans')
            ->join('subjects', 'lesson_plans.subject_id', '=', 'subjects.id')
            ->where('lesson_plans.school_id', $schoolId)
            ->where('subjects.class_room_id', $classId)
            ->where('lesson_plans.subject_id', $subjectId)
            ->where('lesson_plans.topic_id', $topic->id)
            ->where('lesson_plans.status', 'completed')
            ->distinct('lesson_plans.sub_topic_id')
            ->count('lesson_plans.sub_topic_id');

        if ($totalSubTopics > 0 && $completedSubTopics >= $totalSubTopics) {

            $status = 'Covered';
            $badgeColor = 'success';

        } else {

            $status = 'Uncovered';
            $badgeColor = 'danger';

        }

        $progress = $totalSubTopics > 0
            ? round(($completedSubTopics / $totalSubTopics) * 100, 1)
            : 0;

        $topicsReport->push([
            'topic_name' => $topic->topic_name,
            'total_sub_topics' => $totalSubTopics,
            'completed_sub_topics' => $completedSubTopics,
            'status' => $status,
            'badge_color' => $badgeColor,
            'progress' => $progress
        ]);
    }

    return view('report2', compact(
        'topicsReport',
        'subjectId',
        'schoolId'
    ));
}
    public function adminSupervisorReports(Request $request)
{
    $schoolId = $request->input('school_id'); 
    $query = DB::table('reports')
        ->join('schools', 'reports.school_id', '=', 'schools.id')
        ->join('class_rooms', 'reports.class_room_id', '=', 'class_rooms.id')
        ->join('system_users', 'reports.supervisor_id', '=', 'system_users.id') 
        ->select(
            'reports.*',
            'schools.school_name',
            'class_rooms.class_name',
             DB::raw("CONCAT(system_users.firstname, ' ', system_users.middlename, ' ', system_users.lastname) as supervisor_name")
        );

    
    if ($schoolId) {
        $query->where('reports.school_id', $schoolId);
    }

    
    $reports = $query->orderBy('reports.created_at', 'desc')->get();

    return view('adminreport', compact('reports', 'schoolId'));
}

    public function getTeacherWorkbookReport(Request $request) {
    $schoolId = $request->input('school_id');
    $classId = $request->input('class_id');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    if (!$schoolId || !$startDate || !$endDate) {
        return view('teacherperf', ['teachersReport' => []]);
    }

    
    $query = DB::table('system_users as u')
        ->join('subjects as s', 'u.id', '=', 's.teacher_id')
        ->join('class_rooms as cr', 's.class_room_id', '=', 'cr.id')
        ->where('u.role', 'teacher')
        ->where('u.status', 'Active')
        ->where('cr.school_id', $schoolId);

    if ($classId) {
        $query->where('cr.id', $classId);
    }

    $records = $query->select(
        'u.id as teacher_id',
        DB::raw("CONCAT(u.firstname, ' ', u.middlename, ' ', u.lastname) as teacher_name"),
        's.id as subject_id',
        's.subjectName as subject_name',
        'cr.class_name'
    )->get();

    $teachersReport = [];

    foreach ($records as $row) {
        
        $periodsTaught =DB::table('daily_recordings')
            ->where('teacher_id', $row->teacher_id)
            ->where('subject_id', $row->subject_id)
            ->whereBetween('date', [$startDate, $endDate])
            ->count();

       
        $lessonPlans = DB::table('lesson_plans')
            ->where('subject_id', $row->subject_id)
            ->whereBetween('lesson_date', [$startDate, $endDate])
            ->count();

        
        $completedPlans = DB::table('lesson_plans')
            ->where('subject_id', $row->subject_id)
            ->where('status', 'completed')
            ->whereBetween('lesson_date', [$startDate, $endDate])
            ->count();

        $progress = $lessonPlans > 0 ? round(($completedPlans / $lessonPlans) * 100) : 0;

       
        if ($periodsTaught > 5 && $progress >= 75) {
            $status = 'Excellent';
            $color = 'success';
        } elseif ($periodsTaught > 0) {
            $status = 'Satisfactory';
            $color = 'warning';
        } else {
            $status = 'Inactive';
            $color = 'danger';
        }

        $teachersReport[] = [
            'teacher_name' => $row->teacher_name,
            'subject_name' => $row->subject_name,
            'class_name' => $row->class_name,
            'total_periods_taught' => $periodsTaught,
            'total_lesson_plans' => $lessonPlans,
            'progress' => $progress,
            'status' => $status,
            'badge_color' => $color
        ];
    }

    return view('teacherperf', compact('teachersReport'));
}
}
