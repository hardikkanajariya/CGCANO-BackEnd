<?php

use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\GalleryApiController;
use App\Http\Controllers\Api\CommonApiController;
use App\Http\Controllers\Api\InvoiceApiController;
use App\Http\Controllers\Api\PosController;
use App\Http\Controllers\Api\SpeakerApiController;
use App\Http\Controllers\Api\TicketApiController;
use App\Http\Controllers\Api\UserAuthentication;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\Scanner;
use App\Http\Controllers\SubScribedController;
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

// Route for getting all events and event details by id [Now it's getting from slug]
Route::prefix('events')->group(function () {
    Route::get('{id}', [EventApiController::class, 'getEventDetail']);
});

// Get Offer Details by id
Route::prefix('offer')->group(function () {
    Route::get('{id}', [CommonApiController::class, 'getOfferDetails']);
});

// Get All Data
Route::prefix('all')->group(function () {
    Route::get('speakers', [CommonApiController::class, 'getAllSpeakers']);
    Route::get('galleries', [CommonApiController::class, 'getAllGalleries']);
    Route::get('categories', [CommonApiController::class, 'getAllCategories']);
    Route::get('sponsors', [CommonApiController::class, 'getAllSponsors']);
    Route::get('events', [CommonApiController::class, 'getAllEvents']);
    Route::get('offers', [CommonApiController::class, 'getAllOffers']);
    Route::get('packages', [CommonApiController::class, 'getAllPackages']);
});

// Handle Tickets
Route::prefix('tickets')->group(function () {
    Route::get('{slug}', [TicketApiController::class, 'getTicketDetails']);
    Route::get('user/{id}', [TicketApiController::class, 'getUserTickets']);
});

// Handle Combo Tickets
Route::prefix('combo')->group(function () {
    Route::get('{id}', [TicketApiController::class, 'getComboDetails']);
    Route::get('user/{id}', [TicketApiController::class, 'getUserCombos']);
});

// Handle Orders
Route::prefix('orders')->group(function () {
    Route::post('ticket', [InvoiceApiController::class, 'createTicketOrder']);
    Route::post('combo', [InvoiceApiController::class, 'createComboOrder']);
    Route::post('package', [InvoiceApiController::class, 'createPackageOrder']);
    Route::post('donation', [InvoiceApiController::class, 'createDonationOrder']);
    Route::post('status', [InvoiceApiController::class, 'updateOrderStatus']);
});

// Handle Payment
Route::prefix('payment')->group(function () {
    Route::post('ticket', [InvoiceApiController::class, 'paymentDetailsTicket']);
    Route::post('combo', [InvoiceApiController::class, 'paymentDetailsCombo']);
    Route::post('package', [InvoiceApiController::class, 'paymentDetailsPackage']);
    Route::post('donation', [InvoiceApiController::class, 'paymentDetailsDonation']);
});

// Handle Contact and Subscribe form submission
Route::post('contact', [ContactsController::class, 'sendContact']);
Route::post('subscribe', [SubScribedController::class, 'addSubscribed']);

// Authentication
Route::prefix('auth')->group(function () {
    Route::post('login', [UserAuthentication::class, 'login']);
    Route::post('register', [UserAuthentication::class, 'register']);
});

// Routes for handling Scanner Application
Route::prefix('scanner')->group(function () {
    Route::post('login', [Scanner::class, 'login']);
    Route::post('scan', [Scanner::class, 'scanTicket']);
});

// Routes for handling POS Application
Route::prefix('pos')->group(function () {
    Route::post('login', [PosController::class, 'login']);
    Route::post('scan', [PosController::class, 'scanTicket']);
    Route::post('create', [PosController::class, 'createOrder']);
    Route::post('status', [PosController::class, 'updateOrderStatus']);
    Route::post('payment', [PosController::class, 'paymentDetails']);
});
