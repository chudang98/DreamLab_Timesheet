<?php

namespace App\Http\Controllers;

use App\Attendance;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use App\Timesheet;
use App\User;
use Carbon\Carbon;

class ExcelExport extends Controller
{
    //
    public function xuatUser(){
            // TODO : muốn sửa tháng năm xuất excel : sửa 2 tham số của  UserExport::configDay(tháng, năm); 
        UserExport::configDay(8, 2019);

        
        return Excel::download(new UserExport, 'ban1.xlsx');
    }



    public function test(){
        $user = User::where('id', 1)->first();

        // $date_start = Carbon::create('2019-09-6 00:00:00');
        // $date_end = Carbon::create('2019-09-6 23:59:59');
        
        // $attendances = Attendance::where([
        //     ['user_id', '=', 1],
        //     ['date_time', '>=', $date_start],
        //     ['date_time', '<=', $date_end]

        // ])->get();

        // echo sizeof($attendances) .'</br>';
        
        // foreach($attendances as $t){
        //     echo $t .'</br>';
        // }

        // $timesheet = Timesheet::all();

        // $time  = $timesheet[0]->date;
        
        // $date = Carbon::create($time .' 00:00:00');
        // echo $date;

        $timesheet = $user->getTimeSheet(9, 2019);

        dd($timesheet);

    }
}
