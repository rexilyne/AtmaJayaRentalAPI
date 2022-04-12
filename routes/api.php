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

Route::controller(CustomerController::class)->group(function () {
    Route::get('/customer', 'index');
    Route::get('/customer/{id}', 'show');
    Route::post('/customer', 'store');
    Route::put('/customer/{id}', 'update');
    Route::delete('/customer/{id}', 'destroy');
});

Route::controller(DetailJadwalController::class)->group(function () {
    Route::get('/detailjadwal', 'index');
    Route::get('/detailjadwal/get/idpegawai/{id}', 'showByIdPegawai');
    Route::get('/detailjadwal/get/idjadwal/{id}', 'showByIdJadwal');
    Route::post('/detailjadwal', 'store');
    Route::put('/detailjadwal/update/idpegawai/{id}', 'updateByIdPegawai');
    Route::put('/detailjadwal/update/idjadwal/{id}', 'updateByIdJadwal');
    Route::delete('/detailjadwal/delete/idpegawai/{id}', 'destroyByIdPegawai');
    Route::delete('/detailjadwal/delete/idjadwal/{id}', 'destroyByIdJadwal');
    Route::get('/detailjadwal/ceksyaratpenjadwalan', 'cekSyaratPenjadwalan');
});

Route::controller(DriverController::class)->group(function () {
    Route::get('/driver', 'index');
    Route::get('/driver/{id}', 'show');
    Route::post('/driver', 'store');
    Route::put('/driver/{id}', 'update');
    Route::delete('/driver/{id}', 'destroy');
    Route::get('/driver/showavailable', 'showAvailable');
});

Route::controller(JadwalController::class)->group(function () {
    Route::get('/jadwal', 'index');
    Route::get('/jadwal/{id}', 'show');
    Route::post('/jadwal', 'store');
    Route::put('/jadwal/{id}', 'update');
    Route::delete('/jadwal/{id}', 'destroy');
});

Route::controller(MobilController::class)->group(function () {
    Route::get('/mobil', 'index');
    Route::get('/mobil/{id}', 'show');
    Route::post('/mobil', 'store');
    Route::put('/mobil/{id}', 'update');
    Route::delete('/mobil/{id}', 'destroy');
    Route::get('/mobil/showavailable', 'showAvailabe');
    Route::get('/mobil/showkontrakakanhabis', 'showKontrakAkanHabis');
    Route::put('/mobil/updateperiodekontrak/{id}', 'updatePeriodeKontrak');
});

Route::controller(PegawaiController::class)->group(function () {
    Route::get('/pegawai', 'index');
    Route::get('/pegawai/{id}', 'show');
    Route::post('/pegawai', 'store');
    Route::put('/pegawai/{id}', 'update');
    Route::delete('/pegawai/{id}', 'destroy');
});

Route::controller(PemilikMobilController::class)->group(function () {
    Route::get('/pemilikmobil', 'index');
    Route::get('/pemilikmobil/{id}', 'show');
    Route::post('/pemilikmobil', 'store');
    Route::put('/pemilikmobil/{id}', 'update');
    Route::delete('/pemilikmobil/{id}', 'destroy');
});

Route::controller(PenyewaanController::class)->group(function () {
    Route::get('/penyewaan', 'index');
    Route::get('/penyewaan/get/idpenyewaan/{id}', 'showByIdPenyewaan');
    Route::get('/penyewaan/get/idcustomer/{id}', 'showByIdCustomer');
    Route::get('/penyewaan/get/iddriver/{id}', 'showByIdDriver');
    Route::post('/penyewaan', 'store');
    Route::put('/penyewaan/{id}', 'update');
    Route::delete('/penyewaan/{id}', 'destroy');
});

Route::controller(PromoController::class)->group(function () {
    Route::get('/promo', 'index');
    Route::get('/promo/{id}', 'show');
    Route::post('/promo', 'store');
    Route::put('/promo/{id}', 'update');
    Route::delete('/promo/{id}', 'destroy');
    Route::get('/promo/showactive', 'showActive');
});