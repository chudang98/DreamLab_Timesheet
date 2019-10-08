<?php
namespace App\Biz;

use App\Timesheet;
use Carbon\Carbon;

class TimesheetService{
    //xóa att có id bằng $id
    public function deleteTimesheet($id)
    {
        Timesheet::deleteTimesheet($id);
    }

    //thiết lập số thứ tự của trang
    public function stt($request){
        if(isset($request->page)){
            $dem = ($request->page-1)*20 +1;
        }
        else $dem = 1;
        return $dem;
    }

    // xử lí khi có dữ liệu tìm kiếm
    public function xuLi1($time, $employee ,$dem){
        $data['dem']= $dem;
        $data['ti'] = $time;
        $data['employee'] = $employee;
        $times = explode(" - ", $time);
        $timesheets = Timesheet::getByTimeAndEmployee($times,$employee );
        $data['timesheets'] = $timesheets;
        $data['time'] = $times;
        return $data;
    }

    //Định dang ngày về dạng d/m/Y
    public function formatDay($day){
        return $day->format('d/m/Y');
    }

    //xử lí khi mặc định, không có trường tìm kiếm
    public function xuLi2($dem){
        $data['dem']= $dem;
        $times[0] = $this::formatDay(new Carbon('first day of this month'));
        $times[1] = $this::formatDay(Carbon::now());
        $data['ti'] = $times[0].' - '.$times[1];
        $data['employee'] = "";
        $timesheets = Timesheet::getByTime($times);
        $data['timesheets'] = $timesheets;
        $data['time'] = $times;
        return $data;
    }

    //trả về dữ liệu cho listTimesheets bên Controller
    public function listTimesheets($request){
        $dem = $this::stt($request);
        if (isset($request->time)) {
            $data = $this::xuLi1($request->time, $request->employee, $dem);
        } else {
            $data = $this::xuLi2($dem);
        }
        return $data;
    }
}
