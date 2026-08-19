@extends('layouts.lens')

@section('content')
<div class="section">
    <div class="container">
        <div class="row">

            <!-- Sidebar (Disembunyikan saat cetak) -->
            <div class="col-md-3 no-print">
                @include('partials.sidebar')
            </div>

            <!-- Konten Utama -->
            <div class="col-md-9 print-full-width">
                <div class="product" style="padding: 30px; background: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    
                    <!-- Header Interaktif Web -->
                    <div class="no-print" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div>
                            <h2 style="margin: 0; font-weight: 700; color: #1e293b;">Riwayat Transaksi & Laporan</h2>
                            <p style="margin: 4px 0 0; color: #64748b; font-size: 13px;">Kelola riwayat penyewaan dan cetak laporan keuangan berkala.</p>
                        </div>
                        <div>
                            <button onclick="window.print()" class="btn btn-primary" style="background: #8B1E2D; border: none; font-weight: 600; padding: 9px 18px; border-radius: 6px; cursor: pointer; color: #fff;">
                                <i class="fa fa-print"></i> Cetak Dokumen Laporan
                            </button>
                        </div>
                    </div>

                    <!-- KOP SURAT FORMAL BISNIS (Hanya Muncul Saat Print / PDF) -->
                    <div class="print-only">
                        <div style="display: flex; justify-content: space-between; align-items: flex-end; border-bottom: 2px solid #8B1E2D; padding-bottom: 12px; margin-bottom: 15px;">
                            <div>
                                <h1 style="margin: 0; font-size: 26px; font-weight: 800; color: #8B1E2D; letter-spacing: -0.5px;">LENS.</h1>
                                <p style="margin: 2px 0 0; font-size: 11px; color: #475569;">Marketplace & Sistem Manajemen Penyewaan Peralatan Fotografi</p>
                                <p style="margin: 1px 0 0; font-size: 10px; color: #64748b;">Gandaria, Jakarta Selatan | lens@gmail.com | +62 851 5521 2362</p>
                            </div>
                            <div style="text-align: right;">
                                <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #0f172a; text-transform: uppercase;">Laporan Mutasi Pendapatan Mitra</h3>
                                <p style="margin: 2px 0 0; font-size: 11px; color: #475569;">Dokumen Ref: <strong>#REP-OWNER-{{ auth()->id() }}-{{ date('Ymd') }}</strong></p>
                                <p style="margin: 1px 0 0; font-size: 10px; color: #64748b;">Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB</p>
                            </div>
                        </div>

                        <!-- Info Pemilik & Periode Laporan -->
                        <table style="width: 100%; font-size: 11px; margin-bottom: 15px; border-collapse: collapse;">
                            <tr>
                                <td style="width: 18%; font-weight: 600; color: #475569; padding: 2px 0;">Nama Pemilik Alat</td>
                                <td style="width: 2%;">:</td>
                                <td style="width: 35%; font-weight: 700; color: #0f172a;">{{ auth()->user()->name }}</td>
                                <td style="width: 15%; font-weight: 600; color: #475569; padding: 2px 0;">Periode Laporan</td>
                                <td style="width: 2%;">:</td>
                                <td style="width: 28%; font-weight: 700; color: #0f172a;">
                                    @if(request('period') == 'today')
                                        Hari Ini ({{ date('d/m/Y') }})
                                    @elseif(request('period') == 'this_week')
                                        Minggu Ini
                                    @elseif(request('period') == 'this_month')
                                        Bulan {{ date('F Y') }}
                                    @elseif(request('start_date') && request('end_date'))
                                        {{ request('start_date') }} s/d {{ request('end_date') }}
                                    @else
                                        Semua Periode Transaksi
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600; color: #475569; padding: 2px 0;">Email Terdaftar</td>
                                <td>:</td>
                                <td style="color: #0f172a;">{{ auth()->user()->email }}</td>
                                <td style="font-weight: 600; color: #475569; padding: 2px 0;">Status Akun</td>
                                <td>:</td>
                                <td style="color: #16a34a; font-weight: 700;">Terverifikasi (Verified Partner)</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Ringkasan Eksekutif Finansial -->
                    <div class="summary-cards" style="margin-bottom: 20px;">
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 6px; padding: 12px; text-align: center;">
                                    <span style="font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 600; display: block;">Total Nilai Transaksi</span>
                                    <strong style="color: #0f172a; font-size: 16px;">Rp {{ number_format($totalGross, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-4">
                                <div style="background: #fefce8; border: 1px solid #fef08a; border-radius: 6px; padding: 12px; text-align: center;">
                                    <span style="font-size: 11px; color: #a16207; text-transform: uppercase; font-weight: 600; display: block;">Potongan Komisi LENS</span>
                                    <strong style="color: #ca8a04; font-size: 16px;">Rp {{ number_format($totalCommission, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-4">
                                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 6px; padding: 12px; text-align: center;">
                                    <span style="font-size: 11px; color: #15803d; text-transform: uppercase; font-weight: 600; display: block;">Pendapatan Bersih (Net)</span>
                                    <strong style="color: #16a34a; font-size: 16px;">Rp {{ number_format($totalNetIncome, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Interaktif Web -->
                    <form method="GET" action="{{ url('/riwayat-transaksi') }}" class="no-print" style="background: #f8fafc; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 25px;">
                        <div class="row">
                            <div class="col-md-3 col-xs-6" style="margin-bottom: 10px;">
                                <label style="font-size: 12px; color: #475569;">Periode Cepat</label>
                                <select name="period" class="form-control" onchange="this.form.submit()" style="height: 38px; font-size: 13px;">
                                    <option value="">-- Semua Waktu --</option>
                                    <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                                    <option value="this_week" {{ request('period') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                                    <option value="this_month" {{ request('period') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-xs-6" style="margin-bottom: 10px;">
                                <label style="font-size: 12px; color: #475569;">Tanggal Awal</label>
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" style="height: 38px; font-size: 13px;">
                            </div>
                            <div class="col-md-3 col-xs-6" style="margin-bottom: 10px;">
                                <label style="font-size: 12px; color: #475569;">Tanggal Akhir</label>
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" style="height: 38px; font-size: 13px;">
                            </div>
                            <div class="col-md-3 col-xs-6" style="margin-bottom: 10px; display: flex; align-items: flex-end;">
                                <button type="submit" class="btn btn-block" style="background: #8B1E2D; color: #fff; height: 38px; font-weight: 600;">
                                    Terapkan Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- TABEL FORMAL BISNIS LAPORAN -->
                    <div class="table-responsive">
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th style="width: 5%; text-align: center;">No</th>
                                    <th style="width: 14%;">No. Invoice</th>
                                    <th style="width: 16%;">Penyewa</th>
                                    <th style="width: 18%;">Unit Alat</th>
                                    <th style="width: 15%;">Jadwal Sewa</th>
                                    <th style="width: 11%; text-align: right;">Total Sewa</th>
                                    <th style="width: 9%; text-align: right;">Komisi</th>
                                    <th style="width: 12%; text-align: right;">Pendapatan Bersih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $index => $booking)
                                    <tr>
                                        <td style="text-align: center;">{{ $index + 1 }}</td>
                                        <td><strong>#INV-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                                        <td>{{ $booking->user->name ?? '-' }}</td>
                                        <td>{{ $booking->equipment->name ?? '-' }}</td>
                                        <td>
                                            <span style="font-size: 11px;">{{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/y H:i') }}</span><br>
                                            <span style="font-size: 10px; color: #64748b;">s/d {{ \Carbon\Carbon::parse($booking->end_time)->format('d/m/y H:i') }}</span>
                                        </td>
                                        <td style="text-align: right;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                        <td style="text-align: right; color: #ca8a04;">Rp {{ number_format($booking->commission_amount ?? 0, 0, ',', '.') }}</td>
                                        <td style="text-align: right; font-weight: 700; color: #16a34a;">Rp {{ number_format($booking->owner_income ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" style="text-align: center; padding: 25px; color: #94a3b8;">Tidak ada catatan transaksi pada periode yang dipilih.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr style="background: #f8fafc; font-weight: 700; border-top: 2px solid #334155;">
                                    <td colspan="5" style="text-align: right; padding: 8px 10px; text-transform: uppercase;">Total Akumulasi:</td>
                                    <td style="text-align: right; padding: 8px 10px;">Rp {{ number_format($totalGross, 0, ',', '.') }}</td>
                                    <td style="text-align: right; padding: 8px 10px; color: #ca8a04;">Rp {{ number_format($totalCommission, 0, ',', '.') }}</td>
                                    <td style="text-align: right; padding: 8px 10px; color: #16a34a;">Rp {{ number_format($totalNetIncome, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- LEMBAR PENGESAHAN & TANDA TANGAN (Hanya Muncul Saat Print / PDF) -->
                    <div class="print-only" style="margin-top: 30px;">
                        <table style="width: 100%; border: none; font-size: 11px;">
                            <tr>
                                <td style="width: 50%; vertical-align: top; border: none;">
                                    <p style="margin: 0; color: #64748b; font-size: 10px;">Catatan Finansial:</p>
                                    <p style="margin: 2px 0 0; color: #475569; font-size: 10px;">
                                        1. Laporan ini merupakan rekapitulasi mutasi sah yang tercatat di basis data platform LENS.<br>
                                        2. Pendapatan bersih dihitung setelah pemotongan komisi platform secara dinamis.
                                    </p>
                                </td>
                                <td style="width: 20%; border: none;"></td>
                                <td style="width: 30%; text-align: center; vertical-align: top; border: none;">
                                    <p style="margin: 0; color: #475569;">Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                                    <p style="margin: 2px 0 0; font-weight: 600; color: #1e293b;">Pemilik Peralatan,</p>
                                    <div style="height: 50px;"></div>
                                    <p style="margin: 0; font-weight: 700; text-decoration: underline; color: #0f172a;">{{ auth()->user()->name }}</p>
                                    <p style="margin: 1px 0 0; color: #64748b; font-size: 10px;">ID Partner: #USR-{{ auth()->id() }}</p>
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* CSS Tampilan Web Standar */
.print-only {
    display: none;
}
.report-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.report-table th {
    background-color: #f1f5f9;
    color: #334155;
    padding: 10px 12px;
    border: 1px solid #cbd5e1;
    font-weight: 700;
}
.report-table td {
    padding: 9px 12px;
    border: 1px solid #e2e8f0;
    color: #1e293b;
}

/* FORMAT CETAK DOKUMEN RESMI (PRINT / PDF) */
@media print {
    @page {
        size: A4 portrait;
        margin: 1.5cm 1.2cm 1.5cm 1.2cm;
    }
    .no-print, header, footer, #header, #top-header, #navigation, .sidebar {
        display: none !important;
    }
    .print-only {
        display: block !important;
    }
    .print-full-width {
        width: 100% !important;
        float: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .product {
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    body {
        background: #ffffff !important;
        color: #000000 !important;
        font-size: 11pt !important;
    }
    .report-table {
        font-size: 9.5pt !important;
    }
    .report-table th {
        background-color: #e2e8f0 !important;
        -webkit-print-color-adjust: exact;
        border: 1px solid #64748b !important;
        padding: 6px 8px !important;
    }
    .report-table td {
        border: 1px solid #94a3b8 !important;
        padding: 6px 8px !important;
    }
    .summary-cards {
        display: none !important; /* Digantikan oleh tabel akumulasi di bawah */
    }
}
</style>
@endsection