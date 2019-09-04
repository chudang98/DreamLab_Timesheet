<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $fillable = [ 
        'id', 'date_time', 'timesheets_id', 'users_id', 'attendance_machines_id' 
    ];

    public function users_id(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function attendance_machines_id(){
        return $this->belongsTo(AttendanceMachine::class, 'attendance_machines_id');
    }

    public function timesheets_id(){
        return $this->belongsTo(Timesheet::class, 'timesheets_id');
    }
}
