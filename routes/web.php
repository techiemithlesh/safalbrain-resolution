<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::post('/register-interest', [FrontendController::class, 'storeInterest'])->name('interest.store');
Route::get('/training', [FrontendController::class, 'showTraining'])->name('training.show');

// RAZORPAY

Route::post('/create-razorpay-order', [RazorpayController::class, 'createOrder'])->middleware('cors');
Route::post('/verify-payment', [RazorpayController::class, 'verifyPayment'])->middleware('cors');



Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

Route::prefix('dahboard')->group(function () {
    Route::get('/update-price', [AdminController::class, 'updatePrice'])->name('setprice');

    Route::get('/set/price', [SettingController::class, 'setPrice'])->name('setprice');
    Route::post('/update/price', [SettingController::class, 'updatePrice'])->name('updateprice');
})->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
