<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'attendance_number', 'department', 'attendance_machine_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function attendanceMachine(){
        return $this->belongsTo(AttendanceMachine::class, 'attendance_machine_id');
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }

    public function attendances(){
        return $this->hasMany(Attendance::class);
    }

    public function timesheets(){
        return $this->hasMany(Timesheet::class);
    }
}

