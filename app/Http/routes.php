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
Route::get('category','View\BookController@tocategory');
Route::get('product/category_id/{category_id}','View\BookController@tobooklist');
Route::get('register','View\MemberController@toregister');
Route::get('product/{product_id}','View\BookController@toproduct');



Route::group(['prefix' => 'service'], function () {
    Route::any('validatacode/create','Service\ValidataCodeController@create');
    Route::any('validatacode/send','Service\ValidataCodeController@sendSMS');
    Route::any('validate_email','Service\ValidataCodeController@validate_email');
    Route::post('register','Service\MemberController@register');
    Route::post('login','Service\MemberController@login');
    Route::get('getcategory/parent_id/{parent_id}','Service\BookController@getcategory');
});

