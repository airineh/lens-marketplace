<?php

use Illuminate\Support\Facades\Route;
use App\Models\Equipment;

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


Route::get('/catalog', function (\Illuminate\Http\Request $request) {

    $equipments = Equipment::with('user', 'category')
        ->where('stock_status', 'available')

        ->when($request->filled('category'), function ($query) use ($request) {
            $query->where('category_id', $request->category);
        })

        ->when($request->filled('search'), function ($query) use ($request) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        })

        ->latest()
        ->get();

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
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | EQUIPMENT / INVENTORY
    |--------------------------------------------------------------------------
    */

    Route::resource('equipments', EquipmentController::class);


    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | LENS PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/my-profile', [LensProfileController::class, 'index'])
        ->name('my.profile');

    Route::post('/my-profile/update', [LensProfileController::class, 'update'])
        ->name('my.profile.update');


    /*
    |--------------------------------------------------------------------------
    | USER VERIFICATION
    |--------------------------------------------------------------------------
    */

    Route::get('/verification', [VerificationController::class, 'index'])
        ->name('verification');

    Route::post('/verification/store', [VerificationController::class, 'store'])
        ->name('verification.store');


    /*
    |--------------------------------------------------------------------------
    | ADMIN - VERIFICATION
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/verifications', [AdminVerificationController::class, 'index'])
        ->name('admin.verifications');

    Route::post('/admin/verifications/{id}/approve', [AdminVerificationController::class, 'approve'])
        ->name('admin.verifications.approve');

    Route::post('/admin/verifications/{id}/reject', [AdminVerificationController::class, 'reject'])
        ->name('admin.verifications.reject');


    /*
    |--------------------------------------------------------------------------
    | BOOKING
    |--------------------------------------------------------------------------
    */

    // Halaman booking umum
    Route::get('/booking', function () {
        return view('booking');
    })->name('booking');


    // Form booking berdasarkan alat
    Route::get('/booking/{equipment}', [BookingController::class, 'create'])
        ->name('booking.create');

    // Simpan booking
    Route::post('/booking/{equipment}', [BookingController::class, 'store'])
        ->name('booking.store');


    /*
    |--------------------------------------------------------------------------
    | PENYEWA - PESANAN
    |--------------------------------------------------------------------------
    */

    Route::get('/pesanan-saya', [BookingController::class, 'myOrders'])
        ->name('booking.my');

    Route::get('/riwayat-penyewaan', [BookingController::class, 'rentalHistory'])
        ->name('booking.history');


    /*
    |--------------------------------------------------------------------------
    | PEMILIK ALAT - PERMINTAAN BOOKING
    |--------------------------------------------------------------------------
    */

    Route::get('/permintaan-booking', [BookingController::class, 'ownerRequests'])
        ->name('booking.requests');

    Route::post('/permintaan-booking/{booking}/approve', [BookingController::class, 'approve'])
        ->name('booking.approve');

    Route::post('/permintaan-booking/{booking}/reject', [BookingController::class, 'reject'])
        ->name('booking.reject');


    /*
    |--------------------------------------------------------------------------
    | PEMILIK ALAT - RIWAYAT TRANSAKSI
    |--------------------------------------------------------------------------
    */

    Route::get('/riwayat-transaksi', [BookingController::class, 'ownerHistory'])
        ->name('booking.owner.history');


    /*
    |--------------------------------------------------------------------------
    | PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    // Form upload bukti pembayaran oleh penyewa
    Route::get('/pembayaran/{booking}', [PaymentController::class, 'create'])
        ->name('payment.create');

    // Simpan bukti pembayaran
    Route::post('/pembayaran/{booking}', [PaymentController::class, 'store'])
        ->name('payment.store');


    /*
    |--------------------------------------------------------------------------
    | ADMIN - VALIDASI PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    Route::get('/konfirmasi-pembayaran', [PaymentController::class, 'requests'])
        ->name('payment.requests');

    Route::post('/konfirmasi-pembayaran/{payment}/approve', [PaymentController::class, 'approve'])
        ->name('payment.approve');

    Route::post('/konfirmasi-pembayaran/{payment}/reject', [PaymentController::class, 'reject'])
        ->name('payment.reject');


    /*
    |--------------------------------------------------------------------------
    | PENGEMBALIAN ALAT
    |--------------------------------------------------------------------------
    */

    Route::post('/booking/{booking}/return', [BookingController::class, 'markReturned'])
        ->name('booking.return');


    /*
    |--------------------------------------------------------------------------
    | ADMIN - MONITORING TRANSAKSI
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/monitoring-transaksi', [BookingController::class, 'adminMonitoring'])
        ->name('admin.transactions');


    /*
    |--------------------------------------------------------------------------
    | ADMIN - LAPORAN
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/laporan-sistem', [ReportController::class, 'index'])
        ->name('admin.reports');

    Route::get('/admin/laporan-sistem/export', [ReportController::class, 'export'])
        ->name('admin.reports.export');

    Route::get('/admin/laporan-sistem/pdf', [ReportController::class, 'exportPdf'])
        ->name('admin.reports.pdf');


    /*
    |--------------------------------------------------------------------------
    | ADMIN - PLATFORM SETTINGS
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/platform-settings', [PlatformSettingController::class, 'index'])
        ->name('admin.platform.settings');

    Route::post('/admin/platform-settings', [PlatformSettingController::class, 'update'])
        ->name('admin.platform.settings.update');

});

Route::get('/invoice/{booking}', [\App\Http\Controllers\BookingController::class, 'invoice'])->name('booking.invoice')->middleware('auth');

// routes/web.php

Route::get('/catalog', function (Illuminate\Http\Request $request) {
    $query = App\Models\Equipment::where('stock_status', 'available');

    // Filter berdasarkan kategori jika ada parameter category di URL
    if ($request->has('category') && $request->category != '') {
        $query->whereHas('category', function ($q) use ($request) {
            $q->where('slug', $request->category)
              ->orWhere('name', $request->category);
        });
    }

    // Pencarian kata kunci
    if ($request->has('search') && $request->search != '') {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }

    $equipments = $query->latest()->get();

    return view('catalog', compact('equipments'));
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';