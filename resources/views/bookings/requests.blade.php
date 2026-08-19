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
                    <h2>Permintaan Booking</h2>
                    <p>Daftar permintaan penyewaan alat dari penyewa.</p>
                    
                    <hr>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Penyewa</th>
                                <th>Kontak</th> <th>Alat</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Total</th>
                                <th>Bukti Bayar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                       <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td>{{ $booking->user->name ?? 'Penyewa' }}</td>
                                
                                <td>
                                    @if(!empty($booking->user->phone))
                                        <a href="https://wa.me/{{ $booking->user->phone }}" target="_blank" class="btn btn-sm btn-success" style="background-color: #22c55e; color: white; padding: 5px 10px; border: none; border-radius: 4px; font-size: 11px;">
                                            <i class="fa fa-whatsapp"></i> Chat WA
                                        </a>
                                    @else
                                        <span class="text-muted" style="font-size: 11px;">Tidak ada nomor</span>
                                    @endif
                                </td>

                                <td>{{ $booking->equipment->name ?? 'Alat' }}</td>
                                <td>{{ $booking->start_time }}</td>
                                <td>{{ $booking->end_time }}</td>
                                <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                
                                <td>
                                    @if($booking->payment && !empty($booking->payment->proof_payment))
                                        <a href="{{ asset('storage/' . $booking->payment->proof_payment) }}" target="_blank" class="btn btn-sm btn-info" style="background-color: #0284c7; color: white; padding: 5px 10px; border: none; border-radius: 4px; font-size: 11px;">
                                            <i class="fa fa-image"></i> Cek Bukti
                                        </a>
                                    @else
                                        <span class="text-muted" style="font-size: 11px;">Belum ada berkas</span>
                                    @endif
                                </td>

                                <td>
                                    @if($booking->payment && $booking->payment->payment_status == 'paid')
                                        <span class="label label-success">Lunas (Admin)</span>
                                    @else
                                        <span class="label label-warning">Belum Bayar</span>
                                    @endif
                                </td>

                                <td>
                                    @if($booking->payment && $booking->payment->payment_status == 'paid')
                                        @if($booking->status == 'pending' || $booking->status == 'approved')
                                            <form action="{{ route('booking.approve', $booking->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button class="btn btn-success btn-sm" style="background-color: #22c55e; border:none; padding: 5px 10px; border-radius: 4px;">Setujui</button>
                                            </form>

                                            <form action="{{ route('booking.reject', $booking->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button class="btn btn-danger btn-sm" style="background-color: #ef4444; border:none; padding: 5px 10px; border-radius: 4px;">Tolak</button>
                                            </form>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    @else
                                        <span class="text-muted" style="font-style: italic; font-size: 12px; color: #9ca3af;">Menunggu Validasi Admin</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Belum ada permintaan booking yang siap divalidasi.</td>
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