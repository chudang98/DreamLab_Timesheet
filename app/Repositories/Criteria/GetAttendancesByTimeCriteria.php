<?php

namespace App\Repositories\Criteria;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

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
    protected $times;
    public function __construct($times)
    {
        $this->times= $times;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $list = $model::whereBetween('date_time', [(Carbon::createFromFormat("d/m/Y", $this->times[0])
            ->format("Y-m-d 00:00:00")),
            (Carbon::createFromFormat("d/m/Y", $this->times[1])->format("Y-m-d 23:59:59"))])
            ->orderBy('date_time', 'desc')
            ->paginate(20);
        return $list;
    }
}
