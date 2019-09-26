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
        $timesheet = Timesheet::where([
            ['date', '=', Carbon::parse($this->date_time)],
            ['user_id', '=' ,$this->user_id]
        ])->first();
        
        if($timesheet == null)
        {
            // TODO :  Chưa có timesheet nào cho attendance này, cần update

        }else
        {
            // TODO : Update timesheet này
            if($timesheet->morning_shift == 'X' && $timesheet->afternoon_shift == 'X')
            {
                $this->timesheet_id = $timesheet->id;
                $this->is_check = 'Y';
            }else
            {

            }
        }

        $this->save();
    }

    public static function processNewData()
    {
        $attendance = Attendance::where('is_check', 'N')->first();

        // $a1 = $attendance[0];
        // $a2 = $attendance[1];

        // echo $a1 ."</br>" .$a2 ."</br>";

        // $var1 = Carbon::create($a1->date_time);
        // $var2 = Carbon::create($a2->date_time);

        // if($var1->lt($var2))
        // {
        //     echo 'yes';
        // }else
        // {

        // }
        
        while($attendance != null){
            $user = $attendance->user_id;
            $date_time = $attendance->date_time; 
    
            $date = Carbon::create($date_time)->format('Y-m-d');

            $timesheet = Timesheet::where([
                ['date', '=', $date],
                ['user_id', '=', $user]
            ])->first();
    
            if($timesheet == null){
                $timesheet = new Timesheet();
                $timesheet->user_id = $user;
                $timesheet->date = $date;
                $timesheet->morning_shift = 'V';
                $timesheet->afternoon_shift = 'V';
                $timesheet->save();
            }

            $timesheet->processAttendanceBelongTo();

            $timesheet->save();

            $attendance = Attendance::where('is_check', 'N')->first();
         }

     


        // while($attendance != null){
            
        //     $user = $attendance->user_id;
        //     $date_time = $attendance->date_time;

        //     Carbon::create($date_time);




        //     $timesheet = Timesheet::where()->first();
        //     $attendance = Attendance::where('is_check', 'N')->first();
        // }

    }

    public function earlyThan($attendance)
    {
        $time1 = Carbon::create($this->date_time)->toTimeString();
        $time2 = Carbon::create($attendance->date_time)->toTimeString();
        if(strtotime($time1) < strtotime($time2))
            return true;
        else
            return false;
    }

    public function laterThan($attendance)
    {
        $time1 = Carbon::create($this->date_time)->toTimeString();
        $time2 = Carbon::create($attendance->date_time)->toTimeString();
        if(strtotime($time1) > strtotime($time2))
            return true;
        else
            return false; 
    }

}
