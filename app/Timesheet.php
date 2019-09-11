<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    /*
        morning_shift = 'M, V, X'
        afternoon_shift = 'M, V, S, X'

    */
    private static $ON_TIME_MORNING = '8:00:00';
    private static $LATE_TIME_MORNING = '8:30:00';
    private static $ABSENT_MORNING = '9:00:00';

    private static $ON_TIME_AFTERNOON = '13:00:00';
    private static $LATE_TIME_AFTERNOON = '13:30:00';
    private static $ABSENT_AFTERNOON = '14:00:00';
    private static $LEAVE_EARLY_AFTERNOOM = '16:30:00';

    protected $fillable = [
        'id', 'date', 'morning_shift', 'afternoon_shift', 'user_id'
    ];


    public $timestamps = false;


    public function attendances(){
        return $this->hasMany(Attendance::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


    
    public function process($attendances){
        $check_in = $attendances[0]; $check_out = $attendances[0];
        $count = sizeof($attendances);
        if($count > 1)
        {
            for($i =  0; $i < $count; $i++){
                for($j = $i + 1; $j < $count; $j++){
                    
                }
            }
        }else
        {

        }
        
        
        
    }

    public function update($attendance){

    }

    public function toObjExcel(){
        return [

        ];
    }
}
