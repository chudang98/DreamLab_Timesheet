<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceMachine extends Model
{
    protected $fillable = ['id', 'name'];

    //
    public function attendances(){
        return $this->hasMany(Attendance::class, 'attendance_machines_id');
    }

    public function users(){
        return $this->hasMany(User::class, 'attendance_machines_id');
    }
}
