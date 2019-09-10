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
use Carbon\Carbon;


Route::get('/', function () {
   return view('welcome');
});

//Trang chu
 Route::get('/', 'IndexController@index');

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');


Route::get('/testdate', 'ExcelExport@xuatUser');

Route::get('/day', function(){
    $today = Carbon::now();
    // echo $today;
    
    $number = $today->daysInMonth;
    for($i = 1; $i <= $number; $i++){
        $today->day = $i;
        echo $i .' ' .$today->toDayDateTimeString() .'</br>';
    }
});

//Profile
Route::get('/editProfile','ProfileController@editProfile');
Route::post('/updateProfile','ProfileController@updateProfile');
