<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\ServiceController::class, 'index'])->name('home');
Route::get('/services', [App\Http\Controllers\ServiceController::class, 'index'])->name('home');
Route::get('/commandes', [App\Http\Controllers\CommandeController::class, 'index'])->name('home');
