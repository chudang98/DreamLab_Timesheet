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
    // xử lí khi có dữ liệu tìm kiếm
    public function xuLi1($time, $employee ,$dem){
        $data['dem']= $dem;
        $data['ti'] = $time;
        $employee_id = $employee;
        $times = explode(" - ", $time);
        $Timesheets = Timesheet::with('user')
            ->whereHas('user', function ($query) use($employee_id) {
                $query->where('employee_id', 'LIKE', "%{$employee_id}%")
                    ->orWhere('name', 'LIKE', "%{$employee_id}%");
            })
            ->whereBetween('date', [(Carbon::createFromFormat("d/m/Y", $times[0])->format("Y-m-d 00:00:00")),
                (Carbon::createFromFormat("d/m/Y", $times[1])->format("Y-m-d 23:59:59"))])
            ->orderBy('date', 'desc')
            ->paginate(20);
        $data['timesheets'] = $Timesheets;
        $data['time'] = $times;
        $data['employee'] = $employee;
        return $data;
    }

    //xử lí khi mặc định, không có trường tìm kiếm
    public function xuLi2($dem){
        $data['dem']= $dem;
        $times[0] = new Carbon('first day of this month');
        $times[0]= $times[0]->format('d/m/Y');
        $times[1] = Carbon::now();
        $times[1]= $times[1]->format('d/m/Y');
        $data['ti'] = $times[0].' - '.$times[1];
        $data['employee'] = "";
        $Timesheets = Timesheet::whereBetween('date', [(Carbon::createFromFormat("d/m/Y", $times[0])->format("Y-m-d 00:00:00")),
            (Carbon::createFromFormat("d/m/Y", $times[1])->format("Y-m-d 23:59:59"))])
            ->orderBy('date', 'desc')
            ->paginate(20);
        $data['timesheets'] = $Timesheets;
        $data['time'] = $times;
        return $data;
    }

    public function listTimesheets(Request $request)
    {
        if(isset($_GET['page'])){
            $dem = ($_GET['page']-1)*20 +1;
        }
        else $dem = 1;
        if (isset($request->time)) {

            $data = $this->xuLi1($request->time, $request->employee, $dem);
        } else {
            $data = $this->xuLi2($dem);
        }
        return view('Timesheet.list_Timesheets', $data);
    }

    public function deleteTimesheet($id)
    {
        Timesheet::deleteTimesheet($id);
        return redirect('/listTimesheets');
    }

    public function processNewData()
    {
        Timesheet::processNewData();
        return redirect('/listTimesheets');
    }
}
