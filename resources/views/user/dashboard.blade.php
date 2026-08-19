@extends('layouts.lens')

@section('content')

<div class="section">
    <div class="container">

        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-md-3">
                <div class="product" style="padding:20px;">
                    <h3>User Space</h3>
                    <p>Welcome, {{ auth()->user()->name }}</p>
                    <hr>

                    <ul style="list-style:none; padding:0; line-height:38px;">
                        <li>
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-user"></i> Profil Saya
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('verification') }}">
                                <i class="fa fa-id-card"></i> Verifikasi Identitas
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('equipments.index') }}">
                                <i class="fa fa-camera"></i> My Inventory
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('equipments.create') }}">
                                <i class="fa fa-plus"></i> Tambah Alat
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('catalog') }}">
                                <i class="fa fa-shopping-bag"></i> Katalog
                            </a>
                        </li>

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

            <!-- CONTENT -->
            <div class="col-md-9">
                <div class="product" style="padding:30px;">

                    <h2>Profil Saya</h2>
                    <p>Lengkapi data profil agar proses penyewaan lebih terpercaya.</p>
                    <hr>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('my.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Foto Profil</label><br>

                            @if(auth()->user()->profile_photo)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                                     width="120"
                                     style="border-radius:50%; margin-bottom:15px;">
                            @endif

                            <input type="file" name="profile_photo" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ auth()->user()->name }}">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ auth()->user()->email }}">
                        </div>

                        <div class="form-group">
                            <label>Nomor HP</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ auth()->user()->phone }}">
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="address" class="form-control">{{ auth()->user()->address }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Link Portofolio</label>
                            <input type="text" name="portfolio_link" class="form-control"
                                   value="{{ auth()->user()->portfolio_link }}">
                        </div>

                        <div class="form-group">
                            <label>Status Verifikasi</label><br>

                            @if(auth()->user()->verification_status == 'verified')
                                <span class="label label-success">Verified</span>
                            @else
                                <span class="label label-danger">Unverified</span>
                            @endif
                        </div>

                        <button type="submit" class="primary-btn">
                            Simpan Profil
                        </button>
                    </form>

                </div>
            </div>

        </div>

    </div>
</div>

@endsection