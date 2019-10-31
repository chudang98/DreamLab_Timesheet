<?php
namespace App\Repositories\Attendance;

use App\Attendance;
use Carbon\Carbon;
use App\Repositories\EloquentRepository;

class AttendanceEloquentRepository extends EloquentRepository implements AttendanceRepositoryInterface {
    
    public static $NO_CHECK = 'N';
    public static $CHECKED = 'Y';
    
    public function getModel()
    {
        return Attendance::class;
    }

    public function getByTimeAndEmployee($times, $employee){
        $attendances = $this->_model::with('user')
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

    //get các bản ghi theo time
    public function getByTime($times)
    {
        $list = $this->_model::whereBetween('date_time', [(Carbon::createFromFormat("d/m/Y", $times[0])
            ->format("Y-m-d 00:00:00")),
            (Carbon::createFromFormat("d/m/Y", $times[1])->format("Y-m-d 23:59:59"))])
            ->orderBy('date_time', 'desc')
            ->paginate(20);
        return $list;
    }

    public function getAttendancesByDateAndIduser($date, $id_user)
    {
        $start = Carbon::create($date ." 00:00:00");
        $end = Carbon::create($date ." 23:59:59");
        $res = $this->_model::where([
            ['date_time', '>=' , $start],
            ['date_time', '<=' , $end],
            ['user_id', '=', $id_user]
        ])->get();
        return $res;
    }

    public function getAllAttendanceBelongToTimesheet($timesheet){
        $date = $timesheet->date;
        $id_user = $timesheet->user_id;
        $start = Carbon::create($date ." 00:00:00");
        $end = Carbon::create($date ." 23:59:59");
        $res = $this->_model::where([
            ['date_time', '>=' , $start],
            ['date_time', '<=' , $end],
            ['user_id', '=', $id_user]
        ])->get();
        return $res;
    }

    public function getAllNewAttendanceBelongToTimesheet($timesheet)
    {
        $date = $timesheet->date;
        $start = Carbon::create($date ." 00:00:00");
        $end = Carbon::create($date ." 23:59:59");
        $res = $this->_model::where([
            ['date_time', '>=' , $start],
            ['date_time', '<=' , $end],
            ['user_id', '=', $id_user],
            ['is_check', '=', static::NO_CHECK]
        ])->get();
        return $res;
    }

    public function getAttendanceCiOfTimesheet($timesheet)
    {
        $date = $timesheet->date;
        $id_user = $timesheet->user_id;
        $start = Carbon::create($date ." 00:00:00");
        $end = Carbon::create($date ." 23:59:59");
        $res = $this->_model::where([
            ['date_time', '>=' , $start],
            ['date_time', '<=' , $end],
            ['user_id', '=', $id_user],
        ])->get()->sortBy('date_time');
        return $res->first();

    }

    public function getAttendanceCoOfTimesheet($timesheet)
    {
        $date = $timesheet->date;
        $id_user = $timesheet->user_id;
        $start = Carbon::create($date ." 00:00:00");
        $end = Carbon::create($date ." 23:59:59");
        $res = $this->_model::where([
            ['date_time', '>=' , $start],
            ['date_time', '<=' , $end],
            ['user_id', '=', $id_user],
        ])->get()->sortByDesc('date_time');
        return $res->first();
    }

    public function getAttendanceCiInCollection($attendances)
    {
        $attendances = $attendances->sortBy('date_time');
        return $attendances->first();
    }

    public function getAttendanceCoInCollection($attendances)
    {
        $attendances = $attendances->sortByDesc('date_time');
        return $attendances->first();
    }

    public function updateNewAttendancesByTimesheet($timesheet)
    {
        $attendances = $this->getAllNewAttendanceBelongToTimesheet($timesheet);
        foreach($attendance as $attendances)
        {
            $attendance->timesheet_id = $timesheet->id;
            $attendance->is_check = static::$CHECKED;
            $attendance->save();
        }
    }

    public function getOnetNewAttendance(){
        $attendance = Attendance::where('is_check', '=', static::$NO_CHECK)->first();
        return $attendance;
    }

}
