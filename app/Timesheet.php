<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    //
    protected $fillable = [
        'id', 'date', 'morning_shift', 'afternoon_shift', 'users_id'
    ];
}
