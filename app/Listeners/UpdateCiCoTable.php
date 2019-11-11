<?php

namespace App\Listeners;

use App\Events\AddNewAttendance;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Repositories\Eloquent\TimesheetEloquentRepository;
use App\Repositories\Eloquent\AttendanceEloquentRepository;

use App\Biz\ProcessTimesheetByAttendance;

use Carbon\Carbon;


class UpdateCiCoTable
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public $timesheet_repo;
    public $attendance_repo;
    public $process;

    public function __construct(TimesheetEloquentRepository $timesheet_repo, 
        AttendanceEloquentRepository $attendance_repo)
    {
        //
        $this->timesheet_repo = $timesheet_repo;
        $this->attendance_repo = $attendance_repo;
        $this->process = new ProcessTimesheetByAttendance($timesheet_repo, $attendance_repo);
    }

    /**
     * Handle the event.
     *
     * @param  AddNewAttendance  $event
     * @return void
     */
    public function handle(AddNewAttendance $event)
    {
        //
        $attendance = $event->attendance;
        $timesheet = $this->timesheet_repo->getTimesheetByAttendance($attendance);
        $time = Carbon::create($attendance->date_time)->toTimeString();
        if($timesheet == null)
        {
            $timesheet = $this->timesheet_repo->createTimesheetByAttendance($attendance);
            $timesheet->check_in = $time;
            $this->process->setTimesheetProcess($timesheet);
            $this->process->processSelfTimesheet();
            $timesheet->save();
        }else
        {
            $timesheet->check_out = $time;
            $this->process->setTimesheetProcess($timesheet);
            $this->process->processSelfTimesheet();
            $timesheet->save();
        }
        $attendance->timesheet_id = $timesheet->id;
        $attendance->save();
    }
}
