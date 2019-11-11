<?php

namespace App\Repositories\Eloquent;

use Carbon\Carbon;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\TimesheetRepository;
use App\Timesheet;
use App\Validators\TimesheetValidator;

/**
 * Class TimesheetRepositoryEloquent.
 *
 * @package namespace App\Eloquent;
 */
class TimesheetRepositoryEloquent extends BaseRepository implements TimesheetRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Timesheet::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function getByTimeAndEmployee($times, $employee){
        $timesheets = $this->model::with('user')
            ->whereHas('user', function ($query) use($employee) {
                $query->where('employee_id', 'LIKE', "%{$employee}%")
                    ->orWhere('name', 'LIKE', "%{$employee}%");
            })
            ->whereBetween('date', [(Carbon::createFromFormat("d/m/Y", $times[0])->format("Y-m-d 00:00:00")),
                (Carbon::createFromFormat("d/m/Y", $times[1])->format("Y-m-d 23:59:59"))])
            ->orderBy('date', 'desc')
            ->paginate(20);
        return $timesheets;
    }

    //get các bản ghi theo time
    public function getByTime($times){
        $timesheets = $this->model::whereBetween('date', [(Carbon::createFromFormat("d/m/Y", $times[0])->format("Y-m-d 00:00:00")),
            (Carbon::createFromFormat("d/m/Y", $times[1])->format("Y-m-d 23:59:59"))])
            ->orderBy('date', 'desc')
            ->paginate(20);
        return $timesheets;
    }

    public function getTimesheetByAttendance($attendance){
        $time = Carbon::create($attendance->date_time)->toDateString();
        $timesheet = Timesheet::where([
            ['date', '=', $time],
            ['user_id', '=', $attendance->user_id]
        ])->first();
        return $timesheet;
    }

    public function createTimesheetByAttendance($attendance){
        $timesheet = new Timesheet();
        $timesheet->user_id = $attendance->user_id;
        $date = Carbon::create($attendance->date_time)->toDateString();
        $timesheet->date = $date;
        return $timesheet;
    }


}
