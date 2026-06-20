<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonPlan extends Model
{
    protected $fillable = [
        'subject_id',
        'topic_id',
        'sub_topic_id',
        'objectives',
        'teaching_methods',
        'teaching_materials',
        'evaluation',
        'lesson_date',
        'class_room_id',
        'school_id',
        'status'
    ];
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function subTopic()
    {
        return $this->belongsTo(SubTopic::class);
    }
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function class_room()
    {
        return $this->belongsTo(ClassRoom::class);
    }
    public function stages()
{
    return $this->hasMany(LessonPlanStage::class);
}
}
