<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Register authentication routes explicitly
Route::namespace('Auth')->group(function () {
    // Authentication Routes
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');

    // Registration Routes
    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register');

    // Password Reset Routes
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');
});

// Register Core Routes
Route::get('/', 'RecipeController@index')->name('index');

// Register Home Routes -- all prefixed with /home
Route::middleware(['home', 'auth'])->prefix('home')->group(function () {
    Route::get('/', 'HomeController@index');
    //my account and the like -- saved recipes
});

// Register Admin Routes -- all prefixed with /admin
Route::middleware(['admin', 'auth'])->prefix('admin')->group(function () {
    Route::get('/', 'AdminController@home');
});
