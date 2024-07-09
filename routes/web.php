<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\surat;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DenahStoController;

Route::get('/login', [UserController::class, 'index'])->name('login');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::get('/denah', [DenahStoController::class, 'index'])->name('index');
Route::get('/form', [MapController::class, 'create'])->name('formdenah');
Route::get('/surat', [surat::class, 'index'])->name('surat');

Route::get('/form', [DenahStoController::class, 'create']);
Route::post('/form', [DenahStoController::class, 'store'])->name('denah.store');



// Add other routes as needed
