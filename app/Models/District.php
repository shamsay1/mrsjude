<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        "district_name",
        "status"
    ];
    public function schools()
{
    return $this->hasMany(School::class,'district_id');
}
}
