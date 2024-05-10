<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
Route::get('/', function () {
    return view('welcome');
});
// Route::get('/account/register',[AccountController::class, 'register'])->name('account.register');
// Route::get('/account/login',[AccountController::class, 'login'])->name('account.login');
// Route::post('/account/processRegister',[AccountController::class, 'processRegister'])->name('account.processRegister');
// Route::post('/account/authenticate',[AccountController::class, 'authenticate'])->name('account.authenticate');

// Route::get('/account/profile',[AccountController::class, 'profile'])->name('account.profile');

Route::group(['prefix' => 'account'] ,function() {
    Route::group(['middleware' => 'guest'] ,function() {
        Route::get('/register',[AccountController::class, 'register'])->name('account.register');
        Route::get('/login',[AccountController::class, 'login'])->name('account.login');
        Route::post('/processRegister',[AccountController::class, 'processRegister'])->name('account.processRegister');
        Route::post('/authenticate',[AccountController::class, 'authenticate'])->name('account.authenticate');
    });
    Route::group(['middleware' => 'auth'] ,function() {
        Route::get('/profile',[AccountController::class, 'profile'])->name('account.profile');
        Route::post('/updateProfile',[AccountController::class, 'updateProfile'])->name('account.updateProfile');
        Route::get('/logout',[AccountController::class, 'logout'])->name('account.logout');
    });
});