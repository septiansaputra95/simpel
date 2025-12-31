<?php

use App\Http\Controllers\BPJS\AntrianOnlineController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\DokterEmail;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Menu\MenuController;
use App\Http\Controllers\Master\MasterDokterController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\GudangUmum\GudangStokController;


// Route::get('/', function () {
//     return view('newcontent');
// })->middleware('auth');
Route::get('/', function () {
    return view('newcontent');
})->name('home')->middleware(['auth']);

// Route::group(['namespace' => 'App\Http\Controllers\BPJS', 'prefix' => 'BPJS', 'middleware' => ['auth', 'role:admin']], function() {
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
    

    Route::post('/updatetask/postTask', 'UpdateTaskController@postTask');
    Route::post('/updatetask/batal', 'UpdateTaskController@batalAntrean');
    Route::post('/updatetask/postAddAntrean', 'UpdateTaskController@postAddAntrean');
    Route::get('/updatetask/getKodeBooking', 'UpdateTaskController@getKodeBooking');
    Route::get('/updatetask', 'UpdateTaskController@index')->name('updatetask.index');
    Route::get('/updatetask/antrean', 'UpdateTaskController@getAntrean');
    Route::get('/updatetask/getTask6', 'UpdateTaskController@getTask6');
    Route::get('/updatetask/getSelisih', 'UpdateTaskController@getSelisih');
    Route::get('/updatetask/getJadwalDokterPoli', 'UpdateTaskController@getJadwalDokterPoli');
    Route::get('/updatetask/getPoliklinik', 'UpdateTaskController@getPoliklinik');
    Route::get('/updatetask/getAntrianPoliklinik', 'UpdateTaskController@getAntrianPoliklinik');
    Route::get('/updatetask/autoupdate', 'UpdateTaskController@autoUpdateTask')->name('updatetask.autoupdate');
    Route::get('/updatetask/autoupdate7', 'UpdateTaskController@autoUpdateTask7')->name('updatetask.autoupdate7');
    Route::get('/updatetask/autoupdateerror', 'UpdateTaskController@autoUpdateTaskError')->name('updatetask.autoupdateerror');
    Route::get('/updatetask/autoaddantrean', 'UpdateTaskController@autoAddAntrean')->name('updatetask.autoaddantrean');
    Route::get('/updatetask/digitalclock', 'UpdateTaskController@digitalClock')->name('updatetask.digitalclock');
    Route::get('/updatetask/autoadd', 'UpdateTaskController@autoAddTask')->name('updatetask.autoadd');
    
    Route::get('/referensidokter', 'ReferensiDokterController@index')->name('referensi.index');
    Route::get('/referensipoli', 'ReferensiPoliController@index')->name('referensipoli.index');
    Route::get('/peserta', 'PesertaController@index')->name('peserta.index');
    Route::get('/jadwaldokter', 'JadwalDokterController@index')->name('jadwaldokter.index');
    Route::get('/baymanagement', 'BaymanagementController@index')->name('baymanagement.index');
    
    Route::get('/suratkontrol', 'TanggalSuratKontrolController@index')->name('suratkontrol.index');

    Route::get('/peserta/digitalclock', 'PesertaController@digitalClock');
    Route::get('/jadwaldokter/digitalclock', 'JadwalDokterController@digitalClock');

    Route::get('/sep/autostore', 'SEPController@autoStore')->name('sep.autostore');
    Route::get('/sep/autostorekunjungan', 'SEPController@autoStoreKunjungan')->name('sep.autostorekunjungan');
    Route::get('/sep/autoselisih', 'SEPController@cariselisih')->name('sep.autoselisih');
    Route::get('/sep/cariselisih', 'SEPController@cariselisih')->name('sep.cariselisih');



});

// Route::group([
//     'namespace' => 'App\Http\Controllers\Keuangan',
//     'prefix' => 'Keuangan',
//     'middleware' => ['auth', 'role:admin|keuangan']
// ], function () {
Route::group(['namespace' => 'App\Http\Controllers\Keuangan', 'prefix' => 'Keuangan'], function() {
    Route::get('/honordokter', 'PengirimanHDController@index')->name('honordokter.index');
    Route::get('/honordokter/datatables', 'PengirimanHDController@loadDatatables');
    Route::get('/honordokter/getDokter', 'PengirimanHDController@getDokter');
    // Route::post('/honordokter/simpan', 'PengirimanHDController@store');
    Route::post('/honordokter/simpan', 'PengirimanHDController@storeHonor');
    Route::post('/honordokter/kirim', 'PengirimanHDController@send');

    Route::get('/honordokter/auth/google', 'PengirimanHDController@redirectToGoogle');
    Route::get('/honordokter/auth/google/callback', 'PengirimanHDController@handleGoogleCallback');
});

// Route::group(['namespace' => 'App\Http\Controllers\Master', 'prefix' => 'Master'], function() {
Route::middleware(['auth', 'check.menu.access'])->group(function () {
    Route::get('/masterdokter', [MasterDokterController::class, 'index'])->name('masterdokter.index');
    Route::get('/masterdokter/datatables', [MasterDokterController::class, 'loadDatatables'])->name('masterdokter.loadDatatables');
    Route::post('/masterdokter/simpan', [MasterDokterController::class, 'simpan'])->name('masterdokter.simpan');
    Route::post('/masterdokter/update', [MasterDokterController::class, 'update'])->name('masterdokter.update');
});

// Route::prefix('menu')->group(function () {
Route::middleware(['auth', 'check.menu.access'])->group(function () {
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/datatables', [MenuController::class, 'loadDatatables'])->name('menu.datatables');
    Route::get('/menu/getParent', [MenuController::class, 'getParent'])->name('menu.getParent');
    Route::post('/menu/simpan', [MenuController::class, 'store'])->name('menu.simpan');
});

// Route::group(['namespace' => 'App\Http\Controllers\User', 'prefix' => 'User'], function() {
Route::middleware(['auth', 'check.menu.access'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/datatables', [UserController::class, 'loadDatatables'])->name('user.loadDatatables');
    Route::get('/user/rolesdatatables', [UserController::class, 'rolesloadDatatables'])->name('user.rolesloadDatatables');
    Route::get('/user/{id}/accessRole', [UserController::class, 'accessRole'])->name('user.accessRole');
});

// GUDANG UMUM
Route::middleware(['auth', 'check.menu.access'])->group(function () {
    Route::get('/stokgudang', [GudangStokController::class, 'index'])->name('stokgudang.index');
    Route::get('/stokgudang/datatables', [GudangStokController::class, 'loadDatatables'])->name('stokgudang.loadDatatables');
    Route::post('/stokgudang/simpan', [GudangStokController::class, 'store'])->name('stokgudang.simpan');
    Route::post('/stokgudang/update', [GudangStokController::class, 'update'])->name('stokgudang.update');
});

Route::get('/mail/send', function () {
    $data = [
        'subject' => 'Testing Kirim Email',
        'title' => 'Testing Kirim Email',
        'body' => 'Ini adalah email uji coba dari Tutorial Laravel: Send Email Via SMTP GMAIL @ qadrLabs.com'
    ];

    Mail::to('septiansap@gmail.com')->send(new DokterEmail($data));

});
require __DIR__.'/auth.php';

// Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('login', [LoginController::class, 'login']);
// Route::post('logout', [LoginController::class, 'logout'])->name('logout');