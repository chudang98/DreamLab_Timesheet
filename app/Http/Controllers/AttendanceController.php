<?php

namespace App\Http\Controllers;

use App\Biz\AttendanceService;
use App\User;
use Illuminate\Http\Request;
use View;
use DB;
use App\Attendance;
use Carbon\Carbon;
use App\Http\Controllers\Response;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function listAttendances(Request $request)
    {
        $data = $this->attendanceService->listAttendances($request);
        return view('Attendance.list_attendances', $data);
    }

    public function deleteAttendance($id)
    {
        $this->attendanceService->deleteAttendance($id);
        return redirect('/listAttendances');
    }

    public function processNewData()
    {
        Attendance::processNewData();
        return redirect('/listAttendances');
    }
}
