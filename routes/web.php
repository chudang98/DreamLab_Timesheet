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

    $sum = '';
    for($i = 0; $i < 10; $i++){
        $sum .= 'h';
    }

    echo $sum;
    
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
