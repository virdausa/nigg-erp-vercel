<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;

Route::resource('products', ProductController::class);
Route::resource('purchases', PurchaseController::class);
Route::resource('warehouses', WarehouseController::class);
Route::resource('sales', SaleController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/', function () {
    return view('dashboard');
});
