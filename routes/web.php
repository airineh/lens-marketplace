<?php

use Illuminate\Support\Facades\Route;
use App\Models\Equipment;
use Illuminate\Http\Request;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\LensProfileController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\AdminVerificationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlatformSettingController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| HOME & PUBLIC PAGES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

// Katalog Utama (Sudah Digabung & Diperbaiki)
Route::get('/catalog', function (Request $request) {
    $query = Equipment::with(['user', 'category'])
        ->where('stock_status', 'available');

    // Filter Kategori (Support Slug & Name)
    if ($request->filled('category')) {
        $query->whereHas('category', function ($q) use ($request) {
            $q->where('slug', $request->category)
              ->orWhere('name', $request->category);
        });
    }

    // Pencarian Kata Kunci
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }

    $equipments = $query->latest()->get();

    return view('catalog', compact('equipments'));
})->name('catalog');

Route::get('/catalog/{equipment}', [EquipmentController::class, 'showPublic'])
    ->name('catalog.show');

Route::get('/kategori', function () {
    return redirect()->route('catalog');
})->name('kategori');

Route::get('/about', function () {
    return view('about');
})->name('about');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD & INVENTORY
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('equipments', EquipmentController::class);

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/my-profile', [LensProfileController::class, 'index'])->name('my.profile');
    Route::post('/my-profile/update', [LensProfileController::class, 'update'])->name('my.profile.update');

    /*
    |--------------------------------------------------------------------------
    | USER & ADMIN VERIFICATION
    |--------------------------------------------------------------------------
    */
    Route::get('/verification', [VerificationController::class, 'index'])->name('verification');
    Route::post('/verification/store', [VerificationController::class, 'store'])->name('verification.store');

    Route::get('/admin/verifications', [AdminVerificationController::class, 'index'])->name('admin.verifications');
    Route::post('/admin/verifications/{id}/approve', [AdminVerificationController::class, 'approve'])->name('admin.verifications.approve');
    Route::post('/admin/verifications/{id}/reject', [AdminVerificationController::class, 'reject'])->name('admin.verifications.reject');

    /*
    |--------------------------------------------------------------------------
    | BOOKING
    |--------------------------------------------------------------------------
    */
    Route::get('/booking', function () {
        return view('booking');
    })->name('booking');

    Route::get('/booking/{equipment}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/{equipment}', [BookingController::class, 'store'])->name('booking.store');

    // Penyewa
    Route::get('/pesanan-saya', [BookingController::class, 'myOrders'])->name('booking.my');
    Route::get('/riwayat-penyewaan', [BookingController::class, 'rentalHistory'])->name('booking.history');

    // Pemilik Alat
    Route::get('/permintaan-booking', [BookingController::class, 'ownerRequests'])->name('booking.requests');
    Route::post('/permintaan-booking/{booking}/approve', [BookingController::class, 'approve'])->name('booking.approve');
    Route::post('/permintaan-booking/{booking}/reject', [BookingController::class, 'reject'])->name('booking.reject');
    Route::get('/riwayat-transaksi', [BookingController::class, 'ownerHistory'])->name('booking.owner.history');

    // Pengembalian & Invoice
    Route::post('/booking/{booking}/return', [BookingController::class, 'markReturned'])->name('booking.return');
    Route::get('/invoice/{booking}', [BookingController::class, 'invoice'])->name('booking.invoice');

    /*
    |--------------------------------------------------------------------------
    | PEMBAYARAN
    |--------------------------------------------------------------------------
    */
    Route::get('/pembayaran/{booking}', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/pembayaran/{booking}', [PaymentController::class, 'store'])->name('payment.store');

    Route::get('/konfirmasi-pembayaran', [PaymentController::class, 'requests'])->name('payment.requests');
    Route::post('/konfirmasi-pembayaran/{payment}/approve', [PaymentController::class, 'approve'])->name('payment.approve');
    Route::post('/konfirmasi-pembayaran/{payment}/reject', [PaymentController::class, 'reject'])->name('payment.reject');

    /*
    |--------------------------------------------------------------------------
    | ADMIN - MONITORING, REPORTS & SETTINGS
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/monitoring-transaksi', [BookingController::class, 'adminMonitoring'])->name('admin.transactions');

    Route::get('/admin/laporan-sistem', [ReportController::class, 'index'])->name('admin.reports');
    Route::get('/admin/laporan-sistem/export', [ReportController::class, 'export'])->name('admin.reports.export');
    Route::get('/admin/laporan-sistem/pdf', [ReportController::class, 'exportPdf'])->name('admin.reports.pdf');

    Route::get('/admin/platform-settings', [PlatformSettingController::class, 'index'])->name('admin.platform.settings');
    Route::post('/admin/platform-settings', [PlatformSettingController::class, 'update'])->name('admin.platform.settings.update');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';