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

Route::post('/export_excel', 'ExcelExport@xuatUser')->name('export_excel');

Route::get('process_new_data', 'AttendanceController@processNewData')->name('process_new_data');

Route::get('/day', function(){
 
    $t = Timesheet::where('id', 1164)->first();
    
    echo $t ."</br>";
    $day = Carbon::create($t->date);
    echo $day ."</br>" .$day->shortEnglishDayOfWeek;
    dd($t->convertObjExcel());
 
});

// Route::get('t', function(){
//    $user = User::where('id')
// });


//Profile
Route::get('/editProfile/{alert}','ProfileController@editProfile');
Route::post('/updateProfile','ProfileController@updateProfile');
Route::get('/changePassword/{alert}','ProfileController@changePassword');
Route::post('/updatePassword','ProfileController@updatePassword');

//Attendance
Route::get('/listAttendances', 'AttendanceController@listAttendances');
Route::get('/deleteAttendance/{id}','AttendanceController@deleteAttendance');

Route::get('/test/{id}', function ($id){
   return $id;
});

//Timesheet
Route::get('/listTimesheets', 'TimesheetController@listTimesheets');
Route::get('/deleteTimesheet/{id}','TimesheetController@deleteTimesheet');
//Calendar
Route::get('/calendar', 'CalendarController@index');
