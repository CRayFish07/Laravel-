<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use \App\Entity\Category;
Route::get('/', function () {
    return view('login');
});

Route::get('login','View\MemberController@tologin');

Route::get('register','View\MemberController@toregister');



Route::any('service/validatacode/create','Service\ValidataCodeController@create');
Route::any('service/validatacode/send','Service\ValidataCodeController@sendSMS');
