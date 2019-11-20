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

use App\Jobs\UpdateTimesheetByNewAttendance;

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

    public function processNewAttendances()
    {
        UpdateTimesheetByNewAttendance::dispatch($this->timesheetService);
        return redirect('/listAttendances')->with('status', 'Dữ liệu mới đang được xử lý. Vui lòng chờ cho đến khi có thông báo !');
    }
}
