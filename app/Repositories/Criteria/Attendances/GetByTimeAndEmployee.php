<?php
namespace App\Repositories\Criteria\Attendances;

use App\Attendance;
use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Contracts\CriteriaInterface;
use Carbon\Carbon;

class GetByTimeAndEmployee{
    
    public function apply($times, $employee){
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
}
