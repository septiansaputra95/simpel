<?php

use App\Http\Controllers\BPJS\AntrianOnlineController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('content');
});

Route::group(['namespace' => 'App\Http\Controllers\BPJS', 'prefix' => 'BPJS'], function() {
    //Route::get('/antrianonline', [AntrianOnlineController::class, 'index'])->name('antrianonline.index');
    Route::get('/antrianonline', 'AntrianOnlineController@index')->name('antrianonline.index');
    Route::get('/antrianonline/datatables', 'AntrianOnlineController@loadDatatables');
    Route::get('/antrianonline/simpan', 'AntrianOnlineController@store');

    Route::get('/tasklist', 'TaskListController@index')->name('tasklist.index');
    Route::post('/tasklist/datatables', 'TaskListController@loadDatatables');
    Route::post('/tasklist/getTask', 'TaskListController@getTaskTanggal');
    Route::get('/tasklist/getKodeBooking', 'TaskListController@getKodeBooking');
    Route::get('/tasklist/simpan', 'TaskListController@store');
    

    Route::get('/updatetask', 'UpdateTaskController@index')->name('updatetask.index');
    Route::post('/updatetask/postTask', 'UpdateTaskController@postTask');
    Route::get('/updatetask/getKodeBooking', 'UpdateTaskController@getKodeBooking');



});