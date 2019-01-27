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

Route::get('/', function () {
    return view('home');
});


Route::get('/tasks', 'TaskController@getAllTasks');
Route::post('/task', 'TaskController@ginsertTask');
Route::post('/task/{id}', 'TaskController@deleteTask');
Route::put('/task/{id}', 'TaskController@updateTask');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
