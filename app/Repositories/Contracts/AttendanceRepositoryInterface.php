<?php

namespace App\Repositories\Contracts;

interface AttendanceRepositoryInterface{

//    public function getByTimeAndEmployee($times, $employee);

    public function getByTime($times);
}
