<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GamblerController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::middleware('auth.hash')->prefix('/dashboard/{hash}/')->group(function () {
    Route::post('gamble', [GamblerController::class, 'gamble'])->name('gamble');
    Route::patch('reset-link', [AuthController::class, 'resetHash'])->name('resetHash');
    Route::patch('remove-link', [AuthController::class, 'removeHash'])->name('removeHash');
    Route::get('history', [GamblerController::class, 'history'])->name('history');
});



