<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CustomerComplaintController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

route::resource("customers", CustomerController::class);

route::resource("products", ProductController::class);

Route::resource('sales', SalesController::class);
Route::get('sales/{sale}/status/{status}', [SalesController::class, 'updateStatus'])->name('sales.updateStatus');
Route::put('sales/{sale}', [SalesController::class, 'update'])->name('sales.update');
Route::resource('customer_complaints', CustomerComplaintController::class);
Route::put('customer_complaints/{customer_complaint}/resolve', [CustomerComplaintController::class, 'resolve'])->name('customer_complaints.resolve');

require __DIR__ . '/auth.php';
