<?php

namespace App\Biz;

use Carbon\Carbon;
use App\Repositories\Eloquent\TimesheetEloquentRepositoryTest;
use App\Repositories\Eloquent\AttendanceEloquentRepositoryTestTest;

class ProcessTimesheetByAttendance
{
    private $timesheet_repo;
    private $attendance_repo; 
    private $timesheet;


    private static $LATE_TIME_MORNING = '8:30:00';
    private static $ABSENT_MORNING = '9:00:00';
    private static $END_MORNING = '12:00:00';

    private static $LATE_TIME_AFTERNOON = '13:00:00';
    private static $ABSENT_AFTERNOON = '14:00:00';
    private static $LEAVE_EARLY_AFTERNOOM = '16:30:00';
    private static $END_AFTERNOON = '17:00:00';

    private static $late_MORNING = 'M';
    private static $absent_MORNING = 'V';
    private static $work_MORNING = 'X';

    private static $late_AFTERNOON = 'M';
    private static $absent_AFTERNOON = 'V';
    private static $work_AFTERNOON = 'X';
    private static $leave_early_AFTERNOON = 'S';
    
    public function __construct($timesheet_repo, $attendance_repo)
    {
        $this->timesheet_repo = $timesheet_repo;
        $this->attendance_repo = $attendance_repo;
    }

    public function setTimesheetProcess($timesheet){
        $this->timesheet = $timesheet;
    }
 
    public function isTimeEarlierThanMilestone($time, $milestone){
        if(strtotime($time) <= strtotime($milestone))
            return true;
        else
            return false;
    }

    public function isTimeLaterThanMilestone($time, $milestone){
        if(strtotime($time) > strtotime($milestone))
            return true;
        else    
            return false;
    }

    // * Muốn update buổi sáng chỉ cần thời gian vào là được
    public function processMorningShift($time)
    {
        if($this->isTimeEarlierThanMilestone($time, static::$LATE_TIME_MORNING))
        {
            $this->timesheet->morning_shift = static::$work_MORNING;
        }else
        {
            if($this->isTimeEarlierThanMilestone($time, static::$ABSENT_MORNING))
            {
                $this->timesheet->morning_shift = static::$late_MORNING;
            }else
            {
                $this->timesheet->morning_shift = static::$absent_MORNING;           
            }
        }
        $this->timesheet->afternoon_shift = static::$absent_AFTERNOON;
    }

    // * Muốn update buổi chiều cần cả thời gian vào và thời gian ra
    public function processAfternoonShift($time_in, $time_out)
    {
        if($time_out == null)
            return;
        
        if($this->isTimeEarlierThanMilestone($time_in, static::$LATE_TIME_AFTERNOON))
        {
            if($this->isTimeEarlierThanMilestone(static::$END_AFTERNOON, $time_out))
            {
                $this->timesheet->afternoon_shift = static::$work_AFTERNOON;
            }else
            {
                if($this->isTimeEarlierThanMilestone(static::$LEAVE_EARLY_AFTERNOOM, $time_out))
                {
                    $this->timesheet->afternoon_shift = static::$leave_early_AFTERNOON;
                }else
                {
                    $this->timesheet->afternoon_shift = static::$absent_AFTERNOON;                    
                }
            }
        }else
        {
            if($this->isTimeEarlierThanMilestone($time_in, static::$ABSENT_AFTERNOON))
            {
                if($this->isTimeEarlierThanMilestone(static::$END_AFTERNOON, $time_out))
                {
                    $this->timesheet->afternoon_shift = static::$late_AFTERNOON;
                }else
                {
                    if($this->isTimeEarlierThanMilestone(static::$LEAVE_EARLY_AFTERNOOM, $time_out))
                    {
                        $this->timesheet->afternoon_shift = static::$leave_early_AFTERNOON;
                    }else
                    {
                        $this->timesheet->afternoon_shift = static::$absent_AFTERNOON;               
                    }
                }
            }else
            {
                $this->timesheet->afternoon_shift = static::$absent_AFTERNOON;                                    
            }
            
        }
    }

    public function processSelfTimesheetByAttendance()
    {
        $attendances = $this->attendance_repo->getAllAttendanceBelongToTimesheet($this->timesheet);
        $count = count($attendances);
        if($count >= 1)
        {
            if($count == 1)
            {
                $this->processTimesheetByOneAttendance($attendances[0]);
                $this->timesheet->check_in = $attendances[0]->date_time;
            }else
            {
                $check_in = $this->attendance_repo->getAttendanceCiInCollection($attendances);
                $check_out = $this->attendance_repo->getAttendanceCoInCollection($attendances);
                $this->processTimesheetByCiCoAttendance($check_in, $check_out);
            }
        }
        $this->timesheet->save();
        $this->attendance_repo->updateNewAttendancesInCollection($attendances, $this->timesheet);
    }

    // * Có 1 attendance thì chỉ có thể update được buổi sáng cho timesheet mà thôi.
    public function processTimesheetByOneAttendance($attendance)
    {
        $time = Carbon::create($attendance->date_time)->toTimeString();
        $this->processMorningShift($time);
    }

    public function processTimesheetByCiCoAttendance($check_in, $check_out)
    {
        $CI_time = Carbon::create($check_in->date_time)->toTimeString();
        $CO_time = Carbon::create($check_out->date_time)->toTimeString();

        $this->processMorningShift($CI_time);
        $this->processAfternoonShift($CI_time, $CO_time);

        $this->timesheet->check_in = $CI_time;
        $this->timesheet->check_out = $CO_time;
    }

    public function processSelfTimesheet()
    {
        $CI_time = $this->timesheet->check_in;
        $CO_time = $this->timesheet->check_out;

        $this->processMorningShift($CI_time);
        $this->processAfternoonShift($CI_time, $CO_time);
    }
}



?>
