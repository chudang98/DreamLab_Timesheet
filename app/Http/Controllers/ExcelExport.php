<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;

class ExcelExport extends Controller
{
    //
    public function xuatUser(){
        
        UserExport::configDay(9, 2019);
        return Excel::download(new UserExport, 'ban1.xlsx');
    }
}
