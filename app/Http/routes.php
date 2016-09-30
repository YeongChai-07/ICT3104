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
		Route::get('student/recommendation', 'StudentController@recommendation');
    });
});

//Admin URL
Route::group(['middleware' => ['web']], function () {

Route::get('user/login', 'UserController@displayLogin');
Route::post('user/login', 'UserController@login');
Route::get('user/logout', 'UserController@logout');

	Route::group(['middleware' =>['auth']], function(){

		Route::get('user/index', 'UserController@index');
		Route::get('/user/addstudent', 'UserController@showAddStudent');
        Route::post('/user/addstudent', 'UserController@addStudent');
        Route::get('/user/{id}/editstudent', 'UserController@editStudent');
        Route::post('/user/{id}/editstudent', 'UserController@updateStudent');
        Route::get('/user/{id}/deletestudent', 'UserController@deleteStudent');

		Route::get('user/hod', 'UserController@showHod');
		Route::get('/user/addhod', 'UserController@showAddHod');
        Route::post('/user/addhod', 'UserController@addHod');
        Route::get('/user/{id}/edithod', 'UserController@editHod');
        Route::post('/user/{id}/edithod', 'UserController@updateHod');
        Route::get('/user/{id}/deletehod', 'UserController@deleteHod');

		Route::get('user/lecturer', 'UserController@showLecturer');
		Route::get('/user/addlecturer', 'UserController@showAddLecturer');
        Route::post('/user/addlecturer', 'UserController@addLecturer');
        Route::get('/user/{id}/editlecturer', 'UserController@editLecturer');
        Route::post('/user/{id}/editlecturer', 'UserController@updateLecturer');
        Route::get('/user/{id}/deletelecturer', 'UserController@deleteLecturer');

    });
});

//LecturerURL
Route::group(['middleware' => ['lecturer']], function () {

Route::get('lecturer/login', 'LecturerController@displayLogin');
Route::post('lecturer/login', 'LecturerController@login');
Route::get('lecturer/logout', 'LecturerController@logout');

	Route::group(['middleware' =>['lecturerauth']], function(){
		
		Route::get('lecturer/index', 'LecturerController@index');
        Route::get('lecturer/{id}/managegrade', 'LecturerController@showManageGrade');
    });
});

//HOD URL
Route::group(['middleware' => ['hod']], function () {
	
Route::get('hod/login', 'HodController@displayLogin');
Route::post('hod/login', 'HodController@login');
Route::get('hod/logout', 'HodController@logout');

	Route::group(['middleware' =>['hodauth']], function(){
		Route::get('hod/index', 'HodController@index');
    });
});