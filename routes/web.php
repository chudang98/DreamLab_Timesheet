<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
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


Route::get('/testdate', function(){
    $datetime = '10:00:00';
    $date = Carbon::now()->toTimeString();
    echo $datetime ." " .$date;
    if(strtotime($datetime) > strtotime($date)){
        echo 'Y';
    }
    else{
        echo 'N';
    }
});

//Profile
Route::get('/editProfile','ProfileController@editProfile');
Route::post('/updateProfile','ProfileController@updateProfile');
