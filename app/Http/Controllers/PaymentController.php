<?php

namespace App\Http\Controllers;

use App\Models\PlatformSetting;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(Booking $booking)
    {
        if ($booking->user_id != auth()->id()) {
            abort(403);
        }

        // REVISI VALIDASI: Izinkan upload selama status booking masih 'pending'
        if ($booking->status != 'pending') {
            return redirect()->route('booking.my');
        }

        $booking->load('equipment.user', 'payment');

        $platform = PlatformSetting::first();

        return view('payments.create', compact('booking', 'platform'));
    }

   public function store(Request $request, Booking $booking)
    {
        if ($booking->user_id != auth()->id()) {
            abort(403);
        }

        $request->validate([
            'proof_payment' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $proof = $request->file('proof_payment')->store('payments', 'public');

        Payment::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                // UBAH BARIS INI: Gunakan proof_payment sesuai kolom database kamu
                'proof_payment' => $proof, 
                'payment_status' => 'pending',
            ]
        );

        return redirect()
            ->route('booking.my')
            ->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi dari Admin LENS.');
    }

    // SISIPKAN KEMBALI FUNGSI INI DI PAYMENTCONTROLLER:
   public function requests()
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $payments = Payment::with(['booking.user', 'booking.equipment'])
            ->where('payment_status', 'pending')
            ->latest()
            ->get();

        // UBAH BAGIAN INI: Sesuaikan dengan lokasi file asli bawaan sistem kamu
        return view('payments.requests', compact('payments')); 
    }

    // Fungsi konfirmasi pembayaran dipindah alurnya ke Admin via Dashboard Monitoring
    public function approve(Payment $payment)
    {
        // Pengaman: Hanya admin yang boleh mengeksekusi ini
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $payment->update([
            'payment_status' => 'paid',
        ]);

        // Catatan: Status booking tetap 'pending' sampai si pemilik mengklik tombol "Setujui" di dashboard-nya
        return back()->with('success', 'Pembayaran berhasil dikonfirmasi sebagai LUNAS.');
    }

    public function reject(Payment $payment)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $payment->update([
            'payment_status' => 'rejected',
        ]);

        return back()->with('success', 'Pembayaran ditolak.');
    }
}