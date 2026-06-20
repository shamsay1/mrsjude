<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class SystemUser extends Authenticatable
{
    use Notifiable;
    protected $fillable = [
        "firstname",
        "middlename",
        "lastname",
        "email",
        "gender",
        "role",
        "school_id",
        "password",
        "status"
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
    public function orders()
{
    return $this->hasMany(Order::class, 'supervisor_id');
}
}
