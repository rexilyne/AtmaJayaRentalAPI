<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DetailJadwalController;
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
    Route::get('/detailjadwal/{id}', 'show');
    Route::post('/detailjadwal', 'store');
    Route::put('/detailjadwal/{id}', 'update');
    Route::delete('/detailjadwal/{id}', 'destroy');
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
    Route::get('/penyewaan/{id}', 'show');
    Route::post('/peneywaan', 'store');
    Route::put('/penyewaan/{id}', 'update');
    Route::delete('/penyewaan/{id}', 'destroy');
});

Route::controller(PromoController::class)->group(function () {
    Route::get('/promo', 'index');
    Route::get('/promo/{id}', 'show');
    Route::post('/promo', 'store');
    Route::put('/promo/{id}', 'update');
    Route::delete('/promo/{id}', 'destroy');
});