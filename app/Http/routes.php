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

Route::get('/', function () {
    return view('student.login');
});


//Student URL
Route::group(['middleware' => ['student']], function () {  

Route::get('student/login', 'StudentController@displayLogin');
Route::post('student/login', 'StudentController@login');
Route::get('student/logout', 'StudentController@logout');

	Route::group(['middleware' =>['studentauth']], function(){
		Route::get('student/index', 'StudentController@index');

    });
});

//Admin URL
Route::group(['middleware' => ['web']], function () {

Route::get('user/login', 'UserController@displayLogin');
Route::post('user/login', 'UserController@login');
Route::get('user/logout', 'UserController@logout');

	Route::group(['middleware' =>['auth']], function(){

		Route::get('user/index', 'UserController@index');
		Route::get('user/hod', 'UserController@showHod');
		Route::get('user/lecturer', 'UserController@showLecturer');
    });
});

//LecturerURL
Route::group(['middleware' => ['web']], function () {

Route::get('lecturer/login', 'LecturerController@displayLogin');
Route::post('lecturer/login', 'LecturerController@login');
Route::get('lecturer/logout', 'LecturerController@logout');

	Route::group(['middleware' =>['lecturerauth']], function(){
		Route::get('lecturer/index', 'LecturerController@index');
    });
});

//HOD URL
Route::group(['middleware' => ['web']], function () {
	
Route::get('hod/login', 'HodController@displayLogin');
Route::post('hod/login', 'HodController@login');
Route::get('hod/logout', 'HodController@logout');

	Route::group(['middleware' =>['hodauth']], function(){
		Route::get('hod/index', 'HodController@index');
    });
});