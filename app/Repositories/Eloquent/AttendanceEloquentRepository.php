<?php
namespace App\Repositories\Eloquent;

use App\Attendance;
use Carbon\Carbon;
use App\Repositories\Eloquent\EloquentRepository;

class AttendanceEloquentRepository extends EloquentRepository implements AttendanceRepositoryInterface {
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
    public function getByTime($times){
        $list = $this->_model::whereBetween('date_time', [(Carbon::createFromFormat("d/m/Y", $times[0])
            ->format("Y-m-d 00:00:00")),
            (Carbon::createFromFormat("d/m/Y", $times[1])->format("Y-m-d 23:59:59"))])
            ->orderBy('date_time', 'desc')
            ->paginate(20);
        return $list;
    }
}
