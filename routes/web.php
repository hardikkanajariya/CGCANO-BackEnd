<?php

use App\Http\Controllers\ContactsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\PointOfSaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Scanner;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\SubScribedController;
use App\Http\Controllers\TicketController;
use App\Mail\TicketEmail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('test', function () {
    Mail::to("hcollege0@gmail.com")->send(new TicketEmail("invoices/123.pdf", "Test fullname"));
    return "Email Sent";
}); 

Route::prefix('gallery')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [GalleryController::class, 'list'])->name('gallery');
    Route::get('/add', [GalleryController::class, 'viewAdd'])->name('gallery.add');
    Route::post('/add', [GalleryController::class, 'doAdd'])->name('gallery.doAdd');
    Route::get('/delete/{id}', [GalleryController::class, 'doDelete'])->name('gallery.delete');
});

Route::prefix('events')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [EventController::class, 'list'])->name('event');
    Route::get('/add', [EventController::class, 'viewAdd'])->name('event.add');
    Route::post('/add', [EventController::class, 'doAdd'])->name('event.doAdd');
    Route::get('/edit/{id}', [EventController::class, 'viewEdit'])->name('event.edit');
    Route::post('/edit/{id}', [EventController::class, 'doEdit'])->name('event.doEdit');
    Route::get('/delete/{id}', [EventController::class, 'doDelete'])->name('event.delete');

    // Event Categories
    Route::prefix('categories')->group(function () {
        Route::get('/', [EventController::class, 'listCategories'])->name('event.categories');
        Route::get('/add', [EventController::class, 'viewAddCategory'])->name('event.category.add');
        Route::post('/add', [EventController::class, 'doAddCategory'])->name('event.category.add');
        Route::get('/edit/{id}', [EventController::class, 'viewEditCategory'])->name('event.category.edit');
        Route::post('/edit/{id}', [EventController::class, 'doEditCategory'])->name('event.category.edit');
        Route::get('/delete/{id}', [EventController::class, 'doDeleteCategory'])->name('event.category.delete');
    });
    // Event Venues
    Route::prefix('venues')->group(function () {
        Route::get('/', [EventController::class, 'listVenues'])->name('event.venues');
        Route::get('/add', [EventController::class, 'viewAddVenue'])->name('event.venue.add');
        Route::post('/add', [EventController::class, 'doAddVenue'])->name('event.venue.add');
        Route::get('/edit/{id}', [EventController::class, 'viewEditVenue'])->name('event.venue.edit');
        Route::post('/edit/{id}', [EventController::class, 'doEditVenue'])->name('event.venue.edit');
        Route::get('/delete/{id}', [EventController::class, 'doDeleteVenue'])->name('event.venue.delete');

        // Event Venue Amenities
        Route::prefix('amenities')->group(function () {
            Route::get('/', [EventController::class, 'listAmenities'])->name('event.venue.amenities');
            Route::get('/add', [EventController::class, 'viewAddAmenities'])->name('event.venue.amenities.add');
            Route::post('/add', [EventController::class, 'doAddAmenities'])->name('event.venue.amenities.add');
            Route::get('/edit/{id}', [EventController::class, 'viewEditAmenities'])->name('event.venue.amenities.edit');
            Route::post('/edit/{id}', [EventController::class, 'doEditAmenities'])->name('event.venue.amenities.edit');
            Route::get('/delete/{id}', [EventController::class, 'doDeleteAmenities'])->name('event.venue.amenities.delete');
        });
    });
});

Route::prefix('tickets')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/add/{event}', [TicketController::class, 'viewAdd'])->name('ticket.add');
    Route::post('/add/{event}', [TicketController::class, 'doAdd'])->name('ticket.doAdd');
    Route::get('/edit/{id}', [TicketController::class, 'viewEdit'])->name('ticket.edit');
    Route::get('/mark-as-sold/{id}', [TicketController::class, 'doSoldOut'])->name('ticket.markAsSold');
    Route::post('/edit/{id}', [TicketController::class, 'doEdit'])->name('ticket.doEdit');
    Route::get('/delete/{id}', [TicketController::class, 'doDelete'])->name('ticket.delete');
});

Route::prefix('order')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [InvoiceController::class, 'list'])->name('orders');
    Route::get('/edit/{id}', [InvoiceController::class, 'viewEdit'])->name('order.edit');
    Route::get('/delete/{id}', [InvoiceController::class, 'doDelete'])->name('order.delete');
    Route::get('/{id}/payment', [InvoiceController::class, 'viewPayment'])->name('payment');
});

Route::prefix('scanner')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [Scanner::class, 'list'])->name('scanner');
    Route::get('/add', [Scanner::class, 'viewAdd'])->name('scanner.add');
    Route::post('/add', [Scanner::class, 'doAdd'])->name('scanner.doAdd');
    Route::get('/edit/{id}', [Scanner::class, 'viewEdit'])->name('scanner.edit');
    Route::post('/edit/{id}', [Scanner::class, 'doEdit'])->name('scanner.doEdit');
    Route::get('/delete/{id}', [Scanner::class, 'doDelete'])->name('scanner.delete');
});

Route::prefix('pos')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [PointOfSaleController::class, 'list'])->name('pos');
    Route::get('/add', [PointOfSaleController::class, 'viewAdd'])->name('pos.add');
    Route::post('/add', [PointOfSaleController::class, 'doAdd'])->name('pos.doAdd');
    Route::get('/edit/{id}', [PointOfSaleController::class, 'viewEdit'])->name('pos.edit');
    Route::post('/edit/{id}', [PointOfSaleController::class, 'doEdit'])->name('pos.doEdit');
    Route::get('/delete/{id}', [PointOfSaleController::class, 'doDelete'])->name('pos.delete');
});

Route::prefix('speaker')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [SpeakerController::class, 'list'])->name('speaker');
    Route::get('/add', [SpeakerController::class, 'viewAdd'])->name('speaker.add');
    Route::post('/add', [SpeakerController::class, 'doAdd'])->name('speaker.doAdd');
    Route::get('/edit/{id}', [SpeakerController::class, 'viewEdit'])->name('speaker.edit');
    Route::post('/edit/{id}', [SpeakerController::class, 'doEdit'])->name('speaker.doEdit');
    Route::get('/delete/{id}', [SpeakerController::class, 'doDelete'])->name('speaker.delete');
});

Route::prefix('sponsor')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [SponsorController::class, 'list'])->name('sponsor');
    Route::get('/add', [SponsorController::class, 'viewAdd'])->name('sponsor.add');
    Route::post('/add', [SponsorController::class, 'doAdd'])->name('sponsor.doAdd');
    Route::get('/edit/{id}', [SponsorController::class, 'viewEdit'])->name('sponsor.edit');
    Route::post('/edit/{id}', [SponsorController::class, 'doEdit'])->name('sponsor.doEdit');
    Route::get('/delete/{id}', [SponsorController::class, 'doDelete'])->name('sponsor.delete');
});

Route::prefix('peoples')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [PeopleController::class, 'list'])->name('people');
//    Route::get('/add', [PeopleController::class, 'viewAdd'])->name('people.add');
//    Route::post('/add', [PeopleController::class, 'doAdd'])->name('people.doAdd');
//    Route::get('/edit/{id}', [PeopleController::class, 'viewEdit'])->name('people.edit');
//    Route::post('/edit/{id}', [PeopleController::class, 'doEdit'])->name('people.doEdit');
    Route::get('/delete/{id}', [PeopleController::class, 'doDelete'])->name('people.delete');
});

Route::prefix('contacts')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [ContactsController::class, 'list'])->name('contacts');
    Route::get('/read/{id}', [ContactsController::class, 'markAsRead'])->name('contact.read');
    Route::get('/unread/{id}', [ContactsController::class, 'markAsUnread'])->name('contact.unread');
    Route::get('/delete/{id}', [ContactsController::class, 'doDelete'])->name('contact.delete');
});

Route::prefix('subscribers')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [SubScribedController::class, 'list'])->name('subscribers');
    Route::get('/subscribe/{id}', [SubScribedController::class, 'subscribe'])->name('sub.true');
    Route::get('/unsubscribe/{id}', [SubScribedController::class, 'unSubscribe'])->name('sub.false');
    Route::get('/delete/{id}', [SubScribedController::class, 'doDelete'])->name('sub.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
