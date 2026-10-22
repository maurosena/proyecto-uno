<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return view('home.home');
})->name('home');

Route::resource('productos', ProductController::class);
Route::get('productos/pdf/{id}', [ProductController::class, 'pdf'])->name('pdf');
Route::resource('movimientos', MovementController::class);
Route::resource('proveedores', ProviderController::class);
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('/manual-usuario', [ManualController::class, 'index'])->name('manual.index');
