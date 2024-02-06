<?php

use App\Http\Controllers\CarController;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::resource('cars', CarController::class)->except('create', 'edit', 'show');
Route::get('cars/first/{type}', [CarController::class, 'showFirst'])->name('cars.showFirst');
Route::delete('cars/first/{type}', [CarController::class, 'destroyFirst'])->name('cars.destroyFirst');
