<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #INV-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }} - LENS</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            background-color: #f8fafc;
            padding: 30px 15px;
            margin: 0;
        }
        .invoice-card {
            max-width: 750px;
            margin: 0 auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #8B1E2D;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        .brand {
            font-size: 28px;
            font-weight: 800;
            color: #8B1E2D;
            letter-spacing: -0.5px;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h2 {
            margin: 0;
            font-size: 20px;
            color: #1e293b;
        }
        .invoice-title p {
            margin: 2px 0 0;
            color: #64748b;
            font-size: 13px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
            font-size: 13px;
        }
        .info-box h4 {
            margin: 0 0 6px 0;
            color: #8B1E2D;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-size: 13px;
        }
        table th {
            background-color: #f1f5f9;
            color: #475569;
            text-align: left;
            padding: 10px 12px;
            border-bottom: 1px solid #cbd5e1;
        }
        table td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        .text-right {
            text-align: right;
        }
        .total-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }
        .total-table {
            width: 320px;
        }
        .total-table td {
            padding: 6px 12px;
            border: none;
        }
        .grand-total {
            font-size: 16px;
            font-weight: bold;
            color: #8B1E2D;
            border-top: 2px solid #e2e8f0 !important;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .badge-success { background: #dcfce7; color: #15803d; }
        .badge-warning { background: #fef9c3; color: #a16207; }
        .badge-primary { background: #dbeafe; color: #1d4ed8; }
        .actions {
            text-align: center;
            margin-top: 25px;
        }
        .btn-print {
            background: #8B1E2D;
            color: #ffffff;
            border: none;
            padding: 10px 24px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn-back {
            color: #64748b;
            text-decoration: none;
            margin-left: 15px;
            font-size: 14px;
        }
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .invoice-card {
                box-shadow: none;
                border: none;
                padding: 0;
                max-width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<div class="invoice-card">
    <div class="header">
        <div class="brand">LENS.</div>
        <div class="invoice-title">
            <h2>FAKTUR PENYEWAAN</h2>
            <p>No: #INV-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</p>
            <p>Tanggal: {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y H:i') }}</p>
        </div>
    </div>

   <div class="info-grid">
        <div class="info-box">
            <h4>Penyewa:</h4>
            <strong>{{ $booking->user->name }}</strong><br>
            Email: {{ $booking->user->email }}<br>
            No. HP: {{ $booking->user->phone ?? '-' }}<br>
            Alamat: {{ $booking->user->address ?? '-' }}
        </div>
        <div class="info-box">
            <h4>Pemilik Alat:</h4>
            <strong>{{ $booking->equipment->user->name }}</strong><br>
            Email: {{ $booking->equipment->user->email }}<br>
            No. HP: {{ $booking->equipment->user->phone ?? '-' }}<br>
            Alamat: {{ $booking->equipment->user->address ?? '-' }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Deskripsi Item</th>
                <th>Jadwal Sewa</th>
                <th class="text-right">Durasi</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>{{ $booking->equipment->name }}</strong><br>
                    <small style="color: #64748b;">Rp {{ number_format($booking->equipment->price_per_hour, 0, ',', '.') }} / jam</small>
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y H:i') }} <br>
                    s/d {{ \Carbon\Carbon::parse($booking->end_time)->format('d/m/Y H:i') }}
                </td>
                <td class="text-right">
                    {{ \Carbon\Carbon::parse($booking->start_time)->diffInHours(\Carbon\Carbon::parse($booking->end_time)) }} Jam
                </td>
                <td class="text-right">
                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="total-section">
        <table class="total-table">
            <tr>
                <td>Status Transaksi:</td>
                <td class="text-right">
                    @if($booking->status == 'completed')
                        <span class="badge badge-success">Selesai</span>
                    @elseif($booking->status == 'active')
                        <span class="badge badge-primary">Aktif</span>
                    @else
                        <span class="badge badge-warning">{{ ucfirst($booking->status) }}</span>
                    @endif
                </td>
            </tr>
            @if($booking->late_fee > 0)
                <tr>
                    <td>Denda Keterlambatan:</td>
                    <td class="text-right" style="color: red; font-weight: bold;">
                        Rp {{ number_format($booking->late_fee, 0, ',', '.') }}
                    </td>
                </tr>
            @endif
            <tr class="grand-total">
                <td>Total Pembayaran:</td>
                <td class="text-right">
                    Rp {{ number_format($booking->total_price + ($booking->late_fee ?? 0), 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

    <div style="font-size: 12px; color: #64748b; border-top: 1px solid #e2e8f0; padding-top: 15px;">
        <em>* Invoice ini diterbitkan otomatis oleh Sistem Informasi Manajemen LENS sebagai bukti transaksi yang sah.</em>
    </div>

    <div class="actions no-print">
        <button onclick="window.print()" class="btn-print">Cetak / Simpan PDF</button>
        <a href="{{ url('/pesanan-saya') }}" class="btn-back">Kembali ke Pesanan Saya</a>
    </div>
</div>

</body>
</html>