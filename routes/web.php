<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CommandeController;

Route::get('/', function () {
    return redirect()->route('services.index');
});

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
Route::put('/service/{id}', [ServiceController::class, 'update'])->name('services.update');
Route::delete('/service/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');

Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.store');
Route::put('/commande/{id}', [CommandeController::class, 'update'])->name('commandes.update');
Route::delete('/commande/{id}', [CommandeController::class, 'destroy'])->name('commandes.destroy');

