<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        "firstname",
        "middlename",
        "lastname",
        "gender",
        "class_id",
        "school_id"
    ];
    public function classRoom()
{
    return $this->belongsTo(ClassRoom::class, 'class_id');
}

    public function assessments()
{
    return $this->hasMany(Assessment::class);
}
   public function School(){
    return $this->belongsTo(School::class,"school_id");

   }
}
