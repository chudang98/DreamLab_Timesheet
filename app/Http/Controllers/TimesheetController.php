<?php

namespace App\Http\Controllers;

use App\Timesheet;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use View;
use DB;

class TimesheetController extends Controller
{
    public function listTimesheets(Request $request)
    {
        $employee_id = $request->employee;
        if (isset($request->time)) {
            $times = explode(" - ", $request->time);
            $Timesheets = Timesheet::with('user')
                ->whereHas('user', function ($query) use($employee_id) {
                    $query->where('employee_id', 'LIKE', "%{$employee_id}%")
                        ->orWhere('name', 'LIKE', "%{$employee_id}%");
                })
                ->whereBetween('date', [Carbon::createFromFormat("d/m/Y", $times[0]),
                    Carbon::createFromFormat("d/m/Y", $times[1])])
                ->orderBy('date', 'desc')
                ->paginate(20);
            $data['timesheets'] = $Timesheets;
            $data['time'] = $times;
            $data['employee'] = $request->employee;
        } else {
            $times[0] = new Carbon('first day of this month');
            $times[0]= $times[0]->format('d/m/Y');
            $times[1] = Carbon::now();
            $times[1]= $times[1]->format('d/m/Y');
            $Timesheets = Timesheet::whereBetween('date', [Carbon::createFromFormat("d/m/Y", $times[0]),
                Carbon::createFromFormat("d/m/Y", $times[1])])
                ->orderBy('date', 'desc')
                ->paginate(20);
            $data['timesheets'] = $Timesheets;
            $data['time'] = $times;
        }
        return view('Timesheet.list_Timesheets', $data);
    }

    public function deleteTimesheet($id)
    {
        DB::table('timesheets')
            ->where('id', $id)
            ->delete();
        return redirect('/listTimesheets');
    }

    public function processNewData()
    {
        Timesheet::processNewData();
        return redirect('/listTimesheets');
    }
}
