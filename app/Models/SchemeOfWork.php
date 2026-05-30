<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchemeOfWork extends Model
{
    protected $fillable = [
        'subject_id',
        'academic_year',
        'term',
        'main_competence',
        'specific_competence',
        'learning_activity',
        'specific_activity',
        'month',
        'week',
        'period',
        'teaching_method',
        'learning_resource',
        'assessment_tool',
        'reference',
        'remarks'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}