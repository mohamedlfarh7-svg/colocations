<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController; // N'oublie pas l'import ici

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/invitations/{invitation}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
Route::get('/invitations/{invitation}/reject', [InvitationController::class, 'reject'])->name('invitations.reject');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('colocations', ColocationController::class);

    Route::prefix('colocations/{colocation}')->group(function () {
        
        Route::post('/images', [ColocationController::class, 'uploadImage'])->name('colocations.images.store');

        Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
        Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
        Route::get('/expenses/{expense}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
        Route::put('/expenses/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
        Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

        Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');

        // AJOUT ICI : La route pour enregistrer un remboursement
        Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    });
});

require __DIR__.'/auth.php';