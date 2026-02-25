<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'check.banned'])->group(function () {

    Route::resource('colocations', ColocationController::class);
    Route::post('colocations/{colocation}/cancel', [ColocationController::class, 'cancel'])->name('colocations.cancel');

    Route::resource('expenses', ExpenseController::class);

    Route::middleware(['can:admin-access'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::post('/users/{user}/toggle-ban', [AdminController::class, 'toggleBan'])->name('users.toggle-ban');
    });
});

require __DIR__.'/auth.php';