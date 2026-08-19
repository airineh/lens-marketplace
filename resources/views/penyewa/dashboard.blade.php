@extends('layouts.lens') @section('content')
<div class="section">
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                @include('partials.sidebar')
            </div>

            <div class="col-md-9">
                <div class="product" style="padding:30px;">
                    <h2>Dashboard Penyewa</h2>
                    <p>Kelola pesanan, status verifikasi, dan riwayat penyewaan alat fotografi.</p>
                    <hr>

                    <div class="row">
                       <div class="col-md-4">
                            <div class="product" style="padding:20px;text-align:center;">
                                <a href="{{ route('booking.my') }}" style="text-decoration:none; color:inherit;">
                                <h3>{{ $activeOrders }}</h3>
                                <p>Pesanan Aktif</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="product" style="padding:20px;text-align:center;">
                                <a href="{{ route('booking.my') }}" style="text-decoration:none; color:inherit;">
                                <h3>{{ $waitingPayments }}</h3>
                                <p>Menunggu Pembayaran</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="product" style="padding:20px;text-align:center;">
                                <a href="{{ route('my.profile') }}" style="text-decoration:none; color:inherit;">
                                @if($verificationStatus == 'verified')
                                    <h3 style="color:green;">Verified</h3>
                                @else
                                    <h3 style="color:red;">Unverified</h3>
                                @endif

                                <p>Status Verifikasi</p>
                            </div>
                        </div>
                    </div>

                    <br>
                    <a href="{{ route('catalog') }}" class="primary-btn">Cari Alat Sekarang</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection