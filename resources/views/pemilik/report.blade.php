@extends('layouts.lens')

@section('content')
<div class="section">
    <div class="container">
        <div class="row">

            <div class="col-md-3 no-print">
                @include('partials.sidebar')
            </div>

            <div class="col-md-9 print-full-width">
                <div class="product" style="padding:30px; background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div>
                            <h2 style="margin:0; font-weight: 700; color: #1e293b;">Laporan Transaksi Pemilik</h2>
                            <p style="margin: 4px 0 0; color: #64748b; font-size: 13px;">Rekapitulasi pendapatan dan aktivitas penyewaan alat fotografi Anda.</p>
                        </div>
                        <div class="no-print">
                            <button onclick="window.print()" class="btn btn-default" style="background: #8B1E2D; color: #fff; border: none; font-weight: 600; padding: 8px 16px; border-radius: 6px;">
                                <i class="fa fa-print"></i> Cetak Laporan
                            </button>
                        </div>
                    </div>

                    <hr style="margin-bottom: 25px;">

                    <!-- Ringkasan Statistik Finansial -->
                    <div class="row" style="margin-bottom: 25px;">
                        <div class="col-md-4 col-xs-12" style="margin-bottom: 15px;">
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px; text-align: center;">
                                <span style="font-size: 12px; color: #64748b; text-transform: uppercase; font-weight: 600;">Total Omset Sewa</span>
                                <h3 style="margin: 8px 0 0; color: #1e293b; font-size: 20px; font-weight: 700;">Rp {{ number_format($totalGross, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12" style="margin-bottom: 15px;">
                            <div style="background: #fefce8; border: 1px solid #fef08a; border-radius: 8px; padding: 18px; text-align: center;">
                                <span style="font-size: 12px; color: #a16207; text-transform: uppercase; font-weight: 600;">Potongan Komisi LENS</span>
                                <h3 style="margin: 8px 0 0; color: #ca8a04; font-size: 20px; font-weight: 700;">Rp {{ number_format($totalCommission, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12" style="margin-bottom: 15px;">
                            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 18px; text-align: center;">
                                <span style="font-size: 12px; color: #15803d; text-transform: uppercase; font-weight: 600;">Pendapatan Bersih</span>
                                <h3 style="margin: 8px 0 0; color: #16a34a; font-size: 20px; font-weight: 700;">Rp {{ number_format($totalNetIncome, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Riwayat Transaksi -->
                    <h4 style="font-size: 15px; font-weight: 700; color: #334155; margin-bottom: 15px;">Daftar Rincian Transaksi</h4>
                    <div class="table-responsive">
                        <table class="table" style="font-size: 13px;">
                            <thead>
                                <tr style="background: #f1f5f9; color: #475569;">
                                    <th>ID Booking</th>
                                    <th>Penyewa</th>
                                    <th>Alat</th>
                                    <th>Jadwal Sewa</th>
                                    <th>Total Biaya</th>
                                    <th>Komisi LENS</th>
                                    <th>Pendapatan Bersih</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $item)
                                    <tr>
                                        <td><strong>#INV-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                                        <td>{{ $item->user->name ?? '-' }}</td>
                                        <td>{{ $item->equipment->name ?? '-' }}</td>
                                        <td>
                                            <small>{{ \Carbon\Carbon::parse($item->start_time)->format('d/m/Y H:i') }}</small><br>
                                            <small style="color: #64748b;">s/d {{ \Carbon\Carbon::parse($item->end_time)->format('d/m/Y H:i') }}</small>
                                        </td>
                                        <td>Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                        <td style="color: #ca8a04;">Rp {{ number_format($item->commission_amount ?? 0, 0, ',', '.') }}</td>
                                        <td style="color: #16a34a; font-weight: 700;">Rp {{ number_format($item->owner_income ?? 0, 0, ',', '.') }}</td>
                                        <td>
                                            @if($item->status == 'completed')
                                                <span class="label label-success" style="background-color: #22c55e;">Selesai</span>
                                            @elseif($item->status == 'active')
                                                <span class="label label-primary" style="background-color: #3b82f6;">Aktif</span>
                                            @elseif($item->status == 'pending')
                                                <span class="label label-warning" style="background-color: #f59e0b;">Pending</span>
                                            @else
                                                <span class="label label-default">{{ ucfirst($item->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center" style="padding: 20px; color: #94a3b8;">Belum ada transaksi penyewaan alat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
@media print {
    .no-print, header, footer, #navigation, #header, #top-header {
        display: none !important;
    }
    .print-full-width {
        width: 100% !important;
        float: none !important;
        padding: 0 !important;
    }
    .product {
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
    }
    body {
        background: #fff !important;
    }
}
</style>
@endsection