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
    Route::get('/antrianonline/autostore', 'AntrianOnlineController@autostore')->name('antrianonline.autostore');
    Route::get('/antrianonline/digitalclock', 'AntrianOnlineController@digitalClock');

    Route::get('/tasklist', 'TaskListController@index')->name('tasklist.index');
    Route::post('/tasklist/datatables', 'TaskListController@loadDatatables');
    Route::post('/tasklist/getTask', 'TaskListController@getTaskTanggal');
    Route::get('/tasklist/getKodeBooking', 'TaskListController@getKodeBooking');
    Route::get('/tasklist/simpan', 'TaskListController@store');
    Route::get('/tasklist/autostore', 'TaskListController@autoStore')->name('tasklist.autostore');
    Route::get('/tasklist/digitalclock', 'TaskListController@digitalClock');
    

    Route::get('/updatetask', 'UpdateTaskController@index')->name('updatetask.index');
    Route::post('/updatetask/postTask', 'UpdateTaskController@postTask');
    Route::get('/updatetask/getKodeBooking', 'UpdateTaskController@getKodeBooking');
    Route::get('/updatetask/autoupdate', 'UpdateTaskController@autoUpdateTask')->name('updatetask.autoupdate');
    Route::get('/updatetask/autoadd', 'UpdateTaskController@autoAddTask')->name('updatetask.autoadd');
    Route::get('/updatetask/digitalclock', 'UpdateTaskController@digitalClock');

    Route::get('/referensidokter', 'ReferensiDokterController@index')->name('referensi.index');
    Route::get('/referensipoli', 'ReferensiPoliController@index')->name('referensipoli.index');
    Route::get('/peserta', 'PesertaController@index')->name('peserta.index');
    Route::get('/jadwaldokter', 'JadwalDokterController@index')->name('jadwaldokter.index');
    Route::get('/baymanagement', 'BaymanagementController@index')->name('baymanagement.index');
    

    Route::get('/peserta/digitalclock', 'PesertaController@digitalClock');
    Route::get('/jadwaldokter/digitalclock', 'JadwalDokterController@digitalClock');


});