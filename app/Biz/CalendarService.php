<?php

namespace App\Biz;

use App\Day;
use App\Repositories\Eloquent\CalendarEloquentRepository as Calendar;

class CalendarService{

    protected $Calendar;

    public function __construct(Calendar $Calendar)
    {
        $this->Calendar = $Calendar;
    }

    //định dạng cho biến thời gian h:m:s
    public function formatTime($hour, $minute){
        $s = $hour.':'.$minute.':00';
        return $s;
    }

    //thiết lập dữ liệu theo trạng thái
    public function updateDataByState($request){
        $s = null;
        $s['reason'] = null;
        $s['startt_break'] = null;
        $s['endt_break'] = null;
        if($request['type'] == 'working'){
            $s['reason'] = $request['reason-working'];
        }
        else if($request['type'] == 'off'){
            $s['reason'] = $request['reason-off'];
        }
        else if($request['type'] == 'break'){
            $s['reason'] = $request['reason-break'];
            $s['startt_break'] = $this::formatTime($request['hour-from'], $request['minute-from']);
            $s['endt_break'] = $this::formatTime($request['hour-to'], $request['minute-to']);
        }

        //nếu không điền lí do thì gán gt 'no reason'
        if($s['reason'] == null)
            $s['reason']= 'no reason';
        return $s;
    }

    //Thêm hoặc cập nhật sự kiện
    public function addORUpdateDay($date, $state, $data){
        $day = $this->Calendar->findByDate($date);
        $d["date"] = $date;
        $d["state"] = $state;
        $d["startt_break"] = $data['startt_break'];
        $d["endt_break"] = $data['endt_break'];
        $d["reason"] = $data['reason'];
        if ($day == null)
            $this->Calendar->insertDay($d);
        else
            $this->Calendar->updateDay($d);
    }

    public function dataOfIndex(){
        $data['days'] = $this->Calendar->getAll();
        return $data;
    }

    public function addEvent($request){
        $date = $request['event-date'];
        $state = $request['type'];
        $data = $this::updateDataByState($request);
        $this::addORUpdateDay($date, $state, $data);
    }
}
