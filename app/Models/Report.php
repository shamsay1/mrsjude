<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    /**
     * Table inayohusishwa na model hii.
     * (Laravel inajua automatic kuwa ni 'reports', lakini ni vizuri kuifafanua)
     */
    protected $table = 'reports';

    /**
     * Columns zinazoruhusiwa kujazwa kwa pamoja (Mass Assignment).
     */
    protected $fillable = [
        'supervisor_id',
        'school_id',
        'class_room_id',
        'title',
        'report_type',
        'report_date',
        'average_score',
        'pass_rate',
        'total_students',
        'passed_students',
        'failed_students',
        'comments',
        'status',
    ];

    /**
     * Kugeuza data kuwa format maalum (Casting).
     */
    protected $casts = [
        'report_date' => 'date',
        'average_score' => 'decimal:2',
        'pass_rate' => 'decimal:2',
        'total_students' => 'integer',
        'passed_students' => 'integer',
        'failed_students' => 'integer',
    ];

    
    public function supervisor(): BelongsTo
    {
        // Badilisha 'User::class' kuwa Model halisi ya supervisor wako kama tofauti
        return $this->belongsTo(SystemUser::class, 'supervisor_id');
    }

    /**
     * Ripoti hii ni ya Shule fulani.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    /**
     * Ripoti hii ni ya Darasa fulani.
     */
    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'class_room_id');
    }
}