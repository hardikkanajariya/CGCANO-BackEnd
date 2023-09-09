<?php

use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\GalleryApiController;
use App\Http\Controllers\Api\CommonApiController;
use App\Http\Controllers\Api\InvoiceApiController;
use App\Http\Controllers\Api\PackageApiController;
use App\Http\Controllers\Api\PosController;
use App\Http\Controllers\Api\SpeakerApiController;
use App\Http\Controllers\Api\TicketApiController;
use App\Http\Controllers\Api\UserAuthentication;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\Scanner;
use App\Http\Controllers\SubScribedController;
use App\Http\Controllers\VolunteersResume;
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
    Route::get('category/{name}', [EventApiController::class, 'getEventByCategory']);
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

// Handle Event Tickets
Route::prefix('tickets')->group(function () {
    Route::get('{slug}', [TicketApiController::class, 'getTicketDetails']);
    Route::get('user/{id}', [TicketApiController::class, 'getUserTickets']);
});

// Handle Combo Tickets
Route::prefix('combo')->group(function () {
    Route::get('{id}', [TicketApiController::class, 'getComboDetails']);
    Route::get('user/{id}', [TicketApiController::class, 'getUserCombos']);
});

// Handle Packages
Route::prefix('package')->group(function () {
    Route::get('{name}', [PackageApiController::class, 'getPackageDetails']);
    Route::get('user/{id}', [PackageApiController::class, 'getUserPackages']);
    Route::get('user/{id}/active', [PackageApiController::class, 'getUserActivePackages']);
});

// Handle Donations
Route::prefix('donation')->group(function () {
    Route::get('{id}', [PackageApiController::class, 'getDonationDetails']);
    Route::get('user/{id}', [PackageApiController::class, 'getUserDonations']);
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
    Route::post('update', [UserAuthentication::class, 'update']);
});

// Routes for handling Scanner Application
Route::prefix('scanner')->group(function () {
    Route::post('login', [Scanner::class, 'login']);
    Route::post('scan', [Scanner::class, 'scanTicket']);
    Route::prefix('food')->group(function () {
        Route::post('login', [Scanner::class, 'login']);
        Route::post('scan', [Scanner::class, 'scanFood']);
    });
});

// Routes for handling POS Application
Route::prefix('pos')->group(function () {
    Route::post('login', [PosController::class, 'login']);
    Route::get('tickets', [PosController::class, 'getTickets']);
    Route::post('sell', [PosController::class, 'sellTicket']);
    Route::get('sold', [PosController::class, 'getSoldTickets']);
});

// Routes for Handling Volunteers Resume Application
Route::prefix('resume')->group(function () {
    Route::post('create', [VolunteersResume::class, 'createApplication']);
});
