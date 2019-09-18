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
    private static $ABSENT_AFTERNOON = '14:00:00';
    private static $LEAVE_EARLY_AFTERNOOM = '16:30:00';
    private static $END_AFTERNOON = '17:00:00';

    // Tính theo số buổi
    public $count_late;
    public $count_early;

    public $count_worked;
    public $count_off;

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


    public function getCOAttendance(){
        $time = $this->date;

        $start_date = Carbon::create($time .' 00:00:00');
        $end_date = Carbon::create($time .' 23:59:59');

        $attendances = Attendance::where([
            ['user_id', '=', $this->user_id],
            ['date_time', '>=', $start_date],
            ['date_time', '<=', $end_date],
        ])->get();

        if($attendances->isEmpty() != true)
        {
            $check_out = $attendances[0];
            $count = sizeof($attendances);
            for($i = 0; $i < $count; $i++)
            {
                $attendances[$i]->timesheet_id = $this->id;
                if($attendances[$i]->laterThan($check_out) == true){
                    $check_out = $attendances[$i];
                }
            }

            return $check_out;            
        }
        return null;
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
                // ['is_check', '=', 'N'],

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
                    if($attendances[$i]->earlyThan($check_in) == true){
                        $check_in = $attendances[$i];
                    }else
                    {
                        if($attendances[$i]->laterThan($check_out) == true){
                            $check_out = $attendances[$i];
                        }
                    }

                    $attendances[$i]->timesheet_id = $this->id;
                    $attendances[$i]->is_check = 'Y';

                    $attendances[$i]->save();
                }

                $this->processCiCoAttendance($check_in, $check_out);

            }else{
                // Chỉ có 1 attendance
                $this->processOneAttendance($check_in);
                $check_in->save();
            }
        }

        $this->save();                
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
                        // check lại được buổi sáng đi làm hoặc đi làm trước giờ ca chiều
                        if(strtotime($CI_time) <= strtotime(static::$LATE_TIME_AFTERNOON)
                                || $this->morning_shift != 'V')
                        {
                            if(strtotime($CO_time) >= strtotime(static::$END_AFTERNOON))
                                $this->afternoon_shift = 'X';
                            else
                            {
                                if(strtotime($CO_time) >= strtotime(static::$LEAVE_EARLY_AFTERNOOM))
                                    $this->afternoon_shift = 'S';
                            }
                        }else
                            // Chắc chắn là đi làm chiều bị muộn
                        {
                            if(strtotime($CI_time) <= strtotime(static::$ABSENT_AFTERNOON))
                                if(strtotime($CO_time) >= strtotime(static::$END_AFTERNOON ))
                                    $this->afternoon_shift = 'M';
                                else
                                {
                                    if(strtotime($CO_time) >= strtotime(static::$LEAVE_EARLY_AFTERNOOM))
                                        $this->afternoon_shift = 'S';
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
                        if(strtotime($CI_time) <= strtotime(static::$LATE_TIME_AFTERNOON)
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

    public function processInfor(){
      /*   $this->count_worked = 0;
        if($this->morning_shift != 'X')
            $this->count_worked++;
        if($this->afternoon_shift != 'X')
            $this->count_worked++; */
    }

 /*    public function processInfor()
    {
        $this->count_early = 0;
        $this->count_late = 0;
        $this->count_off = 0;
        $this->count_worked = 0;
        
        if($this->morning_shift == 'M')
        {
            $this->count_late += 1;
        }
        if($this->afternoon_shift == 'M')
        {
            $this->count_late += 1;
        }
        if($this->afternoon_shift == 'S')
        {
            $this->count_early += 1;
        }
        if($this->morning_shift == 'X')
            $this->count_worked += 1;
        if($this->afternoon_shift == 'X')
            $this->count_worked += 1;

        if($this->morning_shift == 'V')
            $this->count_off += 1;
        if($this->afternoon_shift == 'V')
            $this->count_off += 1;
    } */


    private function processOneAttendance($attendance)
    {
        $time = Carbon::create($attendance->date_time)->toTimeString();
        switch($this->morning_shift){
            case 'X' : {
                switch($this->afternoon_shift){
                    case 'S' : {
                        if(strtotime($time) >= strtotime(static::$END_AFTERNOON))
                            $this->afternoon_shift = 'X';
                        break;
                    }
                    case 'V' : {
                        if(strtotime($time) >= strtotime(static::$END_AFTERNOON))
                            $this->afternoon_shift = 'X';
                        else
                            if(strtotime($time) >= strtotime(static::$LEAVE_EARLY_AFTERNOOM))
                                $this->afternoon_shift = 'S';
                        break;
                    }
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
                $check_out = $this->getCOAttendance();

                if($attendance->earlyThan($check_out) == true){
                    $this->processCiCoAttendance($attendance, $check_out);
                }else
                    if($check_out->laterThan($attendance) == true)
                        $this->processCiCoAttendance($check_out, $attendance);
                    else{
                        // Cả timesheet đó chỉ có duy nhất 1 attendance
                        if(strtotime($time) <= strtotime(static::$LATE_TIME_MORNING))
                        {
                            $this->morning_shift = 'X';
                        }else
                        {
                            if(strtotime($time) <= strtotime(static::$ABSENT_AFTERNOON)){
                                $this->morning_shift = 'M';
                            }
                        }
                    }

                break;
            }   
        }        
    }

}
