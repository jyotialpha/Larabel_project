<?php

use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::group(['prefix' => 'acount'], function () {

    //*Gust middleware
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [LoginController::class, 'index'])->name('acount.login');
        Route::get('/register', [LoginController::class, 'register'])->name('acount.register');
        Route::post('/processRegister', [LoginController::class, 'processRegister'])->name('acount.processRegister');
        Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('acount.authenticate');
    });


    //*Authenticate Middleware
    Route::group(['middleware' => 'auth'], function () {

        Route::get('/dashboard', [dashboardController::class, 'index'])->name('acount.dashboard');
        Route::get('/logout', [LoginController::class, 'logout'])->name('acount.logout');
        Route::get('/profile', [LoginController::class, 'profile'])->name('admin.userProfile');
        // Show user profile details
        Route::get('/details', [UserController::class, 'showDetails'])->name('acount.details');

        // Show the form for updating the password
        Route::get('/update-password', [UserController::class, 'showUpdatePasswordForm'])->name('acount.updatePasswordForm');

        // Handle password update form submission
        Route::post('/update-password', [UserController::class, 'updatePassword'])->name('acount.updatePassword');
    });
});


Route::group(['prefix' => 'admin'], function () {

    //*Gust middleware For Admin
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::get('/register', [AdminLoginController::class, 'register'])->name('admin.register');
        Route::post('/processRegister', [AdminLoginController::class, 'processRegister'])->name('admin.processRegister');
        Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });


    //*Authenticate Middleware For Admin
    Route::group(['middleware' => 'auth'], function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.AdminDashboard');
        Route::get('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('admin.users.show');
        Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    });
});
