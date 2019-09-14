<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use View;
use DB;
use App\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    //
    
    public function listAttendances(){
        $attendances = Attendance::all();
        $days = [];
        $i=0;
        foreach ($attendances as $attendance){
            $day= $attendance->date_time;
            $day2= strtotime($day);
            $kt=0;
            for($j=0; $j<$i; $j++){
                if($days[$j] == date('Y-m-d',$day2)){
                    $kt=1;
                }
            }
            if($kt==0) $days[$i++]= date('Y-m-d',$day2);
        }
        for($x=0; $x<$i; $x++){
            for($y= $x+1; $y<$i; $y++){
                if($days[$x]<$days[$y]){
                    $t= $days[$x];
                    $days[$x]= $days[$y];
                    $days[$y]= $t;
                }
            }
        }
        $data['days']= $days;
        return View('Attendance.list_attendances', $data);
    }
    public function detailAttendance($day){
        $ats = Attendance::all();
        $attendances = [];
        $i =0;
        foreach ($ats as $attendance){
            $d= $attendance->date_time;
            $d2= strtotime($d);
            $d3= date('Y-m-d',$d2);
            if($day == $d3){
                $attendances[$i++]= $attendance;
            }
        }
        for($x=0; $x<$i; $x++){
            for($y= $x+1; $y<$i; $y++){
                if($attendances[$x]->date_time>$attendances[$y]->date_time){
                    $t= $attendances[$x];
                    $attendances[$x]= $attendances[$y];
                    $attendances[$y]= $t;
                }
            }
        }
        $data['attendances']= $attendances;
        $data['users'] = User::all();
        return View('Attendance.detail_attendance', $data);
    }
    public function deleteAttendances($day){
        $attendances = Attendance::all();
        foreach ($attendances as $attendance){
            $d= $attendance->date_time;
            $d2= strtotime($d);
            $d3= date('Y-m-d',$d2);
            if($day == $d3){
                DB::table('attendances')
                    ->where('id', $attendance->id)
                    ->delete();
            }
        }
        return redirect('/listAttendances');
    }
    public function deleteAttendance($id){
        $attendance = Attendance::where('id', $id)->first();
        $d= $attendance->date_time;
        $d2= strtotime($d);
        $d3= date('Y-m-d',$d2);
        DB::table('attendances')
            ->where('id', $id)
            ->delete();
        return redirect('/detailAttendance/'.$d3);
    }
}
