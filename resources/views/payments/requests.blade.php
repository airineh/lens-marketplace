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
                    <h2>Konfirmasi Pembayaran</h2>
                    <p>Periksa bukti pembayaran dari penyewa.</p>
                    <hr>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Penyewa</th>
                                <th>Alat</th>
                                <th>Total</th>
                                <th>Bukti</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($payments as $payment)
                                <tr>
                                    <td>{{ $payment->booking->user->name }}</td>
                                    <td>{{ $payment->booking->equipment->name }}</td>
                                    <td>Rp {{ number_format($payment->booking->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $payment->proof_payment) }}" target="_blank">
                                            Lihat Bukti
                                        </a>
                                    </td>
                                    <td>{{ ucfirst($payment->payment_status) }}</td>
                                    <td>
                                        @if($payment->payment_status == 'pending')
                                            <form action="{{ route('payment.approve', $payment->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button class="btn btn-success btn-sm">Terima</button>
                                            </form>

                                            <form action="{{ route('payment.reject', $payment->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button class="btn btn-danger btn-sm">Tolak</button>
                                            </form>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Belum ada pembayaran yang perlu dikonfirmasi.</td>
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