<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DetailJadwalController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\JadwalController;
use App\Http\Controllers\Api\MobilController;
use App\Http\Controllers\Api\PegawaiController;
use App\Http\Controllers\Api\PemilikMobilController;
use App\Http\Controllers\Api\PenyewaanController;
use App\Http\Controllers\Api\PromoController;
use App\Http\Controllers\Api\CustomerAuthController;
use App\Http\Controllers\Api\DriverAuthController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\PegawaiAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/storeimage', [ImageController::class, 'storeImage']);

Route::controller(CustomerAuthController::class)->group(function() {
    Route::post('/register/customer', 'register');
    Route::post('/login/customer', 'login');
    Route::post('/logout/customer', 'logout')->middleware('auth:customer_api');
});

Route::controller(DriverAuthController::class)->group(function() {
    Route::post('/register/driver', 'register');
    Route::post('/login/driver', 'login');
    Route::post('/logout/driver', 'logout')->middleware('auth:driver_api');
});

Route::controller(PegawaiAuthController::class)->group(function() {
    Route::post('/register/pegawai', 'register');
    Route::post('/login/pegawai', 'login');
    Route::post('/logout/pegawai', 'logout')->middleware('auth:pegawai_api');
});

//TODO : tambahin policy
Route::controller(CustomerController::class)->middleware('auth:customer_api')->group(function () {
    Route::get('/customer', 'index');
    Route::get('/customer/show/{id}', 'show');
    Route::post('/customer/store', 'store');
    Route::put('/customer/update/{id}', 'update');
    Route::delete('/customer/delete/{id}', 'destroy');
});

Route::controller(CustomerController::class)->middleware(['auth:customer_api', 'role.customerservice'])->group(function () {
    Route::get('/keloladata/customer', 'index');
    Route::get('/keloladata/customer/show/{id}', 'show');
    Route::post('/keloladata/customer/store', 'store');
    Route::put('/keloladata/customer/update/{id}', 'update');
    Route::delete('/keloladata/customer/delete/{id}', 'destroy');
});

Route::controller(DetailJadwalController::class)->middleware('auth:pegawai_api')->group(function () {
    Route::get('/detailjadwal', 'index');
    Route::get('/detailjadwal/get/idpegawai/{id}', 'showByIdPegawai');
    Route::get('/detailjadwal/get/idjadwal/{id}', 'showByIdJadwal');
});

Route::controller(DetailJadwalController::class)->middleware(['auth:pegawai_api', 'role.manager'])->group(function () {
    Route::get('/keloladata/detailjadwal', 'index');
    Route::get('/keloladata/detailjadwal/get/idpegawai/{id}', 'showByIdPegawai');
    Route::get('/keloladata/detailjadwal/get/idjadwal/{id}', 'showByIdJadwal');
    Route::post('/keloladata/detailjadwal/store', 'store');
    Route::put('/keloladata/detailjadwal/update/{id_pegawai}/{id_jadwal}', 'update');
    // Route::put('/keloladata/detailjadwal/update/idjadwal/{id}', 'updateByIdJadwal');
    Route::delete('/keloladata/detailjadwal/delete/{id_pegawai}/{id_jadwal}', 'destroy');
    // Route::delete('/keloladata/detailjadwal/delete/idjadwal/{id}', 'destroyByIdJadwal');
    Route::get('/keloladata/detailjadwal/ceksyaratpenjadwalan', 'cekSyaratPenjadwalan');
});

//TODO : tambahin policy
Route::controller(DriverController::class)->middleware('auth:driver_api')->group(function () {
    Route::get('/driver', 'index');
    Route::get('/driver/show/{id}', 'show');
    Route::post('/driver/store', 'store');
    Route::put('/driver/update/{id}', 'update');
    Route::delete('/driver/delete/{id}', 'destroy');
    Route::get('/driver/showavailable', 'showAvailable');
});

Route::controller(DriverController::class)->middleware('auth:pegawai_api')->group(function () {
    Route::get('/keloladata/driver', 'index');
    Route::get('/keloladata/driver/show/{id}', 'show');
    Route::post('/keloladata/driver/store', 'store');
    Route::put('/keloladata/driver/update/{id}', 'update');
    Route::delete('/keloladata/driver/delete/{id}', 'destroy');
    Route::get('/keloladata/driver/showavailable', 'showAvailable');
});

Route::controller(JadwalController::class)->middleware('auth:pegawai_api')->group(function () {
    Route::get('/jadwal', 'index');
    Route::get('/jadwal/show/{id}', 'show');
});

Route::controller(JadwalController::class)->middleware(['auth:pegawai_api', 'role.manager'])->group(function () {
    Route::get('/keloladata/jadwal', 'index');
    Route::get('/keloladata/jadwal/show/{id}', 'show');
    Route::post('/keloladata/jadwal/store', 'store');
    Route::put('/keloladata/jadwal/update/{id}', 'update');
    Route::delete('/keloladata/jadwal/delete/{id}', 'destroy');
    Route::get('/keloladata/jadwal/get/{hari}/{shift}', 'showByHariAndShift');
});

Route::controller(MobilController::class)->group(function () {
    Route::get('/mobil', 'index');
    Route::get('/mobil/show/{id}', 'show');
    Route::get('/mobil/showavailable', 'showAvailable');
});

Route::controller(MobilController::class)->middleware(['auth:pegawai_api', 'role.administrasi'])->group(function () {
    Route::get('/keloladata/mobil', 'index');
    Route::get('/keloladata/mobil/show/{id}', 'show');
    Route::post('/keloladata/mobil/store', 'store');
    Route::put('/keloladata/mobil/update/{id}', 'update');
    Route::delete('/keloladata/mobil/delete/{id}', 'destroy');
    Route::get('/keloladata/mobil/showavailable', 'showAvailable');
    Route::get('/keloladata/mobil/showkontrakakanhabis', 'showKontrakAkanHabis');
    Route::put('/keloladata/mobil/updateperiodekontrak/{id}', 'updatePeriodeKontrak');
});

//TODO : tambahin policy
Route::controller(PegawaiController::class)->middleware('auth:pegawai_api')->group(function () {
    Route::get('/pegawai', 'index');
    Route::get('/pegawai/show/{id}', 'show');
    Route::post('/pegawai/store', 'store');
    Route::put('/pegawai/update/{id}', 'update');
    Route::delete('/pegawai/delete/{id}', 'destroy');
});

Route::controller(PegawaiController::class)->middleware(['auth:pegawai_api', 'role.administrasi'])->group(function () {
    Route::get('/keloladata/pegawai', 'index');
    Route::get('/keloladata/pegawai/show/{id}', 'show');
    Route::post('/keloladata/pegawai/store', 'store');
    Route::put('/keloladata/pegawai/update/{id}', 'update');
    Route::delete('/keloladata/pegawai/delete/{id}', 'destroy');
});

Route::controller(PemilikMobilController::class)->middleware(['auth:pegawai_api', 'role.administrasi'])->group(function () {
    Route::get('/keloladata/pemilikmobil', 'index');
    Route::get('/keloladata/pemilikmobil/show/{id}', 'show');
    Route::post('/keloladata/pemilikmobil/store', 'store');
    Route::put('/keloladata/pemilikmobil/update/{id}', 'update');
    Route::delete('/keloladata/pemilikmobil/delete/{id}', 'destroy');
});

Route::controller(PenyewaanController::class)->group(function () { //belum ada middleware
    Route::get('/penyewaan', 'index');
    Route::get('/penyewaan/show/idpenyewaan/{id}', 'showByIdPenyewaan');
    Route::get('/penyewaan/show/idcustomer/{id}', 'showByIdCustomer');
    Route::get('/penyewaan/show/iddriver/{id}', 'showByIdDriver');
    Route::post('/penyewaan/store', 'store');
    Route::put('/penyewaan/update/{id}', 'update');
    Route::delete('/penyewaan/delete/{id}', 'destroy');
});

Route::controller(PromoController::class)->group(function () {
    Route::get('/promo', 'index');
    Route::get('/promo/show/{id}', 'show');
    Route::get('/promo/showactive', 'showActive');
});

Route::controller(PromoController::class)->middleware(['auth:pegawai_api', 'role.manager'])->group(function () {
    Route::get('/keloladata/promo', 'index');
    Route::get('/keloladata/promo/show/{id}', 'show');
    Route::post('/keloladata/promo/store', 'store');
    Route::put('/keloladata/promo/update/{id}', 'update');
    Route::delete('/keloladata/promo/delete/{id}', 'destroy');
    Route::get('/keloladata/promo/showactive', 'showActive');
});