<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\PurchaseItemController;
use App\Http\Controllers\SaleItemController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Profile untuk semua user yang login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard bisa diakses semua role
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'role:super_admin,admin,user'])->name('dashboard');

// Master Data: super_admin & admin
Route::middleware(['auth', 'role:super_admin,admin'])->group(function () {
    Route::resource('suppliers', SupplierController::class);
    Route::resource('products',  ProductController::class);
    Route::resource('customers', CustomerController::class);
});

// Transaksi: super_admin & admin
Route::middleware(['auth', 'role:super_admin,admin'])->group(function () {
    Route::resource('purchases', PurchaseController::class);
    Route::resource('sales',     SaleController::class);
});

require __DIR__.'/auth.php';
