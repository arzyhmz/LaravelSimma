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
    return view('welcome');
});
Auth::routes(
    ['register' => false]
);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('contacts', App\Http\Controllers\contactController::class);


Route::resource('logs', App\Http\Controllers\logsController::class);

Route::resource('wabHistories', App\Http\Controllers\wab_historyController::class);

Route::resource('chatLogs', App\Http\Controllers\chat_logsController::class);

Route::resource('childrens', App\Http\Controllers\childrenController::class);

Route::resource('childrenLogs', App\Http\Controllers\children_logsController::class);

Route::resource('configs', App\Http\Controllers\configController::class);