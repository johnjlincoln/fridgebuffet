<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
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

// Home Routes
Route::get('/', 'HomeController@index')->name('home');
Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
});
//TODO: sort out the landing page for auth vs not-auth
//TODO: then develop auth

// Core Routes

// Admin Routes
Route::middleware(['admin', 'auth'])->prefix('admin')->group(function () {
    Route::get('/', 'AdminController@home');
});
