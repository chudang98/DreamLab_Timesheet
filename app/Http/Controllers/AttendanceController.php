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
    public function listAttendances(){
        $month= Carbon::now()->month;
        $attendances = []; $i=0;
        if(isset($_GET['time'])){
            if (isset($_GET['employee'])){
                $time = explode(" ", $_GET['time']);
                $data['users']= User::where('employee_id', $_GET['employee'])
                    ->orWhere('name','like', '%'.$_GET['employee'].'%')
                    ->get();
                $user_ids = User::where('employee_id', $_GET['employee'])
                    ->select('id')
                    ->orWhere('name','like', '%'.$_GET['employee'].'%')
                    ->get();
                $atts=Attendance::orderBy('date_time','desc')
                ->whereIn('user_id',$user_ids)
                    ->get();
                foreach ($atts as $att){
                    $day= $att->date_time;
                    $day2=explode(" ", $day);
                    $str1 = str_replace('/', '-', $time[0]);
                    $str2 = str_replace('/', '-', $time[2]);
                    if(strtotime($day2[0]) >= strtotime($str1) && strtotime($day2[0]) <= strtotime($str2)){
                        $attendances[$i++] = $att;
                    }
                }
                $data['attendances'] = $attendances;
                $data['time'] = $time;
                $data['employee']= $_GET['employee'];
            }
            else{
                $time = explode(" ", $_GET['time']);
                $atts=Attendance::orderBy('date_time','desc')
                    ->get();
                foreach ($atts as $att){
                    $day= $att->date_time;
                    $day2=explode(" ", $day);
                    $str1 = str_replace('/', '-', $time[0]);
                    $str2 = str_replace('/', '-', $time[2]);
                    if(strtotime($day2[0]) >= strtotime($str1) && strtotime($day2[0]) <= strtotime($str2)){
                        $attendances[$i++] = $att;
                    }
                }
                $data['attendances'] = $attendances;
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
            $atts = Attendance::orderBy('date_time','desc')->get();
            foreach ($atts as $att){
                $day= $att->date_time;
                $day2= strtotime($day);
                $day3 = date('m',$day2);
                if($day3 == $month) $attendances[$i++] = $att;
            }
            $data['users']= User::all();
            $data['attendances'] = $attendances;
            $data['time'] = $time;
        }
        return View('Attendance.list_attendances', $data);
    }
    public function deleteAttendance($id){
        DB::table('attendances')
            ->where('id', $id)
            ->delete();
        return redirect('/listAttendances');
    }
}
