@extends('layouts.lens') @section('content')
<div class="section">
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                @include('partials.sidebar')
            </div>

            <div class="col-md-9">
                <div class="product" style="padding:30px;">
                    <h2>Dashboard Pemilik Alat</h2>
                    <p>Kelola alat, permintaan booking, dan transaksi penyewaan.</p>
                    <hr>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="product" style="padding:20px;text-align:center;">
                                <a href="{{ route('equipments.index') }}" style="text-decoration:none; color:inherit;">
                                <h3>{{ $totalEquipments }}</h3>
                                <p>Total Alat</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="product" style="padding:20px;text-align:center;">
                                <a href="{{ route('booking.requests') }}" style="text-decoration:none; color:inherit;">
                                 <h3>{{ $pendingBookings }}</h3>
                                <p>Permintaan Booking</p>
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

                   <div class="row">

                        <div class="col-md-4">
                            <div class="product" style="padding:20px;text-align:center;">
                                <h3>{{ $totalTransactionCount }}</h3>
                                <p>Total Transaksi</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="product"
                                style="padding:20px;text-align:center;background:#fef3c7;">
                                <h3>
                                    Rp {{ number_format($totalCommission,0,',','.') }}
                                </h3>
                                <p>Komisi Lens</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="product"
                                style="padding:20px;text-align:center;background:#dcfce7;">
                                <h3>
                                    Rp {{ number_format($totalOwnerIncome,0,',','.') }}
                                </h3>
                                <p>Pendapatan Bersih</p>
                            </div>
                        </div>

                    </div>

                    <br>
                    <a href="{{ route('equipments.create') }}" class="primary-btn">Tambah Alat</a>
                    <a href="{{ route('equipments.index') }}" class="primary-btn">My Inventory</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection