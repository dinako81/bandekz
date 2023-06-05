<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController as C;
use App\Http\Controllers\HotelController as H;
use App\Http\Controllers\FrontController as F;
use App\Http\Controllers\CartController as CART;
use App\Http\Controllers\OrderController as O;


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

Route::name('front-')->group(function () {
  Route::get('/', [F::class, 'index'])->name('index');
  // Route::get('/country/{country}', [F::class, 'showCountry'])->name('show-country');
  Route::get('/hotel/{hotel}', [F::class, 'showHotel'])->name('show-hotel');
  Route::get('/my-orders', [F::class, 'orders'])->name('orders')->middleware('role:admin|client');
  Route::get('/download/{order}', [F::class, 'download'])->name('download')->middleware('role:admin|client');
  Route::put('/vote/{hotel}', [F::class, 'vote'])->name('vote')->middleware('role:admin|client');
  Route::get('/tags-list', [F::class, 'getTagsList'])->name('tags-list')->middleware('role:admin|client');
  // Route::put('/add-tag/{hotel}', [F::class, 'addTag'])->name('add-tag')->middleware('role:admin|client');
  // Route::put('/delete-tag/{hotel}', [F::class, 'deleteTag'])->name('delete-tag')->middleware('role:admin|client');
  // Route::post('/add-new-tag/{hotel}', [F::class, 'addNewTag'])->name('add-new-tag')->middleware('role:admin|client');

});

Route::prefix('countries')->name('countries-')->group(function () {
    Route::get('/', [C::class, 'index'])->name('index')->middleware('role:admin');
    Route::get('/create', [C::class, 'create'])->name('create')->middleware('role:admin');
    Route::post('/create', [C::class, 'store'])->name('store')->middleware('role:admin');
    Route::get('/{country}', [C::class, 'show'])->name('show')->middleware('role:admin|client');
    Route::get('/edit/{country}', [C::class, 'edit'])->name('edit')->middleware('role:admin');
    Route::put('/edit/{country}', [C::class, 'update'])->name('update')->middleware('role:admin');
    Route::delete('/delete/{country}', [C::class, 'destroy'])->name('delete')->middleware('role:admin');
   
});

Route::prefix('hotels')->name('hotels-')->group(function () {
  Route::get('/', [H::class, 'index'])->name('index')->middleware('role:admin|client');
  // Route::get('/colors', [H::class, 'colors'])->name('colors')->middleware('role:admin');
  // Route::get('/color-name', [H::class, 'colorName'])->name('color-name')->middleware('role:admin');
  Route::get('/create', [H::class, 'create'])->name('create')->middleware('role:admin');
  Route::post('/create', [H::class, 'store'])->name('store')->middleware('role:admin');
  Route::get('/{hotel}', [H::class, 'show'])->name('show')->middleware('role:admin');
  Route::get('/edit/{hotel}', [H::class, 'edit'])->name('edit')->middleware('role:admin');
  Route::put('/edit/{hotel}', [H::class, 'update'])->name('update')->middleware('role:admin');
  Route::delete('/delete/{hotel}', [H::class, 'destroy'])->name('delete')->middleware('role:admin');
  Route::delete('/delete-photo/{photo}', [H::class, 'destroyPhoto'])->name('delete-photo')->middleware('role:admin');

});

Route::prefix('cart')->name('cart-')->group(function () {
  Route::put('/add', [CART::class, 'add'])->name('add');
  Route::put('/rem', [CART::class, 'rem'])->name('rem');
  Route::put('/update', [CART::class, 'update'])->name('update');
  Route::post('/buy', [CART::class, 'buy'])->name('buy');
  Route::get('/', [CART::class, 'showCart'])->name('show');
  Route::get('/mini-cart', [CART::class, 'miniCart'])->name('mini-cart');
});

Route::prefix('orders')->name('orders-')->group(function () {
  Route::get('/', [O::class, 'index'])->name('index')->middleware('role:admin');
  Route::put('/status/{order}', [O::class, 'update'])->name('update')->middleware('role:admin');
  // Route::get('/create', [C::class, 'create'])->name('create')->middleware('role:admin');
  // Route::post('/create', [C::class, 'store'])->name('store')->middleware('role:admin');
  // Route::get('/edit/{cat}', [C::class, 'edit'])->name('edit')->middleware('role:admin');
  // Route::put('/edit/{cat}', [C::class, 'update'])->name('update')->middleware('role:admin');
  // Route::delete('/delete/{cat}', [C::class, 'destroy'])->name('delete')->middleware('role:admin');
});


Route::prefix('cart')->name('cart-')->group(function () {
  Route::put('/add', [CART::class, 'add'])->name('add');
  Route::put('/rem', [CART::class, 'rem'])->name('rem');
  Route::put('/update', [CART::class, 'update'])->name('update');
  Route::post('/buy', [CART::class, 'buy'])->name('buy');
  Route::get('/', [CART::class, 'showCart'])->name('show');
  Route::get('/mini-cart', [CART::class, 'miniCart'])->name('mini-cart');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');