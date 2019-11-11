<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use App\Events\AddNewAttendance;

class Attendance extends Model
{
    //



    protected $fillable = 
    [ 
        'id', 'date_time', 'timesheet_id', 'user_id', 'attendance_machine_id' 
    ];

    public $timestamps = false;




    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function attendance_machine()
    {
        return $this->belongsTo(AttendanceMachine::class, 'attendance_machine_id');
    }

    public function timesheet()
    {
        return $this->belongsTo(Timesheet::class, 'timesheet_id');
    }

    

    public static function getFirstAttendanceNew(){
        $result = Attendance::where('is_check', '=', 'N')->first();
        return $result;
    }

    public function updateByTimesheet($timesheet){
        $this->timesheet_id = $timesheet->id;
        $this->is_check = 'Y';
        $this->save();
    }


}
