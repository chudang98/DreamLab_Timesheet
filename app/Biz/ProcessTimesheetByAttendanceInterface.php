<?php

namespace App\Biz;

interface ProcessTimesheetByAttendanceInterface{

    public function processTimesheetByAttendance($attendances);

    public function processTimesheetByOneAttendance($attendance);

    public function processTimesheetByCiCoAttendance($check_in, $check_out);

    
}

?>