<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;

class CalendarController extends Controller
{
    //
    public function index(){
        return View('Calendar.calendar');
    }
}
