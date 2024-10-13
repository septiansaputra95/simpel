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
    Route::get('/antrianonline/digitalclock', 'AntrianOnlineController@digitalClock')->name('antrianonline.digitalclock');

    Route::get('/tasklist', 'TaskListController@index')->name('tasklist.index');
    Route::post('/tasklist/datatables', 'TaskListController@loadDatatables');
    Route::post('/tasklist/getTask', 'TaskListController@getTaskTanggal');
    Route::get('/tasklist/getKodeBooking', 'TaskListController@getKodeBooking');
    Route::get('/tasklist/simpan', 'TaskListController@store');
    Route::get('/tasklist/autostore', 'TaskListController@autoStore')->name('tasklist.autostore');
    Route::get('/tasklist/digitalclock', 'TaskListController@digitalClock')->name('tasklist.digitalclock');
    

    Route::get('/updatetask', 'UpdateTaskController@index')->name('updatetask.index');
    Route::post('/updatetask/postTask', 'UpdateTaskController@postTask');
    Route::get('/updatetask/getKodeBooking', 'UpdateTaskController@getKodeBooking');
    Route::get('/updatetask/antrean', 'UpdateTaskController@getAntrean');
    Route::get('/updatetask/getTask6', 'UpdateTaskController@getTask6');
    Route::get('/updatetask/autoupdate', 'UpdateTaskController@autoUpdateTask')->name('updatetask.autoupdate');
    Route::get('/updatetask/autoupdate7', 'UpdateTaskController@autoUpdateTask7')->name('updatetask.autoupdate7');
    Route::get('/updatetask/autoupdateerror', 'UpdateTaskController@autoUpdateTaskError')->name('updatetask.autoupdateerror');
    Route::get('/updatetask/autoadd', 'UpdateTaskController@autoAddTask')->name('updatetask.autoadd');
    Route::get('/updatetask/autoaddantrean', 'UpdateTaskController@autoAddAntrean')->name('updatetask.autoaddantrean');
    Route::get('/updatetask/digitalclock', 'UpdateTaskController@digitalClock')->name('updatetask.digitalclock');
    
    Route::get('/referensidokter', 'ReferensiDokterController@index')->name('referensi.index');
    Route::get('/referensipoli', 'ReferensiPoliController@index')->name('referensipoli.index');
    Route::get('/peserta', 'PesertaController@index')->name('peserta.index');
    Route::get('/jadwaldokter', 'JadwalDokterController@index')->name('jadwaldokter.index');
    Route::get('/baymanagement', 'BaymanagementController@index')->name('baymanagement.index');
    

    Route::get('/peserta/digitalclock', 'PesertaController@digitalClock');
    Route::get('/jadwaldokter/digitalclock', 'JadwalDokterController@digitalClock');

    Route::get('/sep/autostore', 'SEPController@autoStore')->name('sep.autostore');
    Route::get('/sep/autostorekunjungan', 'SEPController@autoStoreKunjungan')->name('sep.autostorekunjungan');
    Route::get('/sep/autoselisih', 'SEPController@autoSelisih')->name('sep.autoselisih');



});