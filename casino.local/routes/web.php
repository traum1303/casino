<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::get('/dashboard/{hash}', function () {
    return view('welcome');
})->withoutMiddleware('auth.hash');

