<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\AttendanceRepository;
use App\Attendance;
use App\Validators\AttendanceValidator;
use Carbon\Carbon;

/**
 * Class AttendanceRepositoryEloquent.
 *
 * @package namespace App\Eloquent;
 */
class AttendanceRepositoryEloquent extends BaseRepository implements AttendanceRepository
{

    public static $NO_CHECK = 'N';
    public static $CHECKED = 'Y';
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Attendance::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    public function getAttendancesByDateAndIduser($date, $id_user)
    {
        $start = Carbon::create($date ." 00:00:00");
        $end = Carbon::create($date ." 23:59:59");
        $res = $this->model::where([
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
        $res = $this->model::where([
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
        $res = $this->model::where([
            ['date_time', '>=' , $start],
            ['date_time', '<=' , $end],
            ['user_id', '=', $timesheet->user_id],
            ['is_check', '=', static::$NO_CHECK]
        ])->get();
        return $res;
    }
    public function getAttendanceCiOfTimesheet($timesheet)
    {
        $date = $timesheet->date;
        $id_user = $timesheet->user_id;
        $start = Carbon::create($date ." 00:00:00");
        $end = Carbon::create($date ." 23:59:59");
        $res = $this->model::where([
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
        $res = $this->model::where([
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
    public function updateNewAttendancesInCollection($attendances, $timesheet)
    {
        foreach($attendances as $attendance)
        {
            if($attendance->is_check == static::$NO_CHECK)
            {
                $attendance->timesheet_id = $timesheet->id;
                $attendance->is_check = static::$CHECKED;
                $attendance->save();
            }
        }
    }
    public function getOnetNewAttendance(){
        $attendance = Attendance::where('is_check', '=', static::$NO_CHECK)->first();
        return $attendance;
    }


}
