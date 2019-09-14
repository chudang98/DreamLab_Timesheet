<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use DB;

class TimesheetController extends Controller
{
    //
    public function listTimesheets(){
        return View('Timesheet.list_timesheets');
    }
    public function detailTimesheet(){
        return View('Timesheet.detail_timesheet');
    }

}
