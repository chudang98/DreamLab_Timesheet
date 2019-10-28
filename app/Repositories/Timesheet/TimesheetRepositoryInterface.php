<?php

namespace App\Repositories\Timesheet;

interface TimesheetRepositoryInterface{

    public function getByTimeAndEmployee($times, $employee);

    public function getByTime($times);
}
