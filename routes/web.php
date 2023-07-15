<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Routes
Route::get('/dashboard', fn() => view('dashboard', ['title' => 'Dashboard']))->middleware(['auth', 'checkAuthorization'])->name('dashboard');

/*===================================== Category ================================*/
Route::resource('category', App\Http\Controllers\TermController::class)->middleware(['auth', 'checkAuthorization']);
Route::any('category/get-terms', 'App\Http\Controllers\TermController@getTerms')->middleware(['auth', 'checkAuthorization'])->name('get.category-terms');

/*===================================== Ingredients ================================*/
Route::resource('ingredients', App\Http\Controllers\TermController::class)->middleware(['auth', 'checkAuthorization']);
Route::any('ingredients/get-terms', 'App\Http\Controllers\TermController@getTerms')->middleware(['auth', 'checkAuthorization'])->name('get.ingredients-terms');

/*===================================== Brands ================================*/
Route::resource('brands', App\Http\Controllers\TermController::class)->middleware(['auth', 'checkAuthorization']);
Route::any('brands/get-terms', 'App\Http\Controllers\TermController@getTerms')->middleware(['auth', 'checkAuthorization'])->name('get.brands-terms');

/*====================================== Users ==================================*/
Route::resource('users', App\Http\Controllers\UserController::class)->middleware(['auth','checkAuthorization']);
Route::any('get-users', 'App\Http\Controllers\UserController@getUsers')->middleware(['auth', 'checkAuthorization'])->name('users.getUsers');

/*====================================== Bars ==================================*/
Route::resource('bars', App\Http\Controllers\BarController::class)->middleware(['auth','checkAuthorization']);
Route::any('get-bars', 'App\Http\Controllers\BarController@getBars')->middleware(['auth', 'checkAuthorization'])->name('bars.getBars');

/*====================================== items ==================================*/
Route::resource('items', App\Http\Controllers\ItemController::class)->middleware(['auth','checkAuthorization']);
Route::any('get-items', 'App\Http\Controllers\ItemController@getItems')->middleware(['auth', 'checkAuthorization'])->name('items.getItems');