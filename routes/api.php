<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\QontactSimmaController;
use App\Http\Controllers\API\ChatSimmaController;
use App\Http\Controllers\API\ChildrenSimmaController;


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



// list change will get change and save to database
Route::get('sync-contact-from-simma', [QontactSimmaController::class, 'sync_contact_from_simma'])
    ->name('sync_contact_from_simma');

Route::get('post-contact-to-qontak-web', [QontactSimmaController::class, 'post_contact_to_qontak_web'])
    ->name('post_contact_to_qontak_web');

Route::get('sync_chat', [ChatSimmaController::class, 'sync_chat'])
    ->name('sync_chat');

Route::get('sync-children-from-simma', [ChildrenSimmaController::class, 'sync_children_from_simma'])
    ->name('sync_children_from_simma');

Route::get('post-children-to-qontak-web', [ChildrenSimmaController::class, 'post_children_to_qontak_web'])
    ->name('post_children_to_qontak_web');
