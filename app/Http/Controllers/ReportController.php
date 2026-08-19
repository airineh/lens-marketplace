<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Equipment;
use App\Models\Booking;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;


class ReportController extends Controller
{
    

public function index(Request $request)
{
    // 1. Tangkap input tanggal dari form filter
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // 2. Data default bawaan (Total Keseluruhan dari awal waktu)
    $totalUsers = User::count();
    $totalPenyewa = User::where('role', 'penyewa')->count();
    $totalPemilik = User::where('role', 'pemilik_alat')->count();
    $totalEquipments = Equipment::count();
    
    // 3. Logika Filter Khusus Data Transaksi (di-filter jika admin input tanggal)
    $bookingQuery = Booking::query();

    if ($startDate && $endDate) {
        // Konversi format tanggal agar aman dicari di database
        $start = \Carbon\Carbon::parse($startDate)->startOfDay();
        $end = \Carbon\Carbon::parse($endDate)->endOfDay();
        
        $bookingQuery->whereBetween('created_at', [$start, $end]);
    }

    // 4. Kalkulasi metrik dashboard admin berdasarkan query filter
    $totalBookings = $bookingQuery->count();
    
    // Menghitung status lunas berdasarkan data ter-filter
    $totalPaid = Payment::where('payment_status', 'paid')
        ->whereIn('booking_id', (clone $bookingQuery)->pluck('id'))
        ->count();

   // Sum data finansial (hanya sewa yang approved, active, atau completed)
    $filteredQuery = (clone $bookingQuery)->whereIn('status', ['approved', 'active', 'completed']);
    
    $totalRevenue = $filteredQuery->sum('total_price');
    $totalPlatformFee = $filteredQuery->sum('commission_amount');
    $totalOwnerIncome = $filteredQuery->sum('owner_income');
    $totalLateFee = (clone $bookingQuery)->sum('late_fee');
    
    $totalCompleted = (clone $bookingQuery)->where('status', 'completed')->count();
    $totalActive = (clone $bookingQuery)->where('status', 'active')->count();

    return view('admin.reports', compact(
        'totalUsers', 'totalPenyewa', 'totalPemilik', 'totalEquipments',
        'totalBookings', 'totalPaid', 'totalRevenue', 'totalLateFee',
        'totalCompleted', 'totalActive', 'totalPlatformFee', 'totalOwnerIncome',
        'startDate', 'endDate' // Kirim balik tanggal agar form tidak reset setelah klik filter
    ));
}

public function export()
{
    $fileName = 'laporan_transaksi_platform_lens_' . date('Y-m-d_H-i') . '.csv';

    // Ambil data transaksi yang sah (Approved, Active, Completed) untuk laporan finansial
    $bookings = Booking::with('user', 'equipment.user', 'payment')
        ->whereIn('status', ['approved', 'active', 'completed'])
        ->latest()
        ->get();

    $headers = [
        "Content-Type" => "text/csv; charset=UTF-8",
        "Content-Disposition" => "attachment; filename=$fileName",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    ];

    $callback = function () use ($bookings) {
        $file = fopen('php://output', 'w');
        
        // 1. Tambahkan BOM (Byte Order Mark) agar Excel otomatis membaca karakter UTF-8 dengan rapi
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

        // 2. Header Kolom Laporan Rapi ala E-Commerce (Gunakan pemisah ';')
        $columns = [
            'ID Transaksi',
            'Tanggal Transaksi',
            'Nama Penyewa',
            'Nama Pemilik Alat',
            'Nama Peralatan',
            'Total Nilai Sewa (Bruto)',
            'Potongan Komisi LENS',
            'Pendapatan Bersih Pemilik',
            'Biaya Denda Keterlambatan',
            'Status Transaksi',
            'Status Pembayaran'
        ];
        
        // Gabungkan dengan pemisah titik koma (;) agar otomatis pecah kolom di Excel Indonesia
        fwrite($file, implode(';', $columns) . "\n");

        // Variabel penampung total akumulasi di bagian bawah laporan
        $grandTotalGross = 0;
        $grandTotalCommission = 0;
        $grandTotalOwner = 0;
        $grandTotalLateFee = 0;

        // 3. Looping Baris Data Transaksi
        foreach ($bookings as $booking) {
            $gross = $booking->total_price ?? 0;
            $commission = $booking->platform_fee ?? 0; // Mengambil dari field platform_fee
            $ownerNet = $booking->owner_income ?? 0;   // Mengambil dari field owner_income
            $lateFee = $booking->late_fee ?? 0;

            // Tambahkan ke total akumulasi rekapitulasi
            $grandTotalGross += $gross;
            $grandTotalCommission += $commission;
            $grandTotalOwner += $ownerNet;
            $grandTotalLateFee += $lateFee;

            $row = [
                'TRX-' . str_pad($booking->id, 5, '0', STR_PAD_LEFT),
                date('d-m-Y H:i', strtotime($booking->created_at)),
                $booking->user->name ?? '-',
                $booking->equipment->user->name ?? '-',
                $booking->equipment->name ?? '-',
                $gross,
                $commission,
                $ownerNet,
                $lateFee,
                strtoupper($booking->status),
                strtoupper($booking->payment->payment_status ?? 'UNPAID')
            ];

            fwrite($file, implode(';', $row) . "\n");
        }

        // 4. Tambahkan Baris Kosong sebagai Pemisah Visual sebelum baris total
        fwrite($file, ";;;;;;;;;\n");

        // 5. REVISI UTAMA: BARIS TOTAL REKAPITULASI FINANSIAL PLATFORM
        $summaryRow = [
            'TOTAL REKAPITULASI',
            '',
            '',
            '',
            '',
            $grandTotalGross,
            $grandTotalCommission, // <--- Ini komisi platform LENS terkumpul, langsung terlihat jelas nominalnya!
            $grandTotalOwner,
            $grandTotalLateFee,
            '',
            ''
        ];

        fwrite($file, implode(';', $summaryRow) . "\n");
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

    public function exportPdf()
{
    $totalUsers = User::count();
    $totalPenyewa = User::where('role', 'penyewa')->count();
    $totalPemilik = User::where('role', 'pemilik_alat')->count();
    $totalEquipments = Equipment::count();
    $totalBookings = Booking::count();
    $totalRevenue = Booking::sum('total_price');
    $totalLateFee = Booking::sum('late_fee');
    // Mengambil semua komisi dari booking yang disetujui, aktif, maupun selesai
    $totalPlatformFee = Booking::whereIn('status', ['approved', 'active', 'completed'])->sum('platform_fee');

    $pdf = Pdf::loadView(
        'admin.report-pdf',
        compact(
            'totalUsers',
            'totalPenyewa',
            'totalPemilik',
            'totalEquipments',
            'totalBookings',
            'totalRevenue',
            'totalLateFee',
            'totalPlatformFee'
        )
    );

    return $pdf->download('laporan-lens.pdf');
}
}