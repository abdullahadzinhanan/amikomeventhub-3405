<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TransactionController;        // ← Pertemuan 10
use App\Http\Controllers\CheckoutController;                 // ← Pertemuan 10
use App\Http\Controllers\EventController as PublicEventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

// ============================================================
// PUBLIC ROUTES
// ============================================================

Route::get('/', [HomeController::class, 'index']);

Route::get('/kontak', function () {
    return view('contact');
});

Route::get('/profil', function () {
    return view('profil');
});

Route::get('/katalog', function () {
    return view('katalog');
});

Route::get('/bantuan', function () {
    return view('bantuan');
});

Route::get('/event-detail/{id?}', [PublicEventController::class, 'show'])->name('events.show');
Route::get('/ticket', [TicketController::class, 'show']);

// ============================================================
// CHECKOUT ROUTES (Guest — tanpa login)
// ============================================================
Route::get('/checkout/{event}',  [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');

// ============================================================
// Redirect /login bawaan Laravel → ke halaman login admin
// (Diperlukan agar middleware 'auth' tahu kemana redirect)
// ============================================================
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// ============================================================
// ADMIN ROUTES — prefix: /admin, name prefix: admin.
// ============================================================
Route::prefix('admin')->name('admin.')->group(function () {

    // --- Rute Login/Logout (bebas akses, tanpa middleware) ---
    Route::get('login',   [AuthController::class, 'showLogin'])->name('login');
    Route::post('login',  [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // --- Rute yang wajib Login + Role Admin ---
    Route::middleware(['auth', 'admin'])->group(function () {

        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Events
        Route::resource('events', EventController::class);

        // Transactions (Pertemuan 10 — Admin melihat daftar transaksi)
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');

        // Categories
        Route::get('categories',                 [CategoryController::class, 'index'])->name('categories');
        Route::get('categories/create',          [CategoryController::class, 'create'])->name('categories.create');
        Route::post('categories',                [CategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{category}',      [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}',   [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Partners
        Route::get('partners',               [PartnerController::class, 'index'])->name('partners');
        Route::get('partners/create',        [PartnerController::class, 'create'])->name('partners.create');
        Route::post('partners',              [PartnerController::class, 'store'])->name('partners.store');
        Route::get('partners/{partner}/edit',[PartnerController::class, 'edit'])->name('partners.edit');
        Route::put('partners/{partner}',     [PartnerController::class, 'update'])->name('partners.update');
        Route::delete('partners/{partner}',  [PartnerController::class, 'destroy'])->name('partners.destroy');
    });
});