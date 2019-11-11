<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface TimesheetRepository.
 *
 * @package namespace App\Contracts;
 */
interface TimesheetRepository extends RepositoryInterface
{
    //
    public function getByTimeAndEmployee($times, $employee);

    public function getByTime($times);
}
