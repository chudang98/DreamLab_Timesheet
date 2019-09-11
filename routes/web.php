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
use Carbon\Carbon;


Route::get('/', function () {
   return view('welcome');
});

//Trang chu
<<<<<<< HEAD
// Route::get('/', 'IndexController@index');
=======
//Route::get('/', 'IndexController@index');
>>>>>>> 60d97b66a4017f97b1ac8cf54039e4eecc3fe28a

Auth::routes(['verify' => true]); // xác thực email


Route::get('/home', 'HomeController@index')->name('home');


Route::get('/testdate', 'ExcelExport@xuatUser');

Route::get('/day', function(){
    $today = Carbon::create('2019-8-1');
    // // echo $today;
    $number = $today->daysInMonth;

    $last = Carbon::create('2019-8-1')->add($number .' days');
    // for($i = 1; $i <= $number; $i++){
    //     $today->day = $i;
    //     echo $i .' ' .$today->shortEnglishDayOfWeek .' ' . $today->day .'</br>';
    // }


    // $data = Attendance::where([
    //         ['date_time', '>=', $today],
    //         ['date_time', '<=', $last], 
    // ])->get();
    // foreach($data as $t){
    //     echo $t .'</br>';
    // }
    
    $date = Carbon::create('2019-10-22 00:00:00');
    $date2 = Carbon::create('2019-10-22 23:59:59');

    $data = Attendance::where('date_time', '>=' , $date)
        ->where('date_time', '<=' , $date2)->first();
        
    if($data == null)
        echo 1;
    else
        echo 2;

    dd($data);
    
});

//Profile
Route::get('/editProfile','ProfileController@editProfile');
Route::post('/updateProfile','ProfileController@updateProfile');
