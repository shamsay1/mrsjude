<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',

        'classwork1',
        'classwork2',
        'classwork3',
        'classwork4',
        'classwork5',
        'classwork6',
        'classwork7',
        'classwork8',
        'classwork9',
        'classwork10',

        'homework1',
        'homework2',
        'homework3',
        'homework4',
        'homework5',

        'topictest1',
        'topictest2',
        'topictest3',

        'terminal_exam'
    ];

    /**
     * Student relationship
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Subject relationship
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Average Classwork
     */
    public function getClassworkAverageAttribute()
    {
        $marks = collect([
            $this->classwork1,
            $this->classwork2,
            $this->classwork3,
            $this->classwork4,
            $this->classwork5,
            $this->classwork6,
            $this->classwork7,
            $this->classwork8,
            $this->classwork9,
            $this->classwork10,
        ])->filter();

        return $marks->count() > 0
            ? round($marks->avg(), 2)
            : 0;
    }

    /**
     * Average Homework
     */
    public function getHomeworkAverageAttribute()
    {
        $marks = collect([
            $this->homework1,
            $this->homework2,
            $this->homework3,
            $this->homework4,
            $this->homework5,
        ])->filter();

        return $marks->count() > 0
            ? round($marks->avg(), 2)
            : 0;
    }

    /**
     * Average Topic Test
     */
    public function getTopicTestAverageAttribute()
    {
        $marks = collect([
            $this->topictest1,
            $this->topictest2,
            $this->topictest3,
        ])->filter();

        return $marks->count() > 0
            ? round($marks->avg(), 2)
            : 0;
    }

    /**
     * Total Score
     */
    public function getTotalMarksAttribute()
    {
        return
            $this->classwork_average +
            $this->homework_average +
            $this->topic_test_average +
            ($this->terminal_exam ?? 0);
    }

    /**
     * Grade
     */
    public function getGradeAttribute()
    {
        $total = $this->total_marks;

        if ($total >= 81) {
            return 'A';
        } elseif ($total >= 61) {
            return 'B';
        } elseif ($total >= 41) {
            return 'C';
        } elseif ($total >= 21) {
            return 'D';
        }

        return 'F';
    }
}
