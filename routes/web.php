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


    $date_time = Carbon::create('2019-10-9 15:00:00');
    $date_time2 = Carbon::create('2019-10-9 16:00:10');

    $string1 = $date_time->toTimeString();
    $string2 = $date_time2->toTimeString();

    $result = (int) ((strtotime($string2) - strtotime($string1))/60 );

    echo $result;
    
});

//Profile
Route::get('/editProfile','ProfileController@editProfile');
Route::post('/updateProfile','ProfileController@updateProfile');
