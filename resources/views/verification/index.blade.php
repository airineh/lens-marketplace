@extends('layouts.lens')

@section('content')

<div class="section">
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                <div class="product" style="padding:20px;">
                    <h3>Dashboard User</h3>
                    <p>Halo, {{ auth()->user()->name }}</p>
                    <hr>

                    <ul style="list-style:none; padding:0; line-height:38px;">
                        <li><a href="{{ route('dashboard') }}"><i class="fa fa-user"></i> Profil Saya</a></li>
                        <li><a href="{{ route('verification') }}"><i class="fa fa-id-card"></i> Verifikasi Identitas</a></li>
                        <li><a href="{{ route('equipments.index') }}"><i class="fa fa-camera"></i> My Inventory</a></li>
                        <li><a href="{{ route('equipments.create') }}"><i class="fa fa-plus"></i> Tambah Alat</a></li>
                        <li><a href="{{ route('catalog') }}"><i class="fa fa-shopping-bag"></i> Katalog</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" style="border:none; background:none; padding:0;">
                                    <i class="fa fa-sign-out"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9">
                <div class="product" style="padding:30px;">
                    <h2>Verifikasi Identitas</h2>
                    <p>Upload SIM dan portofolio untuk meningkatkan keamanan transaksi penyewaan.</p>
                    <hr>

                    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                   @if($verification)

    @if($verification->status == 'pending')

        <div class="alert alert-warning">
            Status Verifikasi:
            <strong>PENDING</strong>
            - Menunggu validasi admin.
        </div>

    @elseif($verification->status == 'approved')

        <div class="alert alert-success">
            Status Verifikasi:
            <strong>VERIFIED</strong>
        </div>

    @elseif($verification->status == 'rejected')

        <div class="alert alert-danger">
            Status Verifikasi:
            <strong>REJECTED</strong>
            - Silakan upload ulang data verifikasi.
        </div>

    @endif

@endif

                    <form action="{{ route('verification.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Foto SIM</label>
                            <input type="file" name="sim_photo" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Selfie dengan SIM</label>
                            <input type="file" name="selfie_photo" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Link Portofolio</label>
                            <input type="text" name="portfolio_link" class="form-control"
                                   placeholder="Instagram / Behance / Website"
                                   value="{{ $verification->portfolio_link ?? auth()->user()->portfolio_link }}">
                        </div>

                        <button type="submit" class="primary-btn">
                            Kirim Verifikasi
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection