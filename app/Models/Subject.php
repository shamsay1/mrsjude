<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        "subjectName",
        "subjectCode",
        "class_room_id",
        "teacher_id"
    ];
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function teacher()
    {
        return $this->belongsTo(SystemUser::class, 'teacher_id');
    }
}
