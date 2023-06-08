<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CommandeController;

Route::get('/', [ServiceController::class, 'index'])->name('home');

Route::get('/services', [ServiceController::class, 'index'])->name('services');

Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes');

