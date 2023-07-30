<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\QontactSimmaController;
use App\Http\Controllers\API\ChatSimmaController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('contacts', contactAPIController::class);

// list change will get change and save to database
Route::get('list-change-simma', [QontactSimmaController::class, 'list_change_simma'])
    ->name('list_change_simma');

//  Route::get('detail-simma', [QontactSimmaController::class, 'list_change_simma_detail'])
//     ->name('list_change_simma_detail');

Route::get('post-contact-to-qontact', [QontactSimmaController::class, 'post_contact_to_qontact'])
    ->name('post_contact_to_qontact');

Route::get('sync_chat', [ChatSimmaController::class, 'sync_chat'])
    ->name('sync_chat');
