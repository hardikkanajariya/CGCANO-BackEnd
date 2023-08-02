<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\PointOfSaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Scanner;
use Illuminate\Support\Facades\Route;

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
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
        Route::post('/add', [EventController::class, 'doAddCategory'])->name('event.categories.doAdd');
        Route::post('/edit/{id}', [EventController::class, 'doEditCategory'])->name('event.categories.doEdit');
        Route::get('/delete/{id}', [EventController::class, 'doDeleteCategory'])->name('event.categories.delete');
    });

    // Event Types
    Route::prefix('types')->group(function () {
        Route::get('/', [EventController::class, 'listTypes'])->name('event.types');
        Route::post('/add', [EventController::class, 'doAddType'])->name('event.types.doAdd');
        Route::post('/edit/{id}', [EventController::class, 'doEditType'])->name('event.types.doEdit');
        Route::get('/delete/{id}', [EventController::class, 'doDeleteType'])->name('event.types.delete');
    });
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




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
