<?php

namespace App\Http\Controllers;

use App\Biz\TimesheetService;
use App\Timesheet;
use App\Attendance;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use View;
use DB;

class TimesheetController extends Controller
{
    protected $timesheetService;

    public function __construct(TimesheetService $timesheetService)
    {
        $this->timesheetService = $timesheetService;
    }

    public function listTimesheets(Request $request)
    {
        $data = $this->timesheetService->listTimesheets($request);
        return view('Timesheet.list_timesheets', $data);
    }

    public function deleteTimesheet($id)
    {
        $this->timesheetService->deleteTimesheet($id);
        return redirect('/listTimesheets');
    }

    public function processNewAttendances(){
        $attendance = Attendance::getFirstAttendanceNew();
        while($attendance != null){
            $timesheet = Timesheet::getTimesheetByAttendance($attendance);
            if($timesheet == null)
                $timesheet = Timesheet::saveNewByAttendance($attendance);
            $this->timesheetService->processDataBelong($timesheet);
            
            $attendance = Attendance::getFirstAttendanceNew();        
        }
    }
}
