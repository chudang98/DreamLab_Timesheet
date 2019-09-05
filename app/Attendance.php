<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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


    /*
        Chỉ sử dụng phương thức này cho những attendance chưa được cập nhập
    */
    public function updateTimesheet()
    {
        $user = $this->user;
        $date = Carbon::create($this->date_time)->toDateString();
        $timesheet = Timesheet::where([
            ['user_id', $user->id],
            ['date', $date]
        ])->first();

        // TODO : Create new timesheet for this attendance
        if($timesheet == null)
        {
            $timesheet = new Timesheet();

            // All attendances related this timesheet and there isn't check
            $attendances = Attendance::where([
                ['user_id', $user->id],
                ['date', $date],
            ])->get();

            $timesheet->process($attendances);

        }else
        {

            // TODO : Update timesheet
            $timesheet->update($this);

            // TODO : take all attendance that related to this timesheet
            
        }

        $timesheet->save();
        $this->save();
    }

    public function earlyThan($attendance){
        $time1 = Carbon::create($this->date)->toTimeString();
        $time2 = Carbon::create($attendance->date)->toTimeString();
        if(strtotime($time1) < strtotime($time2))
        {
            return false;
        }else
        {
            return true;
        }
    }
}
