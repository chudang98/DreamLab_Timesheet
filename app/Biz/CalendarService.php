<?php

namespace App\Biz;

use App\Day;

class CalendarService{

    


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
        $day = Day::where('date', $date)->first();
        if ($day == null)
            Day::insertDay($date, $state, $data['startt_break'], $data['endt_break'], $data['reason']);
        else
            Day::updateDay($date, $state, $data['startt_break'], $data['endt_break'], $data['reason']);
    }

    public function dataOfIndex(){
        $data['days'] = Day::all();
        return $data;
    }

    public function addEvent($request){
        $date = $request['event-date'];
        $state = $request['type'];
        $data = $this::updateDataByState($request);
        $this::addORUpdateDay($date, $state, $data);
    }
}
