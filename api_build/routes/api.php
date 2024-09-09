<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;
use App\Http\Controllers\Api\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('create-user',[UserController::class,'createUser']);
Route::get('get-user',[UserController::class,'getUser']);
Route::get('get-userByid/{id}',[UserController::class,'getUserById']);
Route::put('update-userByid/{id}',[UserController::class,'updateUserById']);
Route::delete('delete-userByid/{id}',[UserController::class,'deleteUserById']);
