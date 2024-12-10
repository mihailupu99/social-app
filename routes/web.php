<?php

use App\Models\User;

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\LikeController;



Route::middleware(['web'])->group(function () {
    // Inertia routes
    Route::inertia('/', 'Home')->name('home');
    Route::inertia('/about', 'About')->name('about');
    Route::inertia('/feed', 'SocialFeed')->name('feed');
    Route::inertia('/login', 'Auth/Login')->name('login');

    // Authentication routes
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected routes 
    Route::middleware(['auth'])->group(function () {
        Route::get('/feed', [TweetController::class, 'index'])->name('feed');
        Route::post('/tweets', [TweetController::class, 'store'])->name('postTweet'); // Add the post tweet route
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});


Route::get('/social-feed', [TweetController::class, 'index']);

Route::get('/tweets', [TweetController::class, 'index'])->name('tweets.index');



Route::post('/api/tweets/{tweet}/like', [TweetController::class, 'like'])->name('tweets.like');

Route::get('/tweets/{id}', [TweetController::class, 'show'])->name('tweets.show');


Route::post('/api/tweets/{tweet}/comments', [TweetController::class, 'storeComment'])->name('tweets.comments.store');


use App\Http\Controllers\SettingsController;

Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
