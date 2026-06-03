<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        "school_name",
        "school_code",
        "district_id",
        "status"
    ];

     public function district()
    {
        return $this->belongsTo(District::class);
    }
}
