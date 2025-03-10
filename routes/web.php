<?php

use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\get;

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::post('/register-interest', [FrontendController::class, 'storeInterest'])->name('interest.store');
Route::get('/training', [FrontendController::class, 'showTraining'])->name('training.show');

// RAZORPAY
Route::post('/create-razorpay-order', [RazorpayController::class, 'createOrder'])->middleware('cors');
Route::post('/verify-payment', [RazorpayController::class, 'verifyPayment'])->middleware('cors');



Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

Route::prefix('dahboard')->group(function () {
    Route::get('/update-price', [AdminController::class, 'updatePrice'])->name('setprice');
    Route::get('/enquiry-list', [AdminController::class, 'InitialFormInteres'])->name('enquiry.list');
    Route::get('/enquiry-delete/{id}', [AdminController::class, 'deleteEnquiry'])->name('enquiry.delete');

    Route::get('/set/price', [SettingController::class, 'setPrice'])->name('setprice');
    Route::post('/update/price', [SettingController::class, 'updatePrice'])->name('updateprice');

    // VIDEO UPLOAD
    Route::get('/video', [VideoController::class, 'index'])->name('video.index');
    Route::post('/video/upload', [VideoController::class, 'uploadVideo'])->name('video.upload');

    // PAGE CONTENT
    Route::get('/admin/page-content/edit', [PageContentController::class, 'edit'])->name('admin.page-content.edit');
    Route::put('/admin/page-content/update', [PageContentController::class, 'update'])->name('admin.page-content.update');

    // TRAINING PAGE CONTENT
    Route::get('/admin/training-page/edit', [PageContentController::class, 'trainingPageEdit'])->name('admin.page-training-edit');
    Route::put('/admin/training-page/update', [PageContentController::class, 'trainingPageUpdate'])->name('admin.page-training-update');


    // SETTING(LOGO)
    Route::get('/admin/logo', [SettingController::class, 'showLogoForm'])->name('logo.form');
    Route::post('/admin/logo/update', [SettingController::class, 'updateLogo'])->name('update.logo');

})->middleware('auth');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
