<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\ServiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Fetch command data
Route::get('/commande/details/{id}', [CommandeController::class, 'show'])->name('commande.show');
Route::get('/commande/update/{id}', [CommandeController::class, 'getDataUpdate'])->name('commande.update-data');

// Get price for each service and quantity
Route::get('service/{name}/{quantity}', [ServiceController::class, 'getPrice'])->name('service.price');


