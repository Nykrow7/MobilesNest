<?php

use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Change Password Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('password.change-form');
    Route::post('/setup-security-question', [ChangePasswordController::class, 'setupSecurityQuestion'])->name('password.setup-security-question');
    Route::post('/validate-security-question', [ChangePasswordController::class, 'validateSecurityQuestion'])->name('password.validate-security-question');
    Route::post('/generate-otp', [ChangePasswordController::class, 'generateOTP'])->name('password.generate-otp');
    Route::post('/verify-otp', [ChangePasswordController::class, 'verifyOTP'])->name('password.verify-otp');
});

// Forgot Password with Security Question Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/forgot-password-security', [\App\Http\Controllers\Auth\ForgotPasswordWithSecurityController::class, 'showForgotPasswordForm'])->name('password.security.request');
    Route::post('/forgot-password-security/find-user', [\App\Http\Controllers\Auth\ForgotPasswordWithSecurityController::class, 'findUser'])->name('password.security.find-user');
    Route::post('/forgot-password-security/validate-answer', [\App\Http\Controllers\Auth\ForgotPasswordWithSecurityController::class, 'validateSecurityAnswer'])->name('password.security.validate-answer');
    Route::post('/forgot-password-security/reset', [\App\Http\Controllers\Auth\ForgotPasswordWithSecurityController::class, 'resetPassword'])->name('password.security.reset');
});

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Cart routes
Route::middleware(['web'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'removeFromCart'])->name('cart.remove');
});

// Checkout routes
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/payment/{order}', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    
    // Transaction routes
    Route::post('/transactions/process/{order}', [TransactionController::class, 'processPayment'])->name('transactions.process');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('orders', AdminOrderController::class);
    Route::resource('users', AdminUserController::class);
    Route::resource('transactions', TransactionController::class)->only(['index', 'show']);
});

require __DIR__.'/auth.php';