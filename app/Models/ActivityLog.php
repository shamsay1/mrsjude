<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [

        'module',

        'action',

        'description',

        'ip_address',

        'browser',

        'platform',

        'device'

    ];

    
}