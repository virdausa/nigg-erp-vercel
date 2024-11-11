<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;

Route::resource('products', ProductController::class);

Route::resource('purchases', PurchaseController::class);
Route::get('purchases/{purchase}/transfer', [PurchaseController::class, 'transferToWarehouse'])->name('purchases.transfer');
Route::post('purchases/{purchase}/transfer', [PurchaseController::class, 'storeTransfer'])->name('purchases.transfer.store');

Route::resource('sales', SalesController::class);
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/inventory/history', [InventoryController::class, 'history'])->name('inventory.history');


use App\Http\Controllers\InboundRequestController;
use App\Http\Controllers\OutboundRequestController;

Route::resource('warehouses', WarehouseController::class);
// Inbound Requests
Route::resource('inbound-requests', InboundRequestController::class);
Route::post('inbound-requests/{id}/approve', [InboundRequestController::class, 'approve'])->name('inbound-requests.approve');
Route::post('inbound-requests/{id}/receive', [InboundRequestController::class, 'receive'])->name('inbound-requests.receive');

// Outbound Requests
Route::resource('outbound-requests', OutboundRequestController::class);
Route::post('outbound-requests/{id}/approve', [OutboundRequestController::class, 'approve'])->name('outbound-requests.approve');
Route::post('outbound-requests/{id}/execute', [OutboundRequestController::class, 'execute'])->name('outbound-requests.execute');


Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/', function () {
    return view('dashboard');
});
