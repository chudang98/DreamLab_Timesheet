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
