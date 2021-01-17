<?php

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
    if (Auth::user()) return redirect('/home');
    return view('index');
});

Route::get('/transactions', [\App\Http\Controllers\HomeController::class, 'transactions']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/history', [App\Http\Controllers\HomeController::class, 'transactions'])->name('home');

// #TODO move to api route after make token system
Route::post('api/transaction/create', [\App\Http\Controllers\API\Transaction\CreateController::class, 'execute']);
Route::get('api/transaction/user/list', [\App\Http\Controllers\API\Transaction\ListController::class, 'execute']);

Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index']);
Route::get('/admin/transactions', [\App\Http\Controllers\AdminController::class, 'transactions']);
Route::get('/admin/users/{user_id}', [\App\Http\Controllers\AdminController::class, 'user']);

// Simple Logout
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');