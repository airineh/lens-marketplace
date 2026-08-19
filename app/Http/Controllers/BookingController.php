<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\PlatformSetting;
use App\Models\Booking;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create(Equipment $equipment)
    {
        $equipment->load('user', 'category');

        return view('bookings.create', compact('equipment'));
    }

    public function store(Request $request, Equipment $equipment)
{
    $request->validate([
        'start_time' => 'required|date',
        'end_time' => 'required|date|after:start_time',
    ]);

    $start = Carbon::parse($request->start_time);
    $end = Carbon::parse($request->end_time);

    $hours = max(1, $start->diffInHours($end));
    $totalPrice = $hours * $equipment->price_per_hour;

        // ambil setting platform
        $setting = PlatformSetting::first();

        $commissionPercentage = $setting
            ? $setting->commission_percentage
            : 2;

        $commissionAmount = ($totalPrice * $commissionPercentage) / 100;

        $ownerIncome = $totalPrice - $commissionAmount;

        Booking::create([
        'user_id' => auth()->id(),
        'equipment_id' => $equipment->id,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'status' => 'pending',

        'total_price' => $totalPrice,

        'platform_fee' => $commissionAmount,

        'commission_percentage' => $commissionPercentage,

        'commission_amount' => $commissionAmount,

        'owner_income' => $ownerIncome,
    ]);

    return redirect()
        ->route('dashboard')
        ->with('success', 'Booking berhasil diajukan dan menunggu persetujuan pemilik alat.');
}

public function myOrders()
{
    $bookings = Booking::with('equipment')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('bookings.my-orders', compact('bookings'));
}

public function ownerRequests()
{
    // Mengambil semua data booking milik peralatan user yang sedang login
    $bookings = Booking::with(['equipment', 'user', 'payment'])
        ->whereHas('equipment', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->where(function($query) {
            // Tampilkan yang status sewa keseluruhannya masih pending
            // ATAU yang sudah divalidasi pembayarannya oleh admin
            $query->where('status', 'pending')
                  ->orWhereHas('payment', function($q) {
                      $q->where('payment_status', 'paid');
                  });
        })
        ->latest()
        ->get();

    return view('bookings.requests', compact('bookings'));
}

public function approve(Booking $booking)
{
    if ($booking->equipment->user_id != auth()->id()) {
        abort(403);
    }

    // UBAH STATUS JADI 'active' AGAR SINKRON DENGAN ALUR SEWA LANGSUNG JALAN
    $booking->update([
        'status' => 'active'
    ]);

    return redirect()
        ->route('booking.requests')
        ->with('success', 'Booking berhasil disetujui. Status penyewaan sekarang telah AKTIF!');
}

public function reject(Booking $booking)
{
    if ($booking->equipment->user_id != auth()->id()) {
        abort(403);
    }

    $booking->update([
        'status' => 'rejected'
    ]);

    return redirect()
        ->route('booking.requests')
        ->with('success', 'Booking berhasil ditolak.');
}

public function rentalHistory()
{
    $bookings = Booking::with('equipment.user', 'payment')
        ->where('user_id', auth()->id())
        ->whereIn('status', ['active', 'completed'])
        ->latest()
        ->get();

    return view('bookings.history', compact('bookings'));
}

public function ownerHistory(\Illuminate\Http\Request $request)
{
    $user = auth()->user();

    $query = \App\Models\Booking::whereHas('equipment', function ($q) use ($user) {
        $q->where('user_id', $user->id);
    })->with(['equipment', 'user', 'payment']);

    // Filter Periode Waktu
    if ($request->filled('period')) {
        if ($request->period == 'today') {
            $query->whereDate('created_at', \Carbon\Carbon::today());
        } elseif ($request->period == 'this_week') {
            $query->whereBetween('created_at', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()]);
        } elseif ($request->period == 'this_month') {
            $query->whereMonth('created_at', \Carbon\Carbon::now()->month)
                  ->whereYear('created_at', \Carbon\Carbon::now()->year);
        }
    }

    // Filter Rentang Tanggal Manual (jika dipilih)
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereDate('created_at', '>=', $request->start_date)
              ->whereDate('created_at', '<=', $request->end_date);
    }

    $bookings = $query->latest()->get();

    // Hitung ringkasan statistik
    $totalGross = $bookings->whereIn('status', ['active', 'completed'])->sum('total_price');
    $totalCommission = $bookings->whereIn('status', ['active', 'completed'])->sum('commission_amount');
    $totalNetIncome = $bookings->whereIn('status', ['active', 'completed'])->sum('owner_income');

    return view('bookings.owner-history', compact('bookings', 'totalGross', 'totalCommission', 'totalNetIncome'));
}

public function adminMonitoring(Request $request)
{
    $query = Booking::with([
        'equipment.user',
        'user',
        'payment'
    ]);

    if ($request->start_date) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->end_date) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    $bookings = $query
        ->latest()
        ->get();

    $totalTransactionValue = $bookings
        ->whereIn('status', ['active', 'completed'])
        ->sum('total_price');

    $totalCommission = $bookings
        ->whereIn('status', ['active', 'completed'])
        ->sum('commission_amount');

    $totalOwnerIncome = $bookings
        ->whereIn('status', ['active', 'completed'])
        ->sum('owner_income');

    return view('admin.transactions', compact(
        'bookings',
        'totalTransactionValue',
        'totalCommission',
        'totalOwnerIncome'
    ));
}

public function markReturned(Booking $booking)
{
    if ($booking->equipment->user_id != auth()->id()) {
        abort(403);
    }

    $lateFeePerHour = 30000; // Tarif denda per jam sesuai sistem kamu

    $now = \Carbon\Carbon::now();
    $endTime = \Carbon\Carbon::parse($booking->end_time);

    if ($now->greaterThan($endTime)) {
        $lateHours = ceil($endTime->diffInMinutes($now) / 60);
        $lateFee = $lateHours * $lateFeePerHour;
    } else {
        $lateFee = 0;
    }

    $booking->update([
        'status' => 'completed',
        'returned_at' => $now,
        'late_fee' => $lateFee,
    ]);

    // REVISI NOTIFIKASI: Jika ada denda, ingatkan pemilik untuk tagih langsung di tempat
    if ($lateFee > 0) {
        return back()->with('success', 'Alat berhasil dikembalikan! Terdeteksi keterlambatan. Silakan tagih denda sebesar Rp ' . number_format($lateFee, 0, ',', '.') . ' langsung ke Penyewa.');
    }

    return back()->with('success', 'Alat berhasil ditandai sudah dikembalikan tepat waktu.');
}

// app/Http/Controllers/BookingController.php

public function showOwnerDashboard()
{
    // Sistem mengambil data booking yang statusnya pending/approved
    // eager loading 'user' digunakan untuk menarik data nomor HP penyewa secara otomatis
    $bookingRequests = Booking::with('user')
                        ->whereIn('status', ['pending', 'approved'])
                        ->get();

    return view('owner.booking_request', compact('bookingRequests'));
}

public function invoice(\App\Models\Booking $booking)
{
    // Pastikan hanya penyewa terkait, pemilik alat, atau admin yang bisa mengakses
    if (auth()->id() !== $booking->user_id && auth()->id() !== $booking->equipment->user_id && auth()->user()->role !== 'admin') {
        abort(403, 'Akses tidak diizinkan.');
    }

    return view('bookings.invoice', compact('booking'));
}

public function ownerReport()
{
    $user = auth()->user();

    // Mengambil semua booking untuk alat milik user ini
    $bookings = \App\Models\Booking::whereHas('equipment', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })->with(['equipment', 'user', 'payment'])->latest()->get();

    // Hitung agregasi pendapatan
    $totalGross = $bookings->whereIn('status', ['active', 'completed'])->sum('total_price');
    $totalCommission = $bookings->whereIn('status', ['active', 'completed'])->sum('commission_amount');
    $totalNetIncome = $bookings->whereIn('status', ['active', 'completed'])->sum('owner_income');
    $totalCompleted = $bookings->where('status', 'completed')->count();

    return view('owner.report', compact('bookings', 'totalGross', 'totalCommission', 'totalNetIncome', 'totalCompleted'));
}

// app/Http/Controllers/BookingController.php

public function returnEquipment(Request $request, Booking $booking)
{
    $request->validate([
        'return_date' => 'required|date',
    ]);

    $returnDate = \Carbon\Carbon::parse($request->return_date);
    $endDate = \Carbon\Carbon::parse($booking->end_date);
    
    $lateDays = max(0, $returnDate->diffInDays($endDate, false) * -1);
    $lateFee = $lateDays * ($booking->equipment->price_per_day * 0.5); // Contoh denda 50%/hari

    $booking->update([
        'return_date' => $returnDate,
        'late_fee' => $lateFee,
        'status' => 'returned',
        'late_fee_status' => $lateFee > 0 ? 'unpaid' : 'none',
    ]);

    // Kembalikan status ketersediaan alat
    $booking->equipment->update(['is_available' => true]);

    return redirect()->back()->with('success', 'Peralatan berhasil dikembalikan.');
}

}