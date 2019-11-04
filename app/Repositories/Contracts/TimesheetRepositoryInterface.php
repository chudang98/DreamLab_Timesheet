<?php

namespace App\Repositories\Contracts;

interface TimesheetRepositoryInterface{

    public function getByTimeAndEmployee($times, $employee);

    public function getByTime($times);
}
