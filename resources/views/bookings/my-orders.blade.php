@extends('layouts.lens')

@section('content')
<div class="section">
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                @include('partials.sidebar')
            </div>

            <div class="col-md-9">
                <div class="product" style="padding:30px;">
                    <h2>Pesanan Saya</h2>
                    <hr>

                    @foreach($bookings as $booking)
                        @if($booking->status == 'active')
                            <div class="alert alert-info">
                                Penyewaan alat <strong>{{ $booking->equipment->name }}</strong> sedang aktif. 
                                Batas pengembalian: <strong>{{ $booking->end_time }}</strong>.
                            </div>
                        @endif
                    @endforeach

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Alat</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Countdown</th>
                                <th>Denda</th>
                                <th class="no-print">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->equipment->name }}</td>
                                    <td>{{ $booking->start_time }}</td>
                                    <td>{{ $booking->end_time }}</td>
                                    <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        @if($booking->status == 'pending')
                                            <span class="label label-warning">Pending</span>
                                        @elseif($booking->status == 'approved')
                                            <span class="label label-info">Approved</span>
                                        @elseif($booking->status == 'active')
                                            <span class="label label-primary">Active</span>
                                        @elseif($booking->status == 'completed')
                                            <span class="label label-success">Completed</span>
                                        @elseif($booking->status == 'rejected')
                                            <span class="label label-danger">Rejected</span>
                                        @else
                                            <span class="label label-default">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking->status == 'active')
                                            <span class="countdown" data-end="{{ \Carbon\Carbon::parse($booking->end_time)->format('Y-m-d H:i:s') }}">
                                                Menghitung...
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $lateFeePerHour = 30000;
                                            $now = \Carbon\Carbon::now();
                                            $endTime = \Carbon\Carbon::parse($booking->end_time);
                                            if ($booking->status == 'active' && $now->greaterThan($endTime)) {
                                                $lateHours = ceil($endTime->diffInMinutes($now) / 60);
                                                $lateFee = $lateHours * $lateFeePerHour;
                                            } else {
                                                $lateHours = 0;
                                                $lateFee = 0;
                                            }
                                        @endphp
                                        @if($lateFee > 0)
                                            <strong style="color:red;">Rp {{ number_format($lateFee, 0, ',', '.') }}</strong><br>
                                            <small>{{ $lateHours }} jam terlambat</small><br>
                                            <small>Bayar denda ke rekening pemilik saat pengembalian.</small>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="no-print">
                                        <div style="display: flex; flex-direction: column; gap: 6px;">
                                            @if($booking->status == 'pending')
                                                @if(!$booking->payment || $booking->payment->payment_status == 'rejected')
                                                    <a href="{{ route('payment.create', ['booking' => $booking->id]) }}" class="btn btn-success btn-sm" style="background-color: #22c55e; border: none; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">
                                                        Upload Bukti
                                                    </a>
                                                @else
                                                    <span class="text-muted" style="font-size: 11px; font-style: italic;">Verifikasi Admin</span>
                                                @endif
                                            @elseif($booking->status == 'approved')
                                                <span class="label label-info" style="font-size: 10px;">Menunggu Unit Diambil</span>
                                            @endif

                                            {{-- Tombol Cetak Invoice untuk semua status --}}
                                           <a href="{{ route('booking.invoice', $booking->id) }}" target="_blank" class="btn btn-default btn-sm" style="padding: 4px 8px; font-size: 11px; border: 1px solid #ccc; background: #fff; border-radius: 4px; text-decoration: none; display: inline-block;">
    <i class="fa fa-print"></i> Cetak Invoice
</a>
                                            
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">Belum ada pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
@media print {
    .no-print, header, footer, .sidebar, .nav, .col-md-3, form, .alert, .header, #header, #top-header, #navigation {
        display: none !important;
    }
    .col-md-9 {
        width: 100% !important;
        float: none !important;
    }
    body {
        background: #fff !important;
        color: #000 !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const countdowns = document.querySelectorAll('.countdown');

    function updateCountdown() {
        countdowns.forEach(function (item) {
            const endTime = new Date(item.dataset.end.replace(' ', 'T')).getTime();
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance <= 0) {
                const lateDistance = Math.abs(distance);
                const lateDays = Math.floor(lateDistance / (1000 * 60 * 60 * 24));
                const lateHours = Math.floor((lateDistance / (1000 * 60 * 60)) % 24);
                const lateMinutes = Math.floor((lateDistance / (1000 * 60)) % 60);

                item.innerHTML = '<span style="color:red; font-weight:bold;">Terlambat ' +
                        lateDays + ' hari ' + lateHours + ' jam ' + lateMinutes + ' menit</span>';
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
            const minutes = Math.floor((distance / (1000 * 60)) % 60);
            const seconds = Math.floor((distance / 1000) % 60);

            item.innerHTML = days + ' hari ' + hours + ' jam ' + minutes + ' menit ' + seconds + ' detik';
        });
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
});
</script>
@endsection