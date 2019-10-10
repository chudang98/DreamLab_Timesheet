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

    public static function deleteAttendance($id){
        Attendance::where('id', $id)
            ->delete();
    }

    public static function processNewData()
    {
        $attendance = Attendance::where('is_check', 'N')->first();

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

    //get các bản ghi theo time
    public static function getByTime($times){
        $attendances = Attendance::whereBetween('date_time', [(Carbon::createFromFormat("d/m/Y", $times[0])
            ->format("Y-m-d 00:00:00")),
            (Carbon::createFromFormat("d/m/Y", $times[1])->format("Y-m-d 23:59:59"))])
            ->orderBy('date_time', 'desc')
            ->paginate(20);
        return $attendances;
    }

    //get các bản ghi theo time và emloyee
    public static function getByTimeAndEmployee($times, $employee){
        $attendances = Attendance::with('user')
            ->whereHas('user', function ($query) use($employee) {
                $query->where('employee_id', 'LIKE', "%{$employee}%")
                    ->orWhere('name', 'LIKE', "%{$employee}%");
            })
            ->whereBetween('date_time', [(Carbon::createFromFormat("d/m/Y", $times[0]))->format("Y-m-d 00:00:00"),
                (Carbon::createFromFormat("d/m/Y", $times[1]))->format("Y-m-d 23:59:59")])
            ->orderBy('date_time', 'desc')
            ->paginate(20);
        return $attendances;
    }

    public static function getFirstAttendanceNew(){
        $result = Attendance::where('is_check', '=', 'N')->first();
        return $result;
    }

    public static function getAttendanceBelong($timesheet){
        // $time = $timesheet->date;

        $start_date = Carbon::create($timesheet->date);
        $start_date->hour = 0;
        $start_date->minute = 0;
        $start_date->second = 0;
        $end_date = Carbon::create($timesheet->date);
        $end_date->hour = 23;
        $end_date->minute = 59;
        $end_date->second = 59;
            // Lấy tất cả các attendances trong ngày này
        $attendances = Attendance::where([
                ['user_id', '=', $timesheet->user_id],
                ['date_time', '>=', $start_date],
                ['date_time', '<=', $end_date],
        ])->get();
        return $attendances;
    }

    public function updateByTimesheet($timesheet){
        $this->timesheet_id = $timesheet->id;
        $this->is_check = 'Y';
        $this->save();
    }


}
