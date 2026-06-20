<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonPlanStage extends Model
{
    protected $fillable = [
        'lesson_plan_id',
        'stage_name',
        'minutes',
        'teaching_activities',
        'learning_activities',
        'assessment',
    ];

    public function lessonPlan()
    {
        return $this->belongsTo(LessonPlan::class);
    }
}
