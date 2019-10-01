<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use View;
use DB;
use App\Attendance;
use Carbon\Carbon;
use App\Http\Controllers\Response;

class AttendanceController extends Controller
{
    //
    public function listAttendances(Request $request)
    {
        $employee_id = $request->employee;
        if (isset($request->time)) {
            $times = explode(" - ", $request->time);
            $attendances = Attendance::with('user')
                ->whereHas('user', function ($query) use($employee_id) {
                    $query->where('employee_id', 'LIKE', "%{$employee_id}%")
                        ->orWhere('name', 'LIKE', "%{$employee_id}%");
                })
                ->whereBetween('date_time', [Carbon::createFromFormat("d/m/Y", $times[0]),
                    Carbon::createFromFormat("d/m/Y", $times[1])])
                ->orderBy('date_time', 'desc')
                ->paginate(20);
            $data['attendances'] = $attendances;
            $data['time'] = $times;
            $data['employee'] = $request->employee;
        } else {
            $times[0] = new Carbon('first day of this month');
            $times[0]= $times[0]->format('d/m/Y');
            $times[1] = Carbon::now();
            $times[1]= $times[1]->format('d/m/Y');
            $attendances = Attendance::whereBetween('date_time', [Carbon::createFromFormat("d/m/Y", $times[0]),
                    Carbon::createFromFormat("d/m/Y", $times[1])])
                ->orderBy('date_time', 'desc')
                ->paginate(20);
            $data['attendances'] = $attendances;
            $data['time'] = $times;
        }
        return view('Attendance.list_attendances', $data);
    }

    public function deleteAttendance($id)
    {
        DB::table('attendances')
            ->where('id', $id)
            ->delete();
        return redirect('/listAttendances');
    }

    public function processNewData()
    {
        Attendance::processNewData();
        return redirect('/listAttendances');
    }
}
