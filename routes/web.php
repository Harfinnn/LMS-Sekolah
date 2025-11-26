<?php

use App\Http\Controllers\InformationController;
use App\Http\Controllers\Auth\ForgotResetController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/forgot-password', [ForgotResetController::class, 'showForm'])
        ->name('password.request');
    Route::post('/forgot-password', [ForgotResetController::class, 'sendResetLink'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [ForgotResetController::class, 'showForm'])
        ->name('password.reset');
    Route::post('/reset-password', [ForgotResetController::class, 'resetPassword'])
        ->name('password.update');
});

Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('guru', GuruController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('gallery', GalleryController::class)->parameters([
        'gallery' => 'gallery'
    ])->names('gallery');
    Route::post('gallery/reorder', [GalleryController::class, 'reorder'])->name('gallery.reorder');
    Route::resource('information', InformationController::class);
    Route::resource('schedule', ScheduleController::class);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/api/provinces', function () {
    $json = file_get_contents('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json');
    return response($json)->header('Content-Type', 'application/json');
});

Route::get('/api/regencies/{provinceId}', function ($provinceId) {
    $json = file_get_contents("https://emsifa.github.io/api-wilayah-indonesia/api/regencies/$provinceId.json");
    return response($json)->header('Content-Type', 'application/json');
});

Route::get('/api/districts/{regencyId}', function ($regencyId) {
    $json = file_get_contents("https://emsifa.github.io/api-wilayah-indonesia/api/districts/$regencyId.json");
    return response($json)->header('Content-Type', 'application/json');
});

Route::get('/api/villages/{districtId}', function ($districtId) {
    $json = file_get_contents("https://emsifa.github.io/api-wilayah-indonesia/api/villages/$districtId.json");
    return response($json)->header('Content-Type', 'application/json');
});
