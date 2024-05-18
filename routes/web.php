<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/detail/{id}', [HomeController::class, 'detail'])->name('detail');
Route::post('/saveReview', [HomeController::class, 'saveReview'])->name('saveReview');

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
        Route::get('/books',[BookController::class, 'index'])->name('books.list');
        Route::get('/book/create',[BookController::class, 'create'])->name('books.create');
        Route::post('/book/store',[BookController::class, 'store'])->name('books.store');
        Route::get('/book/edit/{id}',[BookController::class, 'edit'])->name('books.edit');
        Route::post('/book/update/{id}',[BookController::class, 'update'])->name('books.update');
        Route::get('/book/delete/{id}',[BookController::class, 'delete'])->name('books.delete');
        Route::get('/changePassword', [AccountController::class, 'changePassword'])->name('account.changePassword');
        Route::post('/changePasswordPost', [AccountController::class, 'changePasswordPost'])->name('account.changePasswordPost');
        Route::get('/reviews', [AccountController::class, 'reviews'])->name('account.reviews');
        Route::get('/review/delete/{id}',[AccountController::class, 'delete'])->name('review.delete');
        Route::get('/my-reviews', [AccountController::class, 'myReviews'])->name('account.myReviews');
        Route::get('/my-review/delete/{id}',[AccountController::class, 'destroy'])->name('myReview.delete');

    });
});