<?php
namespace App\Biz;

use App\Timesheet;
use App\Attendance;
use Carbon\Carbon;
use App\Repositories\Eloquent\TimesheetEloquentRepository as Times;



class TimesheetService{
    protected $Times;
    protected $attendance_repo;

    private $processAttendance;


    public function __construct(Times $Times, AttendanceEloquentRepository $attendance_repo)
    {
        $this->Times = $Times;
        $this->attendance_repo = $attendance_repo;
        $this->processAttendance = new ProcessTimesheetByAttendance($this->Times, $this->attendance_repo);
    }

    //xóa att có id bằng $id
    public function deleteTimesheet($id)
    {
        $this->Times->delete($id);
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
        $timesheets = $this->Times->getByTimeAndEmployee($times,$employee );
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
        $timesheets = $this->Times->getByTime($times);
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


    public function updateTimesheetByAttendance($attendance){

        // Lấy timesheet tương ứng với attendance này
        $timesheet = $this->Times->getTimesheetByAttendance($attendance);

        if($timesheet == null)
        {
            $timesheet = $this->Times->createTimesheetByAttendance($attendance);
        }
        $this->processAttendance->setTimesheetProcess($timesheet);
        $this->processAttendance->processSelfTimesheetByAttendance();
    }

    public function getOnetNewAttendance(){
        return $this->attendance_repo->getOnetNewAttendance();
    }
//
//    }

}
