<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Day;
use DB;

class CalendarController extends Controller
{
    //thêm sự kiện
    public function add($date, $state, $startt_break, $endt_break, $reason){
        DB::table('days')->insert(
            [   'date' => $date,
                'state' =>$state,
                'startt_break' =>$startt_break,
                'endt_break' =>$endt_break,
                'reason' => $reason
            ]
        );
    }
    //sửa sự kiện
    public function update($date, $state, $startt_break, $endt_break, $reason){
        DB::table('days')
            ->where('date', $date)
            ->update([
                'state' =>$state,
                'startt_break' =>$startt_break,
                'endt_break' =>$endt_break,
                'reason' => $reason
            ]);
    }
    public function index(){
        $data['days'] = Day::all();
//        $data['ar'] = array(1,2,3);
        return View('Calendar.calendar', $data);
    }
    public function addEvent(Request $request){
        $day = Day::where('date', $request['event-date'])->first();
        $date = $request['event-date'];
        $state = $request['type'];
        $startt_break = null;
        $endt_break = null;
        $reason = null;
        //cập nhật dữ liệu theo trạng thái ngày
        if($state == 'working'){
            $reason = $request['reason-working'];
        }
        else if($state == 'off'){
            $reason = $request['reason-off'];
        }
        else if($state == 'break'){
            $startt_break = $request['hour-from'].':'.$request['minute-from'].':00';
            $endt_break = $request['hour-to'].':'.$request['minute-to'].':00';
            $reason = $request['reason-break'];
        }
        //nếu không điền lí do thì gán gt 'no reason'
        if($reason == null)
            $reason= 'no reason';
        //xét thêm hoặc cập nhật ngày
        if($day == null){
            $this->add($date, $state, $startt_break, $endt_break, $reason);
        }
        else{
            $this->update($date, $state, $startt_break, $endt_break, $reason);
        }
        //chuyển đến trang calendar sau khi xử lí dữ liệu
        return redirect('/calendar');
    }
}
