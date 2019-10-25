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
        'id', 'date', 'morning_shift', 'afternoon_shift', 'user_id', 'check_in', 'check_out'
    ];


    public $timestamps = false;


    public function attendances(){
        return $this->hasMany(Attendance::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


    public function getCOAttendance()
    {
        $start_date = Carbon::create($this->date);
        $start_date->hour = 0;
        $start_date->minute = 0;
        $start_date->second = 0;
        $end_date = Carbon::create($this->date);
        $end_date->hour = 23;
        $end_date->minute = 59;
        $end_date->second = 59;

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

    public function checkDayOff(){
        // Là ngày thứ 7, CN hoặc các ngày nghỉ đã được chú thích 
        $day = Carbon::create($this->date)->shortEnglishDayOfWeek;
        
        $check_day = Day::where('date', $this->date)->first();
            //Check xem có phải ngày đặc biệt có chú thích không
        if($check_day != null)
        {
            if($check_day->state == 'off')
                return true;
            else
                return false;

        }else
            if($day == 'Sat' || $day == 'Sun')
            {
                return true;
            }else
                return false;
    }

    public function checkTimeBreak(){
        $check_day = Day::where('date', $this->date)->first();
        
    }

    public function convertObjExcel(){
        if($this->checkDayOff() == true){
            return $obj = [
                'S' => 'N',
                'C' => 'N',
            ];
        }else{

        }

        return $obj = [
            'S' => $this->morning_shift,
            'C' => $this->afternoon_shift
        ];
    }


    public static function getTimesheetByAttendance($attendance){
        $user = $attendance->user_id;
        $date_time = $attendance->date_time;

        $date = Carbon::create($date_time)->format('Y-m-d');

        $timesheet = Timesheet::where([
            ['date', '=', $date],
            ['user_id', '=', $user]
        ])->first();

        return $timesheet;
    }

    public static function saveNewByAttendance($attendance){
        $timesheet = new Timesheet();
        $timesheet->user_id = $attendance->user_id;
        $timesheet->date = $attendance->date_time;
        $timesheet->morning_shift = 'V';
        $timesheet->afternoon_shift = 'V';
        $timesheet->save();
        return $timesheet;
    }





}
