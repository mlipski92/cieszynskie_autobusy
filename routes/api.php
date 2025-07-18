<?php

use App\Http\Controllers\Api\LineController;
use App\Http\Controllers\Api\StopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('stops', [StopController::class, 'getAllStops']);
Route::get('/stopsbyselectedstop/{id}', [StopController::class, 'getStopsBySelectedStop']);
Route::get('/getline/{idbegin}/{idend}', [LineController::class, 'getLineDetails']);

