<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\User;
use Carbon\Carbon;
use App\Timesheet;
use Illuminate\Http\Request;
use View;
use DB;

class TimesheetController extends Controller
{
    //
    public function listTimesheets(){
        $month= Carbon::now()->month;
        $timesheets = []; $i=0;
        if(isset($_GET['time'])) {
            if (isset($_GET['employee'])) {
                $time = explode(" ", $_GET['time']);
                $data['users'] = User::where('employee_id', $_GET['employee'])
                    ->orWhere('name', 'like', '%' . $_GET['employee'] . '%')
                    ->get();
                $user_ids = User::where('employee_id', $_GET['employee'])
                    ->select('id')
                    ->orWhere('name', 'like', '%' . $_GET['employee'] . '%')
                    ->get();
                $tims = Timesheet::orderBy('date', 'desc')
                    ->whereIn('user_id', $user_ids)
                    ->get();
                foreach ($tims as $tim) {
                    $day = $tim->date;
                    $str1 = str_replace('/', '-', $time[0]);
                    $str2 = str_replace('/', '-', $time[2]);
                    if (strtotime($day) >= strtotime($str1) && strtotime($day) <= strtotime($str2)) {
                        $timesheets[$i++] = $tim;
                    }
                }
                $data['timesheets'] = $timesheets;
                $data['time'] = $time;
                $data['employee'] = $_GET['employee'];
            } else {
                $time = explode(" ", $_GET['time']);
                $tims = Timesheet::orderBy('date', 'desc')
                    ->get();
                foreach ($tims as $tim) {
                    $day = $tim->date;
                    $str1 = str_replace('/', '-', $time[0]);
                    $str2 = str_replace('/', '-', $time[2]);
                    if (strtotime($day) >= strtotime($str1) && strtotime($day) <= strtotime($str2)) {
                        $timesheets[$i++] = $tim;
                    }
                }
                $data['timesheets'] = $timesheets;
                $data['time'] = $time;
            }
        }
        else{
            $day1 = date('01/m/Y');
            $time[0]= $day1;
            $day2 = date('d/m/Y');
            $time[1]= $day2;
            $day3 = date('d/m/Y');
            $time[2]= $day3;
            $tims = Timesheet::orderBy('date','desc')->get();
            foreach ($tims as $tim){
                $day= $tim->date;
                $day2= strtotime($day);
                $day3 = date('m',$day2);
                if($day3 == $month) $timesheets[$i++] = $tim;
            }
            $data['users']= User::all();
            $data['timesheets'] = $timesheets;
            $data['time'] = $time;
        }
        return View('Timesheet.list_timesheets', $data);
    }
//    public function deleteTimesheet($id){
//        DB::table('timesheets')
//            ->where('id', $id)
//            ->delete();
//        return redirect('/listTimesheets/');
//    }
}
