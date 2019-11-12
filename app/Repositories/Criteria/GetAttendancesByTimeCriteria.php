<?php

namespace App\Repositories\Criteria;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Attendance;

/**
 * Class GetAttendancesByTimeCriteria.
 *
 * @package namespace App\Criteria;
 */
class GetAttendancesByTimeCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    protected $times1, $times2;
    public function __construct($times1, $times2)
    {
        $this->times1= $times1;
        $this->times2= $times2;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->whereBetween('date_time', [(Carbon::createFromFormat("d/m/Y", $this->times1)
            ->format("Y-m-d 00:00:00")),
            (Carbon::createFromFormat("d/m/Y", $this->times2)->format("Y-m-d 23:59:59"))])
            ->orderBy('date_time', 'desc');
//            ->paginate(20);
        return $model;
    }
}
