<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GalleryApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\SpeakerApiController;
use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\TicketApiController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\SubScribedController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Open routes
Route::prefix('events')->group(function () {
    Route::get('all', [EventApiController::class, 'getAll']);
    Route::get('{id}', [EventApiController::class, 'getEventDetail']);
});

Route::get('ticket/{slug}', [TicketApiController::class, 'getTicketDetails']);
Route::post('place-order', [OrderApiController::class, 'createOrder']);
Route::post('payment', [OrderApiController::class, 'paymentDetails']);

Route::prefix('speaker')->group(function () {
    Route::get('all', [SpeakerApiController::class, 'getAllSpeakers']);
});

Route::prefix('gallery')->group(function () {
    Route::get('all', [GalleryApiController::class, 'getAllImages']);
});

Route::post('contact', [ContactsController::class, 'sendContact']);
Route::post('subscribe', [SubScribedController::class, 'addSubscribed']);

// Protected routes
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});
