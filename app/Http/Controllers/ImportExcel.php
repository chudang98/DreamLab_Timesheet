<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

class ImportExcel extends Controller
{
    //
    public function addData(){
        return view('importData');
    }
    public function process(){

        Excel::import(new UsersImport,request()->file('file'));
    
    }
}
