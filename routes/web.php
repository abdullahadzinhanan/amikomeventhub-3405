<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\TransactionController;

// ==========================================
// RUTE AUTH & REDIRECT
// ==========================================
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// ==========================================
// RUTE USER AREA (HALAMAN DEPAN)
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/payment/{order_id}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');

// ==========================================
// RUTE WEBHOOK MIDTRANS (Server-to-Server, no session/CSRF)
// ==========================================
Route::post('/midtrans/callback', [MidtransWebhookController::class, 'handle'])->name('midtrans.callback');

// ==========================================
// RUTE ADMIN AREA
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Auth Admin
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Middleware Auth & Admin
    Route::middleware(['auth', 'admin'])->group(function () {
        
        Route::get('/', function() {
            return redirect()->route('admin.dashboard');
        });
        
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Transaksi
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
        
        // CRUD dengan Resource
        // Ini akan otomatis membuat rute:
        // admin.events.index, .create, .store, .show, .edit, .update, .destroy
        Route::resource('events', EventAdminController::class);
        Route::resource('partners', PartnerController::class);
        Route::resource('categories', CategoryController::class);
        
    });
});