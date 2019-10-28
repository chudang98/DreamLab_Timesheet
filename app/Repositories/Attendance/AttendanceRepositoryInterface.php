<?php

namespace App\Repositories\Attendance;

interface AttendanceRepositoryInterface{

    public function getByTimeAndEmployee($times, $employee);

    public function getByTime($times);
}
