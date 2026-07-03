<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyRecording extends Model
{
    protected $fillable = [

        'teacher_id',
        'school_id',
        'date',
        'subject_id',
        'period',
        'main_topic',
        'work_done_by_teacher',
        'work_done_by_student',
        'remarks',
        'status',
        'comments'
    ];

     public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function subject(){
        return $this->belongsTo(Subject::class,"subject_id");
    }
}
