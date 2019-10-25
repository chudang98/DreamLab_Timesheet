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
use App\Day;


Route::get('/', function () {
   return view('welcome');
});

//Trang chu
//Route::get('/', 'IndexController@index');

Auth::routes(['verify' => true]); // xác thực email


Route::get('/home', 'HomeController@index')->name('home');


// Route::get('/test', 'ExcelExport@test');

Route::post('/export_excel', 'ExcelExport@xuatUser')->name('export_excel');

Route::get('process_new_data', 'TimesheetController@processNewAttendances')->name('process_new_data');


//Profile
Route::get('/editProfile/{alert}','ProfileController@editProfile');
Route::post('/updateProfile','ProfileController@updateProfile');
Route::get('/changePassword/{alert}','ProfileController@changePassword');
Route::post('/updatePassword','ProfileController@updatePassword');

//Attendance
Route::get('/listAttendances', 'AttendanceController@listAttendances');
Route::get('/deleteAttendance/{id}','AttendanceController@deleteAttendance');

Route::get('/test', function (){
   $user = App\User::class;
   dd($user);
});

//Timesheet
Route::get('/listTimesheets', 'TimesheetController@listTimesheets');
Route::get('/deleteTimesheet/{id}','TimesheetController@deleteTimesheet');
//Calendar
Route::get('/calendar', 'CalendarController@index');
Route::get('/addEvent', 'CalendarController@addEvent');

Route::get('/test2', 'TimesheetController@test');

Route::get('/form', function (){
    return view('testForm');
});

