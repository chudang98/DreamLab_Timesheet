<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are lo aded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Attendance;
use App\Timesheet;
use App\User;
use Carbon\Carbon;


Route::get('/', function () {
   return view('welcome');
});

//Trang chu
//Route::get('/', 'IndexController@index');

Auth::routes(['verify' => true]); // xác thực email


Route::get('/home', 'HomeController@index')->name('home');


Route::get('/test', 'ExcelExport@test');

Route::get('/export', 'ExcelExport@xuatUser');

Route::get('/day', function(){

    $arr = [];
    $t = 'ad';

    $arr[] = $t .'a';
    $arr[] = $t .'h';
    $arr[] = $t .'b';
    
    echo $arr[0] ." " .$arr[1] ." " .$arr[2];
});

Route::get('/{id}/{date}', function($id, $date){
    
    $start_Date = Carbon::create($date .' 00:00:00');
    $end_Date = Carbon::create($date .' 23:59:59');

    $attendances = Attendance::where([
        ['user_id', '=', $id],
        ['date_time', '>=', $start_Date],
        ['date_time', '<=', $end_Date],
    ])->get();

    foreach($attendances as $t){
        echo $t .'</br>';
    }
    

            $check_in = $attendances[1];
            $check_out = $attendances[1];
            $count = sizeof($attendances);
            echo '</br>';
            if($count > 1)
            {
                for($i = 0; $i < $count; $i++)
                {
                    if($attendances[$i]->earlyThan($check_in) == true){
                        $check_in = $attendances[$i];
                    }
                    else
                    {
                        if($attendances[$i]->laterThan($check_out) == true){
                            $check_out = $attendances[$i];
                        }
                    }
                }

            }else{
                // Chỉ có 1 attendance
            }

            echo $check_in .'</br>' .$check_out .'</br>';

            $timesheet = $check_in->timesheet;
            echo $timesheet;
}); 

//Profile
Route::get('/editProfile/{alert}','ProfileController@editProfile');
Route::post('/updateProfile','ProfileController@updateProfile');
Route::get('/changePassword/{alert}','ProfileController@changePassword');
Route::post('/updatePassword','ProfileController@updatePassword');

//Attendance
Route::get('/listAttendances', 'AttendanceController@listAttendances');
Route::get('/detailAttendance/{day}','AttendanceController@detailAttendance');
Route::get('/deleteAttendances/{day}','AttendanceController@deleteAttendances');
Route::get('/deleteAttendance/{id}','AttendanceController@deleteAttendance');

//Timesheet
Route::get('/listTimesheets', 'TimesheetController@listTimesheets');
Route::get('/detailTimesheet','TimesheetController@detailTimesheet');


//Calendar
Route::get('/calendar', 'CalendarController@index');
Route::get('/resultSearch', 'AttendanceController@resultSearch');
