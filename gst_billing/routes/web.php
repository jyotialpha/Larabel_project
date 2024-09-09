<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [AppController::class, 'index']);
