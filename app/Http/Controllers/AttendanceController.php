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
        $month= Carbon::now()->month;
        $attendances = []; $i=0;
        if(isset($_POST['st'])){

        }
        else{
            $atts = Attendance::all();
            foreach ($atts as $att){
                $day= $att->date_time;
                $day2= strtotime($day);
                $day3 = date('m',$day2);
                if($day3 == $month) $attendances[$i++] = $att;
            }
            $data['users']= User::all();
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
        $data['attendances'] = $attendances;
        return View('Attendance.list_attendances', $data);
    }
//    public function detailAttendance($day){
//        $ats = Attendance::all();
//        $attendances = [];
//        $i =0;
//        foreach ($ats as $attendance){
//            $d= $attendance->date_time;
//            $d2= strtotime($d);
//            $d3= date('Y-m-d',$d2);
//            if($day == $d3){
//                $attendances[$i++]= $attendance;
//            }
//        }
//        for($x=0; $x<$i; $x++){
//            for($y= $x+1; $y<$i; $y++){
//                if($attendances[$x]->date_time>$attendances[$y]->date_time){
//                    $t= $attendances[$x];
//                    $attendances[$x]= $attendances[$y];
//                    $attendances[$y]= $t;
//                }
//            }
//        }
//        $data['attendances']= $attendances;
//        $data['users'] = User::all();
//        return View('Attendance.detail_attendance', $data);
//    }
//    public function deleteAttendances($day){
//        $attendances = Attendance::all();
//        foreach ($attendances as $attendance){
//            $d= $attendance->date_time;
//            $d2= strtotime($d);
//            $d3= date('Y-m-d',$d2);
//            if($day == $d3){
//                DB::table('attendances')
//                    ->where('id', $attendance->id)
//                    ->delete();
//            }
//        }
//        return redirect('/listAttendances');
//    }
    public function deleteAttendance($id){
        DB::table('attendances')
            ->where('id', $id)
            ->delete();
        return redirect('/listAttendances/');
    }
}
