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
                    <h2>Riwayat Penyewaan</h2>
                    <p>Daftar transaksi penyewaan yang sedang berjalan atau telah selesai.</p>
                    <hr>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Alat</th>
                                <th>Pemilik</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Pembayaran</th>
                                <th>Denda</th>
                                <th>Dikembalikan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->equipment->name }}</td>
                                    <td>{{ $booking->equipment->user->name }}</td>
                                    <td>{{ $booking->start_time }}</td>
                                    <td>{{ $booking->end_time }}</td>
                                    <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                    <td><td>@if($booking->status == 'pending')
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
                                    @endif</td></td>
                                    <td>@if($booking->payment)
                                            @if($booking->payment->payment_status == 'pending')
                                                <span class="label label-warning">Pending</span>
                                            @elseif($booking->payment->payment_status == 'paid')
                                                <span class="label label-success">Paid</span>
                                            @elseif($booking->payment->payment_status == 'rejected')
                                                <span class="label label-danger">Rejected</span>
                                            @endif
                                        @else
                                            -
                                        @endif</td>
                                    <td>Rp {{ number_format($booking->late_fee ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ $booking->returned_at ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">Belum ada riwayat penyewaan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection