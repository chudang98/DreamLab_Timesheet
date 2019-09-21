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

        // method này chỉ để test

    public function test(){
        $user = User::where('id', 1)->first();
        $timesheet = $user->getTimeSheet(9, 2019);
        dd($timesheet);

    }
}
