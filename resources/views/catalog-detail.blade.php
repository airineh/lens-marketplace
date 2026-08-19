@extends('layouts.lens') @section('content')
<div class="section">
    <div class="container">

        <div class="row">

            <div class="col-md-6">
                <div class="product" style="padding:30px; text-align:center;">
                    @if($equipment->photo)
                    <img
                        src="{{ asset('storage/' . $equipment->photo) }}"
                        style="max-width:100%; max-height:400px;">
                    @else
                    <p>Foto belum tersedia</p>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="product" style="padding:30px;">
                    <p>{{ $equipment->category->name ?? 'Tanpa Kategori' }}</p>

                    <h2>{{ $equipment->name }}</h2>

                    <h3>
                        Rp
                        {{ number_format($equipment->price_per_hour, 0, ',', '.') }}
                        / jam
                    </h3>

                    <p>{{ $equipment->description }}</p>

                    <p>
                        Status:
                        <strong>{{ $equipment->stock_status }}</strong>
                    </p>

                    <hr>

                    <h4>Pemilik Alat</h4>

                    <p>
                        Nama:
                        <strong>{{ $equipment->user->name ?? '-' }}</strong>
                    </p>

                    <p>
                        Status Verifikasi:
                        <strong>{{ $equipment->user->verification_status ?? 'unverified' }}</strong>
                    </p>

                    @if($equipment->user && $equipment->user->verification &&
                    $equipment->user->verification->portfolio_link)
                    <p>
                        Portofolio:
                        <a href="{{ $equipment->user->verification->portfolio_link }}" target="_blank">
                            Lihat Portofolio
                        </a>
                    </p>
                    @elseif($equipment->user && $equipment->user->portfolio_link)
                    <p>
                        Portofolio:
                        <a href="{{ $equipment->user->portfolio_link }}" target="_blank">
                            Lihat Portofolio
                        </a>
                    </p>
                    @else
                    <p>Portofolio: belum tersedia</p>
                    @endif

                    <br>

                    @if(auth()->check() && auth()->user()->role == 'penyewa')
    <a href="{{ route('booking.create', $equipment->id) }}" class="primary-btn">
        Booking Alat
    </a>
@elseif(auth()->check() && auth()->user()->role == 'pemilik_alat')
    <p><strong>Pemilik alat tidak dapat melakukan booking.</strong></p>
@else
    <a href="{{ route('login') }}" class="primary-btn">
        Login untuk Booking
    </a>
@endif

                    <a href="{{ route('catalog') }}" class="primary-btn">
                        Kembali
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection