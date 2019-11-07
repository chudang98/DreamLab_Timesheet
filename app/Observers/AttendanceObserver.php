<?php

namespace App\Observers;

use App\Attendance;
use App\Events\AddNewAttendance;

use Carbon\Carbon;

class AttendanceObserver
{
    /**
     * Handle the attendance "created" event.
     *
     * @param  \App\Attendance  $attendance
     * @return void
     */
    public function created(Attendance $attendance)
    {
        //
        event(new AddNewAttendance($attendance));
    }

    /**
     * Handle the attendance "updated" event.
     *
     * @param  \App\Attendance  $attendance
     * @return void
     */
    public function updated(Attendance $attendance)
    {
        //
    }

    /**
     * Handle the attendance "deleted" event.
     *
     * @param  \App\Attendance  $attendance
     * @return void
     */
    public function deleted(Attendance $attendance)
    {
        //
    }

    /**
     * Handle the attendance "restored" event.
     *
     * @param  \App\Attendance  $attendance
     * @return void
     */
    public function restored(Attendance $attendance)
    {
        //
    }

    /**
     * Handle the attendance "force deleted" event.
     *
     * @param  \App\Attendance  $attendance
     * @return void
     */
    public function forceDeleted(Attendance $attendance)
    {
        //
    }
}
