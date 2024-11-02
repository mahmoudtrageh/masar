<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', action: [HomeController::class, 'index'])->name('home');

Route::get('/urls/{category}', action: [HomeController::class, 'urls'])->name('urls');
Route::get('/url-details/{url}', action: [HomeController::class, 'urlDetails'])->name('url.details');
Route::get('/category-reviews/{category}', action: [HomeController::class, 'categoryReviews'])->name('category.reviews');
Route::get('/url-reviews/{url}', action: [HomeController::class, 'urlReviews'])->name('url.reviews');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/add-category', action: [HomeController::class, 'storeCategory'])->name('add.category');
    Route::post('/add-url', action: [HomeController::class, 'storeUrl'])->name('add.url');
    Route::get('/add-category', action: [HomeController::class, 'addCategory'])->name('add.category');
    Route::get(uri: '/add-url', action: [HomeController::class, 'addUrl'])->name('add.url');
    Route::post('/create-review', action: [HomeController::class, 'createReview'])->name('create.review');

    Route::post('/favourites/{type}/{id}', [HomeController::class, 'store'])->name('favourites.store');
    Route::delete('/favourites/{type}/{id}', [HomeController::class, 'destroy'])->name('favourites.destroy');

    Route::get('/favourites', action: [HomeController::class, 'favourites'])->name('favourites');
    Route::get('/url-favourites/{category}', action: [HomeController::class, 'urlFavourites'])->name('url.favourites');

});

require __DIR__.'/auth.php';
