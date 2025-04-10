<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\{HomeController, ProfileController, CartController, CheckoutController, TransactionController, DashboardController, ShopController, OrderController};
use App\Http\Controllers\Admin\{AdminProductController, AdminOrderController, InventoryController, PhoneController, AdminTransactionController};
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChangePasswordController;
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

Route::get('/', [HomeController::class, 'index'])->name('welcome');


Route::middleware(['auth'])->group(function () {
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Password management
    Route::prefix('/change-password')->name('password.')->group(function () {
        Route::get('/', [ChangePasswordController::class, 'showChangePasswordForm'])->name('change-form');
        Route::post('/security-question', [ChangePasswordController::class, 'setupSecurityQuestion'])->name('setup-security-question');
        Route::post('/validate', [ChangePasswordController::class, 'validateSecurityQuestion'])->name('validate-security-question');
        Route::post('/otp', [ChangePasswordController::class, 'generateOTP'])->name('generate-otp');
        Route::post('/verify', [ChangePasswordController::class, 'verifyOTP'])->name('verify-otp');
    });

    // Checkout & transactions
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/payment/{order}', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Transaction routes
    Route::post('/transactions/process/{order}', [TransactionController::class, 'processPayment'])->name('transactions.process');
});

// Forgot Password with Security Question Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/forgot-password-security', [\App\Http\Controllers\Auth\ForgotPasswordWithSecurityController::class, 'showForgotPasswordForm'])->name('password.security.request');
    Route::post('/forgot-password-security/find-user', [\App\Http\Controllers\Auth\ForgotPasswordWithSecurityController::class, 'findUser'])->name('password.security.find-user');
    Route::post('/forgot-password-security/validate-answer', [\App\Http\Controllers\Auth\ForgotPasswordWithSecurityController::class, 'validateSecurityAnswer'])->name('password.security.validate-answer');
    Route::post('/forgot-password-security/reset', [\App\Http\Controllers\Auth\ForgotPasswordWithSecurityController::class, 'resetPassword'])->name('password.security.reset');
});

// Product routes
Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

// Shop routes for phones
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');

// Cart routes
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product?}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// Checkout routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

// Require auth for completing checkout process
Route::middleware(['auth'])->group(function () {
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/payment/{order}', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Transaction routes
    Route::post('/transactions/process/{order}', [TransactionController::class, 'processPayment'])->name('transactions.process');

    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{order}/mark-delivered', [OrderController::class, 'markDelivered'])->name('orders.mark-delivered');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Resource routes
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', AdminOrderController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('phones', PhoneController::class);
    Route::resource('transactions', AdminTransactionController::class);

    // Inventory management
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [InventoryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [InventoryController::class, 'update'])->name('update');
        Route::post('/{id}/adjust', [InventoryController::class, 'adjustQuantity'])->name('adjust');
        Route::get('/low-stock', [InventoryController::class, 'lowStock'])->name('low-stock');
        Route::get('/export', [InventoryController::class, 'export'])->name('export');
    });
}); // End of admin routes group

require __DIR__.'/auth.php';