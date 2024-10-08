<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\CustomResetPasswordController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\HomeController;


Route::get('/', function () {
    return view('layouts.app');
});
Route::get('/about', function () {
    return view('auth.about');
})->name('about');

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('auth/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('auth/register', [RegisterController::class, 'register']);

Route::get('login', function () {
    return view('auth.login');
})->name('login');

Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::post('logout', [LogoutController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('resetpassword', function () {
    return view('auth.resetpassword');
})->name('resetpassword');
Route::post('resetpassword', [CustomResetPasswordController::class, 'reset'])->name('resetpassword.update');

Route::group(['middleware' => ['auth', 'session.expired']], function () {
    Route::get('profile', function () {
        return view('profile.profile');
    })->name('profile');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.reset');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/order/orderplace', [OrderController::class, 'submitOrder'])->name('order.submit');
    Route::get('/order/orderplace', [OrderController::class, 'orderView'])->name('order.place');
    Route::get('/orderPdf/pdf/{id}', [OrderController::class, 'generatePdf'])->name('order.pdf');
    Route::get('/order/cancel/{orderId}', [OrderController::class, 'cancelOrder'])->name('order.cancel');
    Route::post('/order/return', [OrderController::class, 'returnOrder'])->name('order.return');
    Route::get('/orderStatus', [OrderController::class, 'orderStatus'])->name('order.orderStatus');


// routes/web.php
Route::get('/order/success', [OrderController::class, 'orderSuccess'])->name('order.success');

});

Route::get('add-product', function () {
    return view('admin.addproduct');
})->name('add-product');
Route::post('add-product', [ProductController::class, 'store'])->name('add-product-store');

Route::get('/admin-home', [HomeController::class, 'index'])->name('admin-home');

Route::get('/products', [ProductController::class, 'allProduct'])->name('products.index');
Route::post('/products/{id}/discount', [ProductController::class, 'applyDiscount'])->name('product.discount');
Route::get('/manageOrder', [ProductController::class, 'showPendingProducts'])->name('products.pending');
Route::patch('manageOrder/{id}/update-status', [ProductController::class, 'updateProductStatus'])->name('product.updateStatus');

Route::get('/running', [ProductController::class, 'showRunningProducts'])->name('products.running');
Route::patch('running/{id}/update-status', [ProductController::class, 'updateProductRunningStatus'])->name('product.updateRunningStatus');

Route::get('/complete', [ProductController::class, 'showCompleteProducts'])->name('products.complete');
Route::get('/declined', [ProductController::class, 'showDeclinedProducts'])->name('products.declined');
Route::get('/returned', [ProductController::class, 'showReturnedProducts'])->name('products.returned');
Route::get('/adminLogin', function () {
    return view('admin.adminLogin');
})->name('admin');
Route::post('/adminLogin', [LoginController::class, 'adminLogin'])->name('adminLogin');
Route::get('/resetPasswordAdmin', function () {
    return view('admin.resetPasswordAdmin');
})->name('resetPasswordAdmin');