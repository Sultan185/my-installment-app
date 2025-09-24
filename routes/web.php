<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
	return view('auth.login');
})->name('login.form');

Route::middleware('auth')->group(function () {
	Route::get('/password/change', function () {
		return view('auth.change-password');
	})->name('password.change.form');

	Route::get('/home', function () {
		return view('home');
	})->name('home');

	// Search customer by phone or national id
	Route::post('/customers/search', [CustomerController::class, 'search'])->name('customers.search');

    // Customers CRUD
    Route::resource('customers', CustomerController::class);

    // Contracts
    Route::get('/contracts/create', [ContractController::class, 'create'])->name('contracts.create');
    Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');

    // Payments
    Route::post('/contracts/{contract}/payments', [PaymentController::class, 'store'])->name('payments.store');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
	Route::post('/password/change', [AuthController::class, 'changePassword'])->name('password.change');
});

// Route::get('/', function () {
// 	return view('landing');
// });
