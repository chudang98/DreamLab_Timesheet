<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Timesheet extends Model
{
    /*
        morning_shift = 'M, V, X'
        afternoon_shift = 'M, V, S, X'

        UPDATE attendances
        SET is_check = 'N'
        WHERE is_check = 'Y'

    */
    private static $LATE_TIME_MORNING = '8:30:00';
    private static $ABSENT_MORNING = '9:00:00';

    private static $LATE_TIME_AFTERNOON = '13:00:00';
    private static $LEAVE_EARLY_AFTERNOOM = '16:30:00';
    private static $END_AFTERNOON = '17:00:00';

    private $late_min = 0;
    private $early_min = 0;

    protected $fillable = [
        'id', 'date', 'morning_shift', 'afternoon_shift', 'user_id'
    ];


    public $timestamps = false;


    public function attendances(){
        return $this->hasMany(Attendance::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


    // $date as string
    public function processAttendanceBelongTo(){
        $time = $this->date;

        $start_date = Carbon::create($time .' 00:00:00');
        $end_date = Carbon::create($time .' 23:59:59');

            // Lấy tất cả các attendances trong ngày này
        $attendances = Attendance::where([
                ['user_id', '=', $this->user_id],
                ['date_time', '>=', $start_date],
                ['date_time', '<=', $end_date],
                ['is_check', '=', 'N'],

        ])->get();

        
            // Timesheets này không có attendance nào mới        
        if($attendances->isEmpty() != true)
        {
            $check_in = $attendances[0];
            $check_out = $attendances[0];
            $count = sizeof($attendances);

            if($count > 1)
            {
                for($i = 0; $i < $count; $i++)
                {
                    $attendances[$i]->timesheet_id = $this->id;
                    if($check_in->earlyThan($attendances[$i]) == false){
                        $check_in = $attendances[$i];
                    }
                    else
                    {
                        if($check_out->earlyThan($attendances[$i]) == false){
                            $check_in = $attendances[$i];
                        }
                    }

                    $attendances[$i]->timesheet_id = $this->id;
                    $attendances[$i]->is_check = 'Y';
                    $attendances[$i]->save();
                }

                $this->processCiCoAttendance($check_in, $check_out);

            }else
                // Chỉ có 1 attendance
                $this->processOneAttendance($check_in);
        }

        $this->save();                
    }


    public function preprocessData($month, $yeah){
        
    }


    private function processCiCoAttendance($check_in, $check_out)
    {
        $CI_time = Carbon::create($check_in->date_time)->toTimeString();
        $CO_time = Carbon::create($check_out->date_time)->toTimeString();
        switch($this->morning_shift){
            case 'X' : 
            {
                switch($this->afternoon_shift){
                    case 'V' : {
                       if(strtotime($CO_time) >= strtotime(static::$END_AFTERNOON))
                       {
                    		$this->afternoon_shift = 'X';
                       }else
                       {
                            if(strtotime($CO_time) >= strtotime(static::$LEAVE_EARLY_AFTERNOOM))
                            {
                                $this->morning_shift = 'S';
                            }
                       }

                        break;
                    }
                    case 'S' : {
                        if(strtotime($CO_time) >= strtotime(static::$END_AFTERNOON))
                        {
                            $this->afternoon_shift = 'X';
                        }
                        break;
                    }
                }
                break;
            }

            case 'M' : 
            {
                    // Check lại buổi sáng
                if(strtotime($CI_time) <= strtotime(static::$LATE_TIME_MORNING))
                {
                     $this->morning_shift = 'X';
                }

                    // check chiều
                switch($this->afternoon_shift)
                {
                    case 'V' : {
                       if(strtotime($CO_time) >= strtotime(static::$END_AFTERNOON)){
                           $this->afternoon_shift = 'X';
                       }else
                       {
                            if(strtotime($CO_time) >= strtotime(static::$LEAVE_EARLY_AFTERNOOM))
                            {
                                $this->afternoon_shift = 'S';
                            }
                       }
                        break;
                    }
                    case 'S' : {
                        if(strtotime($CO_time) >= strtotime(static::$END_AFTERNOON)){
                            $this->afternoon_shift = 'X';
                        }
                        break;
                    }
                }
                break;
            }

            case 'V' : 
            {
                    // Check buổi sáng có đi làm hay không
                if(strtotime($CI_time) <= strtotime(static::$LATE_TIME_MORNING))
                {
                     $this->morning_shift = 'X';
                }else
                {
                    if(strtotime($CI_time) <= strtotime(static::$ABSENT_MORNING))
                    {
                         $this->morning_shift = 'M';
                    }
                }
                    // check chiều - check lại sáng
                switch($this->afternoon_shift){
                    case 'V' : {
                        if(strtotime($CI_time) <= static::$LATE_TIME_AFTERNOON
                                || $this->morning_shift != 'V')
                        {
                            if(strtotime($CO_time) >= static::$END_AFTERNOON)
                                $this->afternoon_shift = 'X';
                            else
                            {
                                if(strtotime($CO_time) >= static::$LEAVE_EARLY_AFTERNOOM)
                                    $this->afternoon_shift = 'M';
                            }
                        }
                        break;
                    }
                    case 'S' : {
                        if(strtotime($CO_time) >= strtotime(static::$END_AFTERNOON))
                        {
                            $this->afternoon_shift = 'X';
                        }
                        break;
                    }

                    case 'M' : {
                        if(strtotime($CI_time) <= static::$LATE_TIME_AFTERNOON
                            || $this->morning_shift != 'V')
                        {
                            $this->afternoon_shift = 'X';
                        }
                        break;
                    }
                }

                break;
            }
        }
    }

    private function processOneAttendance($attendance)
    {
        $time = Carbon::create($attendance->date_time)->toTimeString();
        switch($this->morning_shift){
            case 'X' : {
                if(strtotime($time) >= strtotime(static::$LEAVE_EARLY_AFTERNOOM))
                {
                    if(strtotime($time) >= strtotime(static::$END_AFTERNOON))
                        $this->afternoon_shift = 'X';
                    else
                        if(strtotime($time) >= strtotime(static::$LEAVE_EARLY_AFTERNOOM) && $this->afternoon != 'X')
                            $this->afternoon_shift = 'S';
                }

                break;
            }

            case 'M' : {
                if(strtotime($time) <= strtotime(static::$LATE_TIME_MORNING)){
                    $this->morning_shift = 'X';
                }else{

                    switch($this->afternoon_shift)
                    {
                        case 'V' : {
                            if(strtotime($time) >= strtotime(static::$END_AFTERNOON))
                                $this->afternoon_shift = 'X';
                            else
                                if(strtotime($time) >= strtotime(static::$LEAVE_EARLY_AFTERNOOM))
                                    $this->afternoon_shift = 'S';

                            break;
                        }
                        case 'S' : {
                            if(strtotime($time) >= strtotime(static::$END_AFTERNOON))
                                $this->afternoon_shift = 'X';
                            break;
                        }
                    }
                    break;
                }
            }

            case 'V' : {
                if(strtotime($time) <= strtotime(static::$LATE_TIME_MORNING)){
                    $this->morning_shift = 'X';
                }else
                {
                    if(strtotime($time) <= strtotime(static::$ABSENT_MORNING)){
                        $this->morning_shift = 'M';
                    }
                }
                break;
            }
        }
    }

}
