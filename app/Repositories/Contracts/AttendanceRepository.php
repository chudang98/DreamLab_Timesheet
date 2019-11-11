<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AttendanceRepository.
 *
 * @package namespace App\Contracts;
 */
interface AttendanceRepository extends RepositoryInterface
{
    //
    public function getByTimeAndEmployee($times, $employee);

    public function getByTime($times);
}
