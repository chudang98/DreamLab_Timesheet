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
    //s
    public function xuatUser(Request $request){
            // TODO : muốn sửa tháng năm xuất excel : sửa 2 tham số của  UserExport::configDay(tháng, năm); 
        UserExport::configDay($request->month, $request->yeah );
        return Excel::download(new UserExport, 'ban1.xlsx');
    }

        // method này chỉ để test

    public function test(){
        $user = User::where('id', 1)->first();
        $timesheet = $user->getTimeSheet(9, 2019);
        dd($timesheet);

    }
}
