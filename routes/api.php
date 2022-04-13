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
use App\Http\Controllers\Api\CustomerAuthControlller;
use App\Http\Controllers\Api\DriverAuthController;
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

Route::controller(CustomerAuthControlller::class)->group(function() {
    Route::post('/register/customer', 'register');
    Route::post('/login/customer', 'login');
});

Route::controller(DriverAuthControlller::class)->group(function() {
    Route::post('/register/driver', 'register');
    Route::post('/login/driver', 'login');
});

Route::controller(PegawaiAuthControlller::class)->group(function() {
    Route::post('/register/pegawai', 'register');
    Route::post('/login/pegawai', 'login');
});

Route::controller(CustomerController::class)->middleware('auth:customer_api')->group(function () {
    Route::get('/customer', 'index');
    Route::get('/customer/show/{id}', 'show');
    Route::post('/customer/store', 'store');
    Route::put('/customer/update/{id}', 'update');
    Route::delete('/customer/delete/{id}', 'destroy');
});

Route::controller(DetailJadwalController::class)->group(function () {
    Route::get('/detailjadwal', 'index');
    Route::get('/detailjadwal/get/idpegawai/{id}', 'showByIdPegawai');
    Route::get('/detailjadwal/get/idjadwal/{id}', 'showByIdJadwal');
    Route::post('/detailjadwal/store', 'store');
    Route::put('/detailjadwal/update/idpegawai/{id}', 'updateByIdPegawai');
    Route::put('/detailjadwal/update/idjadwal/{id}', 'updateByIdJadwal');
    Route::delete('/detailjadwal/delete/idpegawai/{id}', 'destroyByIdPegawai');
    Route::delete('/detailjadwal/delete/idjadwal/{id}', 'destroyByIdJadwal');
    Route::get('/detailjadwal/ceksyaratpenjadwalan', 'cekSyaratPenjadwalan');
});

Route::controller(DriverController::class)->middleware('auth:driver_api')->group(function () {
    Route::get('/driver', 'index');
    Route::get('/driver/show/{id}', 'show');
    Route::post('/driver/store', 'store');
    Route::put('/driver/update/{id}', 'update');
    Route::delete('/driver/delete/{id}', 'destroy');
    Route::get('/driver/showavailable', 'showAvailable');
});

Route::controller(JadwalController::class)->group(function () {
    Route::get('/jadwal', 'index');
    Route::get('/jadwal/show/{id}', 'show');
    Route::post('/jadwal/store', 'store');
    Route::put('/jadwal/update/{id}', 'update');
    Route::delete('/jadwal/delete/{id}', 'destroy');
});

Route::controller(MobilController::class)->group(function () {
    Route::get('/mobil', 'index');
    Route::get('/mobil/show/{id}', 'show');
    Route::post('/mobil/store', 'store');
    Route::put('/mobil/update/{id}', 'update');
    Route::delete('/mobil/delete/{id}', 'destroy');
    Route::get('/mobil/showavailable', 'showAvailabe');
    Route::get('/mobil/showkontrakakanhabis', 'showKontrakAkanHabis');
    Route::put('/mobil/updateperiodekontrak/{id}', 'updatePeriodeKontrak');
});

Route::controller(PegawaiController::class)->middleware('auth:pegawai_api')->group(function () {
    Route::get('/pegawai', 'index');
    Route::get('/pegawai/show/{id}', 'show');
    Route::post('/pegawai/store', 'store');
    Route::put('/pegawai/update/{id}', 'update');
    Route::delete('/pegawai/delete/{id}', 'destroy');
});

Route::controller(PemilikMobilController::class)->group(function () {
    Route::get('/pemilikmobil', 'index');
    Route::get('/pemilikmobil/show/{id}', 'show');
    Route::post('/pemilikmobil/store', 'store');
    Route::put('/pemilikmobil/update/{id}', 'update');
    Route::delete('/pemilikmobil/delete/{id}', 'destroy');
});

Route::controller(PenyewaanController::class)->group(function () {
    Route::get('/penyewaan', 'index');
    Route::get('/penyewaan/show/idpenyewaan/{id}', 'showByIdPenyewaan');
    Route::get('/penyewaan/show/idcustomer/{id}', 'showByIdCustomer');
    Route::get('/penyewaan/show/iddriver/{id}', 'showByIdDriver');
    Route::post('/penyewaan/store', 'store');
    Route::put('/penyewaan/update/{id}', 'update');
    Route::delete('/penyewaan/delete/{id}', 'destroy');
});

Route::controller(PromoController::class)->group(function () {
    Route::get('/promo', 'index')->middleware(['auth:driver_api']);
    Route::get('/promo/show/{id}', 'show');
    Route::post('/promo/store', 'store');
    Route::put('/promo/update/{id}', 'update');
    Route::delete('/promo/delete/{id}', 'destroy');
    Route::get('/promo/showactive', 'showActive');
});