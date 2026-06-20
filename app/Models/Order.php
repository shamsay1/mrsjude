<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'supervisor_id',
        'school_id',
        'instruction',
        'inspection_date',
        'status',
    ];

    protected $casts = [
        'inspection_date' => 'date',
    ];

    /**
     * Supervisor assigned to inspect the school.
     */
    public function supervisor()
    {
        return $this->belongsTo(SystemUser::class, 'supervisor_id');
    }

    /**
     * School to be inspected.
     */
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}