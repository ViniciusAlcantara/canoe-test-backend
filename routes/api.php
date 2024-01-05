<?php

use App\Http\Controllers\DuplicatedFundsController;
use App\Http\Controllers\FundController;
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
Route::get('/fund/duplicates/{fund_manager_id}', DuplicatedFundsController::class);

Route::post('/fund/index', [FundController::class, 'index']);
Route::post('/fund/create', [FundController::class, 'create']);
Route::patch('/fund/update', [FundController::class, 'update']);
Route::delete('/fund/delete/{fund_id}', [FundController::class, 'delete']);
