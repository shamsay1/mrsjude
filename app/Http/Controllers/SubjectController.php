<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\SubTopic;
use App\Models\SystemUser;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $classes = ClassRoom::where('school_id', $user->school_id)->get();

    $teachers = SystemUser::where('school_id', $user->school_id)
        ->where('role', 'teacher')
        ->get();
   $subjects = Subject::with(['classRoom', 'teacher'])
    ->whereHas('classRoom', function ($q) use ($user) {
        $q->where('school_id', $user->school_id);
    })
    ->join('class_rooms', 'subjects.class_room_id', '=', 'class_rooms.id')
    ->orderBy('class_rooms.class_name', 'asc')
    ->select('subjects.*')
    ->get()
    ->groupBy('class_room_id');

    return view('subjects', compact('subjects', 'classes', 'teachers'));
}

    // Store Data
    public function store(Request $request)
{
    try {

        $request->validate([
            'subjectName'   => 'required',
            'subjectCode'   => 'required',
            'class_room_id' => 'required',
            'teacher_id'    => 'required'
        ]);

        DB::beginTransaction();

        // Save Subject
        $subject = Subject::create([
            'subjectName'   => $request->subjectName,
            'subjectCode'   => $request->subjectCode,
            'class_room_id' => $request->class_room_id,
            'teacher_id'    => $request->teacher_id
        ]);

        $notes = require storage_path('app/notes.php');

       
        $subjectName = strtoupper(trim($subject->subjectName));
        $className = $subject->classRoom->class_name;

        // Angalia kama syllabus ipo
        if (isset($notes[$subjectName]) && isset($notes[$subjectName][$className])) {

            foreach ($notes[$subjectName][$className] as $topicName => $subTopics) {

                $topic = Topic::create([
                    'subject_id' => $subject->id,
                    'topic_name' => $topicName
                ]);

                foreach ($subTopics as $subTopicName) {

                    SubTopic::create([
                        'topic_id' => $topic->id,
                        'sub_topic_name' => $subTopicName
                    ]);

                }

            }

        }

        DB::commit();

        return redirect()->back()
            ->with('success', 'Subject added successfully');

    } catch (Exception $e) {

        DB::rollBack();

        return redirect()->back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}
    public function update(Request $request, $id)
{
    $request->validate([
        'subjectName' => 'required|string|max:255',
        'subjectCode' => 'required|string|max:100',
        'class_room_id' => 'required|exists:class_rooms,id',
        'teacher_id' => 'required|exists:system_users,id',
    ]);

    $subject = Subject::findOrFail($id);

    $subject->update([
        'subjectName' => $request->subjectName,
        'subjectCode' => $request->subjectCode,
        'class_room_id' => $request->class_room_id,
        'teacher_id' => $request->teacher_id,
    ]);

    return redirect()->back()->with('success', 'Subject updated successfully.');
}

    public function destroy($id)
{
    $subject = Subject::findOrFail($id);

    $subject->delete();

    return redirect()->back()->with('success', 'Subject deleted successfully.');
}
}
