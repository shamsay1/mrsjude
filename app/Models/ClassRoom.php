<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    protected $fillable = [
        "class_name",
        "class_level",
        "school_id",

    ];

    public function school(){
        return $this->belongsTo(School::class,"school_id");
    }
    public function subjects()
{
    return $this->hasMany(Subject::class);
}
}
