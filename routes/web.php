<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\UserController;
use App\Livewire\Dashboard;

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
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/pos', SaleController::class .'@index')->name('pos');
    Route::put('/pos', SaleController::class .'@store')->name('pos.store');

    Route::get('/sales', SaleController::class .'@index')->name('sales.index');
    Route::get('/items', ItemController::class .'@index')->name('items.index');
});


Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/personnels', PersonnelController::class .'@index')->name('personnels.index');
    Route::put('/personnels', PersonnelController::class .'@store')->name('personnels.store');
    Route::put('/personnels/{id}', PersonnelController::class .'@update')->name('personnels.update');
    Route::delete('/personnels/{id}', PersonnelController::class .'@destroy')->name('personnels.destroy');

    Route::put('/items', ItemController::class .'@store')->name('items.store');
    Route::put('/items/{id}', ItemController::class .'@update')->name('items.update');
    Route::delete('/items/{id}', ItemController::class .'@destroy')->name('items.destroy');

    Route::get('/suppliers', SupplierController::class .'@index')->name('suppliers.index');
    Route::put('/suppliers', SupplierController::class .'@store')->name('suppliers.store');
    Route::put('/suppliers/{id}', SupplierController::class .'@update')->name('suppliers.update');
    Route::delete('/suppliers/{id}', SupplierController::class .'@destroy')->name('suppliers.destroy');

    Route::get('/purchase_orders', PurchaseOrderController::class .'@index')->name('purchase_orders.index');
    Route::put('/purchase_orders', PurchaseOrderController::class .'@store')->name('purchase_orders.store');
    Route::put('/purchase_orders/{id}', PurchaseOrderController::class .'@update')->name('purchase_orders.update');
    Route::delete('/purchase_orders/{id}', PurchaseOrderController::class .'@destroy')->name('purchase_orders.destroy');

    Route::get('/logs', LogController::class .'@index')->name('logs.index');

    Route::get('/accounts', UserController::class .'@index')->name('accounts.index');
    Route::put('/accounts', UserController::class .'@store')->name('accounts.store');
    Route::put('/accounts/{id}', UserController::class .'@update')->name('accounts.update');
    Route::delete('/accounts/{id}', UserController::class .'@destroy')->name('accounts.destroy');
});





