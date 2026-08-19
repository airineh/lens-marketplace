@extends('layouts.lens')

@section('content')
<div class="section">
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                @include('partials.sidebar')
            </div>

            <div class="col-md-9">
                <div class="product" style="padding:30px; border-radius: 8px;">
                    <h2>Upload Pembayaran</h2>
                    <p style="color: #6b7280;">Silakan transfer sesuai nominal pembayaran ke rekening resmi Lens Marketplace, kemudian unggah bukti pembayaran untuk diverifikasi.</p>
                    <hr>

                    <div style="margin-bottom: 20px;">
                        <h4 style="margin: 0; color: #1f2937;">{{ $booking->equipment->name }}</h4>
                        <p style="margin: 5px 0 0 0; color: #4b5563;">Total Biaya Sewa: <strong style="color: #111827;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></p>
                    </div>

                    <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 6px; margin-bottom: 25px;">
                        <h4 style="margin-top: 0; margin-bottom: 15px; color: #1e293b;"><i class="fa fa-university"></i> Rekening Resmi Lens</h4>
                        
                        <p style="margin: 6px 0; font-size: 14px; color: #4b5563;">
                            Nama Bank: <strong style="color: #111827;">{{ $platform->bank_name ?? 'Bank Transfer' }}</strong>
                        </p>

                        <p style="margin: 6px 0; font-size: 14px; color: #4b5563;">
                            Nomor Rekening: <strong style="color: #0284c7; font-size: 16px;">{{ $platform->bank_account_number ?? '-' }}</strong>
                        </p>

                        <p style="margin: 6px 0; font-size: 14px; color: #4b5563;">
                            Atas Nama: <strong style="color: #111827;">{{ $platform->bank_account_name ?? '-' }}</strong>
                        </p>
                        
                        <hr style="border-top: 1px dashed #cbd5e1; margin: 12px 0;">
                        
                        <p style="margin: 0; font-size: 14px; color: #1e293b; font-weight: bold;">
                            Total Transfer: <span style="color: #dc2626; font-size: 18px;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </p>
                    </div>

                    <form action="{{ route('payment.store', $booking->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group" style="margin-bottom: 20px;">
                            <label style="font-weight: bold; color: #374151; margin-bottom: 8px; display: block;">File Bukti Pembayaran</label>
                            <input type="file" name="proof_payment" class="form-control" required style="padding: 6px 12px;">
                            <small style="color: #9ca3af; display: block; margin-top: 4px;">*Pastikan foto/screenshot bukti transfer terlihat jelas dan tidak buram.</small>
                        </div>

                        <div style="margin-top: 25px;">
                            <button type="submit" class="primary-btn" style="background-color: #4fc4ff; color: white; border: none; padding: 10px 20px; border-radius: 4px; font-weight: bold;">
                                <i class="fa fa-upload"></i> Upload Bukti Pembayaran
                            </button>
                            <a href="{{ route('booking.my') }}" class="primary-btn" style="background-color: #6b7280; color: white; padding: 10px 20px; border-radius: 4px; margin-left: 5px; text-decoration: none;">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection