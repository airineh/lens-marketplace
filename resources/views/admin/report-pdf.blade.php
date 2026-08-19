<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi Platform LENS</title>
    <style>
        body { font-family: sans-serif; color: #333; line-height: 1.5; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h2 { margin: 0; padding: 0; text-transform: uppercase; }
        .header p { margin: 5px 0 0 0; color: #666; }
        .meta-info { margin-bottom: 20px; width: 100%; }
        .meta-info td { padding: 3px 0; }
        
        /* Style Tabel */
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; page-break-inside: auto; }
        tr { page-break-inside: avoid; page-break-after: auto; }
        th { background-color: #f3f4f6; color: #1f2937; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        th, td { border: 1px solid #d1d5db; padding: 8px; text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        /* Ringkasan Box */
        .summary-box { background-color: #f0fdf4; border: 1px solid #bbf7d0; padding: 15px; border-radius: 4px; margin-bottom: 25px; }
        .summary-title { font-weight: bold; color: #15803d; margin-top: 0; margin-bottom: 10px; font-size: 13px; }
        .summary-table { width: 100%; border: none; margin-bottom: 0; }
        .summary-table td { border: none; padding: 4px 0; font-size: 12px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Aktivitas Manajemen & Transaksi</h2>
        <h2>Platform LENS Photography Marketplace</h2>
        <p>Dicetak pada: {{ date('d-m-Y H:i') }} | Status Sistem: Terverifikasi</p>
    </div>

    <!-- 1. RINGKASAN EKOSISTEM GLOBAL -->
    <table style="margin-bottom: 25px;">
        <thead>
            <tr>
                <th class="text-center">Total Pengguna</th>
                <th class="text-center">Total Penyewa</th>
                <th class="text-center">Total Pemilik</th>
                <th class="text-center">Total Alat Tersedia</th>
                <th class="text-center">Volume Booking</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">{{ $totalUsers }}</td>
                <td class="text-center">{{ $totalPenyewa }}</td>
                <td class="text-center">{{ $totalPemilik }}</td>
                <td class="text-center">{{ $totalEquipments }}</td>
                <td class="text-center">{{ $totalBookings }}</td>
            </tr>
        </tbody>
    </table>

    <!-- 2. REKAPITULASI FINANSIAL PLATFORM (REVISI UTAMA DOSPEM) -->
    <div class="summary-box">
        <div class="summary-title">Rekapitualisasi Profitabilitas Platform</div>
        <table class="summary-table">
            <tr>
                <td width="40%">Total Nilai Transaksi Sirkulasi (Bruto)</td>
                <td width="5%">:</td>
                <td class="text-right"><strong>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td style="color: #dc2626;">Total Denda Keterlambatan Terpajang</td>
                <td>:</td>
                <td class="text-right" style="color: #dc2626;">Rp {{ number_format($totalLateFee, 0, ',', '.') }}</td>
            </tr>
            <tr style="font-size: 14px; color: #16a34a;">
                <td><strong>Total Pendapatan Bersih Komisi LENS</strong></td>
                <td><strong>:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalPlatformFee, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>

    <!-- 3. RINCIAN RIWAYAT TRANSAKSI SECARA DETAIL -->
   <!-- 3. RINCIAN RIWAYAT TRANSAKSI SECARA DETAIL -->
    <h4 style="margin-top: 30px; margin-bottom: 10px; text-transform: uppercase; color: #374151;">Rincian Log Transaksi Komersial</h4>
    <table>
        <thead>
            <tr>
                <th class="text-center" width="8%">ID</th>
                <th width="15%">Tanggal Sewa</th> <!-- TAMBAHAN BARU -->
                <th>Penyewa</th>
                <th>Pemilik Alat</th>
                <th>Alat Fotografi</th>
                <th class="text-right">Total Sewa</th>
                <th class="text-right">Komisi (10%)</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                // Ambil data transaksi langsung di view agar dinamis mengikuti data controller
                $bookingsData = \App\Models\Booking::with('user', 'equipment.user')
                    ->whereIn('status', ['approved', 'active', 'completed'])
                    ->latest()
                    ->get();
            @endphp
            @forelse($bookingsData as $booking)
            <tr>
                <td class="text-center">TRX-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                
                <!-- TAMBAHAN BARU: Menampilkan Tanggal Mulai s/d Selesai Sewa -->
                <td>
                    {{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y') }} - 
                    {{ \Carbon\Carbon::parse($booking->end_time)->format('d/m/Y') }}
                </td>

                <td>{{ $booking->user->name ?? '-' }}</td>
                <td>{{ $booking->equipment->user->name ?? '-' }}</td>
                <td>{{ $booking->equipment->name ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                <td class="text-right" style="color: #16a34a;">Rp {{ number_format($booking->commission_amount ?? 0, 0, ',', '.') }}</td>
                <td class="text-center" style="font-size: 9px;"><strong>{{ strtoupper($booking->status) }}</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Belum ada data transaksi komersial yang sah pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 40px; padding: 10px; background-color: #f9fafb; border-left: 3px solid #6b7280; font-size: 10px; color: #4b5563;">
        <strong>Catatan Kebijakan Finansial Platform LENS:</strong><br>
        1. Nilai Transaksi Bersih Komisi LENS dihitung secara otomatis berdasarkan persentase potongan biaya sewa pokok awal (Booking Fee).<br>
        2. Akumulasi Denda Keterlambatan yang tertera pada laporan ini diselesaikan secara langsung (Direct Payment) di lapangan antara pihak Penyewa dan Pemilik Alat sebagai bentuk ganti rugi operasional instan, sehingga tidak memengaruhi pendapatan bersih platform.
    </div>
    
</body>
</html>