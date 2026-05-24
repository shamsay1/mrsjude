<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonPlan extends Model
{
    protected $fillable = [
        'subject_id',
        'topic',
        'subtopic',
        'objectives',
        'teaching_methods',
        'teaching_materials',
        'evaluation',
        'lesson_date',
        'status'
    ];
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
