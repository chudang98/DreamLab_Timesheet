<?php
namespace App\Biz;

use App\Timesheet;
use App\Attendance;
use Carbon\Carbon;

use App\Biz\ProcessTimesheetByAttendance;
use App\Repositories\Timesheet\TimesheetRepositoryInterface as Times;
use App\Repositories\Timesheet\TimesheetEloquentRepository;
use App\Repositories\Attendance\AttendanceEloquentRepository;

class TimesheetService
{
    protected $Times;
    protected $timesheet_repo;
    protected $attendance_repo;

    private $processAttendance;
    

    public function __construct(Times $Times)
    {
        $this->Times = $Times;
        $this->timesheet_repo = new TimesheetEloquentRepository();
        $this->attendance_repo = new AttendanceEloquentRepository();

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
    
    // public function processDataBelong($timesheet){
    //         // Lấy tất cả các attendances trong ngày này
    //     $attendances = Attendance::getAttendanceBelong($timesheet);

    //         // Timesheets này không có attendance nào mới        
    //     if($attendances->isEmpty() != true)
    //     {
    //         $count = sizeof($attendances);
    //         $check_in = $attendances[0];
    //         $check_out = $attendances[0];

    //         if($count > 1)
    //         {
    //             if($timesheet->check_in != null)
    //             {
    //                 $check_in = Attendance::where([
    //                     ['date_time', '=', $timesheet->date ." " .$timesheet->check_in],
    //                     ['user_id', '=', $timesheet->user_id]
    //                 ])->first();
    //             }
                
    //             if($timesheet->check_out != null)
    //             {
    //                 $check_in = Attendance::where([
    //                     ['date_time', '=', $timesheet->date ." " .$timesheet->check_out],
    //                     ['user_id', '=', $timesheet->user_id]
    //                 ])->first();
                    
    //             }

    //             for($i = 0; $i < $count; $i++)
    //             {
    //                 if($attendances[$i]->earlyThan($check_in) == true){
    //                     $check_in = $attendances[$i];
    //                 }
    //                 if($attendances[$i]->laterThan($check_out) == true){
    //                     $check_out = $attendances[$i];
    //                 }
    //                 $attendances[$i]->updateByTimesheet($timesheet);
    //             }

    //             $timesheet->check_in = $check_in->date_time;
    //             $timesheet->check_out = $check_out->date_time;
    //             $this->processCiCOAttendance($timesheet, $check_out, $check_in);
    //         }else
    //         {
    //             // Chỉ có 1 attendance
    //             $check_in = $attendances[0];
    //             // $timesheet->check_in = $check_in->date_time;
    //             $this->processCiCOAttendance($timesheet, $check_out);
    //             $attendances[0]->updateByTimesheet($timesheet);
    //         }
    //     }
    //     $timesheet->save();   
    // }

    // private function processCiCOAttendance($timesheet, $check_out, $check_in = null){
        
    //     switch($timesheet->morning_shift){
    //         case static::$work_MORNING : 
    //         {
    //             $this->processWorkMorningShift($timesheet, $check_out, $check_in);   
    //             break;
    //         }
    //         case static::$late_MORNING :
    //         {
    //             $this->processLateMorningShift($timesheet, $check_out, $check_in);
    //             break;
    //         } 
    //         case static::$absent_MORNING :
    //         {
    //             $this->processAbsentMorningShift($timesheet, $check_out, $check_in);
    //             break;
    //         }
    //     }
    // }

    // private function processWorkMorningShift($timesheet, $check_out, $check_in = null){
    //     // Nếu chỉ có 1 attendance thì tham số thứ 3 bằng null
    //     $CO_time = Carbon::create($check_out->date_time)->toTimeString();
    //     if($check_in == null)
    //         $isOneAttendance = true;
    //     else
    //         $isOneAttendance = false;     

    //     switch($timesheet->afternoon_shift){
    //         case static::$leave_early_AFTERNOON : {
    //             if(strtotime($CO_time) >= strtotime(static::$END_AFTERNOON)){
    //                 if($isOneAttendance == true)
    //                     $timesheet->check_in = $check_out->date_time;
    //                 $timesheet->afternoon_shift = static::$work_AFTERNOON;
    //             }
    //             break;
    //         }
    //         case static::$absent_AFTERNOON : {
    //             if(strtotime($CO_time) >= strtotime(static::$END_AFTERNOON)){
    //                 $timesheet->afternoon_shift = static::$work_AFTERNOON;
    //             }
    //             else
    //                 if(strtotime($time) >= strtotime(static::$LEAVE_EARLY_AFTERNOOM)){
    //                     if($isOneAttendance == true)
    //                         $timesheet->check_out = $attendance->date_time;                            
    //                     $timesheet->afternoon_shift = static::$leave_early_AFTERNOON;
    //                 }
    //             break;
    //         }
    //     }

    // }

    // private function processLateMorningShift($timesheet, $check_out, $check_in = null){
    //     $isOneAttendance = true;

    //     if($check_in != null){
    //         $CI_time = Carbon::create($check_in->date_time)->toTimeString();
    //         $isOneAttendance = false;
    //     }
    //     $CO_time = Carbon::create($check_out->date_time)->toTimeString();

    //     if($isOneAttendance == false)
    //         if(strtotime($CI_time) <= strtotime(static::$LATE_TIME_MORNING))
    //         {
    //             $timesheet->check_in = $check_in->date_time;                    
    //             $timesheet->morning_shift = static::$work_MORNING;
    //         }
    //     else
    //     {
    //         if(strtotime($CO_time) <= strtotime(static::$LATE_TIME_MORNING))
    //         {
    //             $timesheet->check_in = $check_out->date_time;                    
    //             $timesheet->morning_shift = static::$work_MORNING;
            
    //         }
    //     }

    //     switch($timesheet->afternoon_shift)
    //     {
    //         case static::$absent_AFTERNOON : {
    //             if(strtotime($CO_time) >= strtotime(static::$END_AFTERNOON))
    //             {
    //                 $timesheet->afternoon_shift = static::$work_AFTERNOON;
    //                 $timesheet->check_out = $check_out->date_time;                            
    //             }
    //             else
    //                 if(strtotime($CO_time) >= strtotime(static::$LEAVE_EARLY_AFTERNOOM))
    //                 {
    //                     $timesheet->check_out = $check_out->date_time;                            
    //                     $timesheet->afternoon_shift = static::$leave_early_AFTERNOON;
    //                 }

    //             break;
    //         }
    //         case static::$leave_early_AFTERNOON : {
    //             if(strtotime($CO_time) >= strtotime(static::$END_AFTERNOON))
    //             {
    //                 $timesheet->check_out = $check_out->date_time;                            
    //                 $timesheet->afternoon_shift = static::$work_AFTERNOON;
    //             }
    //             break;
    //         }
    //     }
        
    // }

    // private function processAbsentMorningShift($timesheet, $check_out, $check_in = null){
    //     if($check_in != null)
    //         $CI_time = Carbon::create($check_in->date_time)->toTimeString();
    //     $CO_time = Carbon::create($check_out->date_time)->toTimeString();
    //         // TODO : Nếu tham số truyền vào có 2 cả check-in và check-out
    //     if($check_in != null)
    //     {
    //         if(strtotime($CI_time) <= strtotime(static::$LATE_TIME_MORNING))
    //         {
    //                 $timesheet->morning_shift = static::$work_MORNING;
    //         }else
    //         {
    //             if(strtotime($CI_time) <= strtotime(static::$ABSENT_MORNING))
    //             {
    //                 $timesheet->morning_shift = static::$late_MORNING;
    //             }
    //         }
    //             // check chiều - check lại sáng
    //         switch($timesheet->afternoon_shift){
    //             case static::$absent_AFTERNOON : {
    //                 // check lại được buổi sáng đi làm hoặc đi làm trước giờ ca chiều
    //                 if(strtotime($CI_time) <= strtotime(static::$LATE_TIME_AFTERNOON)
    //                         || $timesheet->morning_shift != static::$absent_MORNING)
    //                 {
    //                     if(strtotime($CO_time) >= strtotime(static::$END_AFTERNOON))
    //                         $timesheet->afternoon_shift = static::$work_AFTERNOON;
    //                     else
    //                     {
    //                         if(strtotime($CO_time) >= strtotime(static::$LEAVE_EARLY_AFTERNOOM))
    //                             $timesheet->afternoon_shift = static::$leave_early_AFTERNOON;
    //                     }
    //                 }else
    //                     // Chắc chắn là đi làm chiều bị muộn
    //                 {
    //                     if(strtotime($CI_time) <= strtotime(static::$ABSENT_AFTERNOON))
    //                         if(strtotime($CO_time) >= strtotime(static::$END_AFTERNOON ))
    //                             $timesheet->afternoon_shift = static::$late_AFTERNOON;
    //                         else
    //                         {
    //                             if(strtotime($CO_time) >= strtotime(static::$LEAVE_EARLY_AFTERNOOM))
    //                                 $timesheet->afternoon_shift = static::$leave_early_AFTERNOON;
    //                         }
    //                 }
    //                 break;
    //             }
    //             case static::$leave_early_AFTERNOON : {
    //                 if(strtotime($CO_time) >= strtotime(static::$END_AFTERNOON))
    //                 {
    //                     $timesheet->afternoon_shift = static::$work_AFTERNOON;
    //                 }
    //                 break;
    //             }

    //             case static::$late_AFTERNOON : {
    //                 if(strtotime($CI_time) <= strtotime(static::$LATE_TIME_AFTERNOON)
    //                     || $timesheet->morning_shift != static::$absent_MORNING)
    //                 {
    //                     $timesheet->afternoon_shift = static::$work_MORNING;
    //                 }
    //                 break;
    //             }
    //         }
    //     }else
    //         // TODO : Nếu tham số truyền vào chỉ có 1 check-out : truyền 1 attendances
    //     {
    //         // $check_out = $timesheet->getCOAttendance();
    //         $last_attendance = $timesheet->getCOAttendance();
            
    //         if($check_out->earlyThan($last_attendance) == true)
    //         {
    //             $this->processCiCOAttendance($timesheet, $last_attendance, $check_out);
    //         }else
    //             if($check_out->laterThan($last_attendance) == true)
    //                 $this->processCiCOAttendance($timesheet, $check_out, $last_attendance);
    //             else{
    //                 $timesheet->check_in = $check_out->date_time;
    //                 // Cả timesheet đó chỉ có duy nhất 1 attendance
    //                 if(strtotime($CO_time) <= strtotime(static::$LATE_TIME_MORNING))
    //                 {
    //                     $timesheet->morning_shift = static::$work_MORNING;
    //                 }else
    //                 {
    //                     if(strtotime($CO_time) <= strtotime(static::$ABSENT_AFTERNOON)){
    //                         $timesheet->morning_shift = static::$late_MORNING;
    //                     }
    //                 }
    //             }
    //     }

    // }



    public function updateTimesheetByAttendance($attendance){

        // Lấy timesheet tương ứng với attendance này 
        $timesheet = $this->timesheet_repo->getTimesheetByAttendance($attendance);

        if($timesheet == null)
        {
            $timesheet = $this->timesheet_repo->createTimesheetByAttendance($attendance);
        }

        $this->processAttendance = new ProcessTimesheetByAttendance($this->timesheet_repo, $this->attendance_repo, $timesheet);   

        $this->processAttendance->processTimesheetByAttendance($attendance);
    }

    public function getOnetNewAttendance(){
        return $this->attendance_repo->getOnetNewAttendance();
    }


}
