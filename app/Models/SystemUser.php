<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;


use Illuminate\Database\Eloquent\Model;

class SystemUser extends Authenticatable
{
    protected $fillable = [
        "firstname",
        "middlename",
        "lastname",
        "email",
        "gender",
        "role",
        "school_id",
        "district_id",
        "password"
    ];
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function subjects()
{
    return $this->hasMany(Subject::class, 'teacher_id');
}
}
