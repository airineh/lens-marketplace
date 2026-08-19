<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Equipment;
use App\Models\Verification;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {

            $startDate = request('start_date');
            $endDate = request('end_date');

            $bookingQuery = Booking::query();

            // Filter tanggal mulai
            if ($startDate) {
                $bookingQuery->whereDate('created_at', '>=', $startDate);
            }

            // Filter tanggal selesai
            if ($endDate) {
                $bookingQuery->whereDate('created_at', '<=', $endDate);
            }

            // Jumlah verifikasi yang masih pending
            $pendingVerifications = Verification::where(
                'status',
                'pending'
            )->count();

            // Total seluruh booking sesuai periode
            $totalTransactions = (clone $bookingQuery)->count();

            // Total seluruh alat
            $totalEquipments = Equipment::count();

            // Nilai transaksi yang sudah berjalan / selesai
            $totalTransactionValue = (clone $bookingQuery)
                ->whereIn('status', ['active', 'completed'])
                ->sum('total_price');

            // Total komisi Lens
            $totalCommission = (clone $bookingQuery)
                ->whereIn('status', ['active', 'completed'])
                ->sum('commission_amount');

            // Total pendapatan pemilik
            $totalOwnerIncome = (clone $bookingQuery)
                ->whereIn('status', ['active', 'completed'])
                ->sum('owner_income');

            // Total denda dari transaksi yang selesai
            $totalLateFee = (clone $bookingQuery)
                ->where('status', 'completed')
                ->sum('late_fee');

            return view('admin.dashboard', compact(
                'pendingVerifications',
                'totalTransactions',
                'totalEquipments',
                'totalTransactionValue',
                'totalCommission',
                'totalOwnerIncome',
                'totalLateFee',
                'startDate',
                'endDate'
            ));
        }


        /*
        |--------------------------------------------------------------------------
        | PEMILIK ALAT
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'pemilik_alat') {

            $ownerBookingQuery = Booking::whereHas(
                'equipment',
                function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                }
            );

            // Total alat milik pemilik
            $totalEquipments = Equipment::where(
                'user_id',
                $user->id
            )->count();

            // Booking yang masih menunggu persetujuan
            $pendingBookings = (clone $ownerBookingQuery)
                ->where('status', 'pending')
                ->count();

            // Jumlah transaksi aktif / selesai
            $totalTransactionCount = (clone $ownerBookingQuery)
                ->whereIn('status', ['active', 'completed'])
                ->count();

            // Nilai transaksi
            $totalTransactionValue = (clone $ownerBookingQuery)
                ->whereIn('status', ['active', 'completed'])
                ->sum('total_price');

            // Komisi Lens
            $totalCommission = (clone $ownerBookingQuery)
                ->whereIn('status', ['active', 'completed'])
                ->sum('commission_amount');

            // Pendapatan bersih pemilik
            $totalOwnerIncome = (clone $ownerBookingQuery)
                ->whereIn('status', ['active', 'completed'])
                ->sum('owner_income');

            // Status verifikasi pemilik
            $verificationStatus = $user->verification_status ?? 'unverified';

            return view('pemilik.dashboard', compact(
                'totalEquipments',
                'pendingBookings',
                'verificationStatus',
                'totalTransactionCount',
                'totalTransactionValue',
                'totalCommission',
                'totalOwnerIncome'
            ));
        }


        /*
        |--------------------------------------------------------------------------
        | PENYEWA
        |--------------------------------------------------------------------------
        */

        $activeOrders = Booking::where(
            'user_id',
            $user->id
        )
            ->where('status', 'active')
            ->count();

        $waitingPayments = Booking::where(
            'user_id',
            $user->id
        )
            ->where('status', 'approved')
            ->count();

        $verificationStatus = $user->verification_status ?? 'unverified';

        return view('penyewa.dashboard', compact(
            'activeOrders',
            'waitingPayments',
            'verificationStatus'
        ));
    }
}