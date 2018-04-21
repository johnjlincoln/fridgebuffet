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

// Register authentication routes (login/logout/register/etc)
Auth::routes();
// Temp logout override due to POST requirement as default
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

// Home Routes
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

// Core Routes

// Admin Routes
Route::get('/admin', 'AdminController@home')->middleware('admin')->name('admin');
