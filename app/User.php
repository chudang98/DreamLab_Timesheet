<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id','name', 'email', 'password', 'attendance_number', 'department', 'attendance_machine_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function roles(){
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function attendanceMachine(){
        return $this->belongsTo(AttendanceMachine::class, 'attendance_machine_id');
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }

    public function attendances(){
        return $this->hasMany(Attendance::class);
    }

    public function timesheets(){
        return $this->hasMany(Timesheet::class);
    }


    /* 
        Lấy tất cả các timesheet của user dựa vào tháng-năm
        Timesheet đã được xử lý
        Trả về mảng kiểu ['S', 'C']
    */
    public function getTimeSheetExcel($month, $yeah)
    {
        $timesheets = $this->getTimesheet($month, $yeah);

        foreach($timesheets as $timesheet){
            $obj = [
                'S' => $timesheet->morning_shift,
                'C' => $timesheet->afternoon_shift
            ];
    

            $result[] = $obj;
        }

        $result[] = $this->inforWorkingTime($timesheets);

        return $result;

    }

        //  Trả về mảng Model Timesheet
    public function getTimesheet($month, $yeah){
        $date = $yeah .'-' .$month .'-1';
        // Update các attendance cho user này trước
        $first_day = Carbon::create($date);
    
        $number = $first_day->daysInMonth;

        $result = [];

        for($i = 1; $i <= $number; $i++){
            $first_day->day = $i;

            $timesheet = Timesheet::where([
                ['date', '=', $first_day],
                ['user_id', '=' , $this->id]
            ])->first();

            if($timesheet == null)
            {
                $timesheet = new Timesheet();
                $timesheet->user_id = $this->id;
                $timesheet->date = $first_day->format('Y-m-d');
                $timesheet->morning_shift = 'V';
                $timesheet->afternoon_shift = 'V';
                $timesheet->save();

                $timesheet->processAttendanceBelongTo();              
            }else
            {
                $timesheet->processAttendanceBelongTo();

            }

            $timesheet->save();

            $result[] = $timesheet;
        }

        return $result;
    }

    private function inforWorkingTime($timesheets){
        $result = [
            'working_day' => 0,
            'day_off' => 0,
            'late_min' => 0,
            'early_min' => 0,
        ];
        $late = 0;
        $early = 0;
        foreach($timesheets as $timesheet){
            $result['late_min'] += $timesheet->late_min;
            $result['early_min'] += $timesheet->early_min;
            $late += $timesheet->count_late;
            $early += $timesheet->count_early;
        }
        $result['working_day'] = (int) ($late / 3);
        $result['early'] = (int) ($early / 3);
        return $result;
    }





}

