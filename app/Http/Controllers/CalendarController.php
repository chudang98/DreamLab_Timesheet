<?php

namespace App\Http\Controllers;

use App\Biz\CalendarService;
use DemeterChain\C;
use Illuminate\Http\Request;
use View;
use App\Day;
use DB;

class CalendarController extends Controller
{
    protected $calendarService;

    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    // Trang thiết lập lịch ban đầu
    public function index()
    {
        $data = $this->calendarService->dataOfIndex();
        return View('Calendar.calendar', $data);
    }

    // thêm hoặc cập nhật sự kiện
    public function addEvent(Request $request)
    {
        $this->calendarService ->addEvent($request);
        return redirect('/calendar');
    }
}
