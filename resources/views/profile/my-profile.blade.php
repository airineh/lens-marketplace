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

                    <h2>Profil Saya</h2>
                    <p>Kelola data akun, identitas, dan informasi pendukung transaksi.</p>

                    <hr>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('my.profile.update') }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        <h4>Data Profil</h4>

                        <div class="form-group">
                            <label>Foto Profil</label>
                            <br>

                            @if(auth()->user()->profile_photo)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                                     width="120"
                                     style="border-radius:50%; margin-bottom:15px;">
                            @endif

                            <input type="file" name="profile_photo" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   value="{{ auth()->user()->name }}">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   value="{{ auth()->user()->email }}">
                        </div>

                        <div class="form-group">
                            <label>Nomor HP</label>
                            <input type="text"
                                   name="phone"
                                   class="form-control"
                                   value="{{ auth()->user()->phone }}">
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="address"
                                      class="form-control">{{ auth()->user()->address }}</textarea>
                        </div>

                        <hr>

                        <h4>Verifikasi Identitas</h4>
                        <p>Data identitas yang disimpan akan dikirim untuk proses verifikasi oleh admin.</p>

                        <div class="form-group">
                            <label>Foto SIM</label>
                            <input type="file" name="sim_photo" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Selfie dengan SIM</label>
                            <input type="file" name="selfie_photo" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Link Portofolio</label>
                            <input type="text"
                                   name="portfolio_link"
                                   class="form-control"
                                   value="{{ auth()->user()->portfolio_link }}"
                                   placeholder="Contoh: Instagram, Behance, Google Drive, atau website portofolio">
                        </div>

                        <div class="form-group">
                            <label>Status Verifikasi</label>
                            <br>

                            @if(auth()->user()->verification_status == 'verified')
                                <span class="label label-success">Verified</span>
                            @else
                                <span class="label label-danger">Unverified</span>
                            @endif
                        </div>

                        

                        <button type="submit" class="primary-btn">
                            Simpan Profil & Ajukan Verifikasi
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>
</div>

@endsection