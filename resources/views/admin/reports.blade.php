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
                    <h2>Laporan Sistem</h2>
                    <p>Ringkasan data aktivitas pada sistem Lens.</p>
                    
                    <form action="{{ route('admin.reports') }}" method="GET" style="margin-bottom: 30px; padding: 15px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 6px;">
                        <div class="row">
                            <div class="col-md-4">
                                <label style="font-size: 12px; color: #6b7280;">DARI TANGGAL</label>
                                <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label style="font-size: 12px; color: #6b7280;">SAMPAI TANGGAL</label>
                                <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label>&nbsp;</label>
                                <button type="submit" class="primary-btn" style="width:100%; text-align:center; padding: 10px 0; border-radius: 4px;">FILTER DATA</button>
                            </div>
                        </div>
                    </form>

                    <div style="margin-bottom: 20px;">
                        <a href="{{ route('admin.reports.export', request()->all()) }}" class="primary-btn" style="border-radius: 4px; padding: 8px 15px; font-size: 13px;"><i class="fa fa-file-excel-o"></i> Export CSV</a>
                        <a href="{{ route('admin.reports.pdf', request()->all()) }}" class="primary-btn" style="border-radius: 4px; padding: 8px 15px; font-size: 13px; background-color: #333;"><i class="fa fa-file-pdf-o"></i> Export PDF</a>
                    </div>
                    
                    <hr>

                    <h4 style="margin-bottom: 15px; color: #374151;">Informasi Utama Platform</h4>
                    <div class="row">
                        <div class="col-md-3" style="margin-bottom: 15px;">
                            <div class="product" style="padding:15px; text-align:center; border-radius: 6px; background: #fff;">
                                <h3 style="margin: 0; color: #111827;">{{ $totalUsers }}</h3>
                                <p style="margin: 5px 0 0 0; font-size: 12px; color: #6b7280;">Total Pengguna</p>
                            </div>
                        </div>
                        <div class="col-md-3" style="margin-bottom: 15px;">
                            <div class="product" style="padding:15px; text-align:center; border-radius: 6px; background: #fff;">
                                <h3 style="margin: 0; color: #111827;">{{ $totalPenyewa }}</h3>
                                <p style="margin: 5px 0 0 0; font-size: 12px; color: #6b7280;">Total Penyewa</p>
                            </div>
                        </div>
                        <div class="col-md-3" style="margin-bottom: 15px;">
                            <div class="product" style="padding:15px; text-align:center; border-radius: 6px; background: #fff;">
                                <h3 style="margin: 0; color: #111827;">{{ $totalPemilik }}</h3>
                                <p style="margin: 5px 0 0 0; font-size: 12px; color: #6b7280;">Total Pemilik</p>
                            </div>
                        </div>
                        <div class="col-md-3" style="margin-bottom: 15px;">
                            <div class="product" style="padding:15px; text-align:center; border-radius: 6px; background: #fff;">
                                <h3 style="margin: 0; color: #111827;">{{ $totalEquipments }}</h3>
                                <p style="margin: 5px 0 0 0; font-size: 12px; color: #6b7280;">Total Alat</p>
                            </div>
                        </div>
                    </div>

                    <br>

                    <h4 style="margin-bottom: 15px; color: #374151;">Rekapitulasi Transaksi</h4>
                    <div class="row">
                        <div class="col-md-4" style="margin-bottom: 15px;">
                            <div class="product" style="padding:25px; text-align:center; border-radius: 6px; background: #fff; border-top: 3px solid #6b7280;">
                                <h3 style="margin: 0; font-size: 20px;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                                <p style="margin: 5px 0 0 0; font-weight: bold; color: #4b5563;">Total Transaksi</p>
                            </div>
                        </div>
                        
                        <div class="col-md-4" style="margin-bottom: 15px;">
                            <div class="product" style="padding:25px; text-align:center; border-radius: 6px; background: #f0fdf4; border: 1px solid #bbf7d0; border-top: 3px solid #16a34a;">
                                <h3 style="margin: 0; font-size: 20px; color: #16a34a;">Rp {{ number_format($totalPlatformFee, 0, ',', '.') }}</h3>
                                <p style="margin: 5px 0 0 0; font-weight: bold; color: #15803d;">Komisi LENS</p>
                            </div>
                        </div>

                        <div class="col-md-4" style="margin-bottom: 15px;">
                            <div class="product" style="padding:25px; text-align:center; border-radius: 6px; background: #f0f9ff; border: 1px solid #bae6fd; border-top: 3px solid #0284c7;">
                                <h3 style="margin: 0; font-size: 20px; color: #0284c7;">Rp {{ number_format($totalOwnerIncome, 0, ',', '.') }}</h3>
                                <p style="margin: 5px 0 0 0; font-weight: bold; color: #0369a1;">Pendapatan Pemilik Alat</p>
                            </div>
                        </div>
                    </div>

                    <br>

                    <h4 style="margin-bottom: 15px; color: #374151;">Aktivitas Penyewaan</h4>
                    <div class="row">
                        <div class="col-md-3" style="margin-bottom: 15px;">
                            <div class="product" style="padding:15px; text-align:center; border-radius: 6px;">
                                <h3 style="margin: 0; color: #111827;">{{ $totalBookings }}</h3>
                                <p style="margin: 5px 0 0 0; font-size: 12px; color: #6b7280;">Jumlah Booking</p>
                            </div>
                        </div>
                        <div class="col-md-3" style="margin-bottom: 15px;">
                            <div class="product" style="padding:15px; text-align:center; border-radius: 6px;">
                                <h3 style="margin: 0; color: #eab308;">{{ $totalActive }}</h3>
                                <p style="margin: 5px 0 0 0; font-size: 12px; color: #eab308;">Sewa Aktif</p>
                            </div>
                        </div>
                        <div class="col-md-3" style="margin-bottom: 15px;">
                            <div class="product" style="padding:15px; text-align:center; border-radius: 6px;">
                                <h3 style="margin: 0; color: #16a34a;">{{ $totalCompleted }}</h3>
                                <p style="margin: 5px 0 0 0; font-size: 12px; color: #16a34a;">Sewa Selesai</p>
                            </div>
                        </div>
                        <div class="col-md-3" style="margin-bottom: 15px;">
                            <div class="product" style="padding:15px; text-align:center; border-radius: 6px;">
                                <h4 style="margin: 0; font-size: 16px; color: #dc2626; padding-top: 4px;">Rp {{ number_format($totalLateFee, 0, ',', '.') }}</h4>
                                <p style="margin: 8px 0 0 0; font-size: 12px; color: #dc2626;">Total Denda</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection