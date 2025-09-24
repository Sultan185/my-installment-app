<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;

Route::get('/login', function () {
	return view('auth.login');
})->name('login.form');

Route::middleware('auth')->group(function () {
	Route::get('/password/change', function () {
		return view('auth.change-password');
	})->name('password.change.form');

	Route::get('/home', function () {
		return view('home');
	})->name('home');

	// Customers CRUD
	Route::resource('customers', CustomerController::class)->except(['show']);

	// Placeholder for contracts create (to be implemented later)
	Route::get('/contracts/create', function () {
		return 'Create Contract form placeholder';
	})->name('contracts.create');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
	Route::post('/password/change', [AuthController::class, 'changePassword'])->name('password.change');
});

Route::get('/', function () {
	return view('landing');
});
