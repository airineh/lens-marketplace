@extends('layouts.lens')

@section('content')
<div class="section">
    <div class="container">

        <div class="product" style="padding:40px;">
            <div class="row">

                <div class="col-md-7">
                    <h2>Tentang Lens</h2>
                    <hr>

                    <p>
                        Lens adalah marketplace penyewaan alat fotografi berbasis web
                        yang membantu penyewa menemukan alat fotografi dan membantu
                        pemilik alat mengelola penyewaan secara lebih terstruktur.
                    </p>

                    <p>
                        Sistem ini dirancang untuk mendukung proses penyewaan mulai dari
                        pencarian alat, booking, pembayaran manual, pengembalian alat,
                        hingga perhitungan denda keterlambatan.
                    </p>

                    <a href="{{ route('catalog') }}" class="primary-btn">
                        Lihat Katalog
                    </a>
                </div>

                <div class="col-md-5 text-center">
                    <i class="fa fa-camera" style="font-size:120px;color:#b31935;margin-top:40px;"></i>
                    <h3>Lens Rental System</h3>
                    <p>Aman, mudah, dan terpantau.</p>
                </div>

            </div>
        </div>

        <br>

        <div class="row">

            <div class="col-md-4">
                <div class="product" style="padding:30px;text-align:center;">
                    <i class="fa fa-id-card" style="font-size:45px;color:#b31935;"></i>
                    <h4>Pengguna Terverifikasi</h4>
                    <p>Penyewa dan pemilik alat dapat mengajukan verifikasi identitas.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="product" style="padding:30px;text-align:center;">
                    <i class="fa fa-calendar" style="font-size:45px;color:#b31935;"></i>
                    <h4>Booking Online</h4>
                    <p>Penyewa dapat mengajukan booking alat sesuai waktu sewa.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="product" style="padding:30px;text-align:center;">
                    <i class="fa fa-clock-o" style="font-size:45px;color:#b31935;"></i>
                    <h4>Monitoring Pengembalian</h4>
                    <p>Sistem menampilkan countdown dan denda keterlambatan.</p>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection