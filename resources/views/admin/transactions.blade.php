@extends('layouts.lens')

@section('content')

<div class="section">
    <div class="container">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-md-3">
                @include('partials.sidebar')
            </div>

            <!-- CONTENT -->
            <div class="col-md-9">

                <div class="product" style="padding:30px;">

                    <h2>Monitoring Transaksi</h2>

                    <p>
                        Admin dapat memantau seluruh transaksi penyewaan
                        dan melakukan validasi pembayaran pada sistem.
                    </p>

                    <hr>

                    {{-- PESAN SUKSES --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- PESAN ERROR --}}
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif


                    <div class="table-responsive">

                        <table class="table table-bordered">

                            <thead>
                                <tr>
                                    <th>Penyewa</th>
                                    <th>Pemilik</th>
                                    <th>Alat</th>
                                    <th>Total</th>
                                    <th>Komisi</th>
                                    <th>Pendapatan Pemilik</th>
                                    <th>Denda</th>
                                    <th>Status Booking</th>
                                    <th>Status Pembayaran</th>
                                    <th>Dikembalikan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($bookings as $booking)

                                    <tr>

                                        {{-- PENYEWA --}}
                                        <td>
                                            {{ $booking->user->name }}
                                        </td>


                                        {{-- PEMILIK --}}
                                        <td>
                                            {{ $booking->equipment->user->name }}
                                        </td>


                                        {{-- ALAT --}}
                                        <td>
                                            {{ $booking->equipment->name }}
                                        </td>


                                        {{-- TOTAL TRANSAKSI --}}
                                        <td>
                                            Rp
                                            {{ number_format(
                                                $booking->total_price,
                                                0,
                                                ',',
                                                '.'
                                            ) }}
                                        </td>


                                        {{-- KOMISI LENS --}}
                                        <td>
                                            Rp
                                            {{ number_format(
                                                $booking->commission_amount ?? 0,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                            @if($booking->commission_percentage)
                                                <br>
                                                <small>
                                                    {{ $booking->commission_percentage }}%
                                                </small>
                                            @endif
                                        </td>


                                        {{-- PENDAPATAN PEMILIK --}}
                                        <td>
                                            Rp
                                            {{ number_format(
                                                $booking->owner_income ?? 0,
                                                0,
                                                ',',
                                                '.'
                                            ) }}
                                        </td>


                                        {{-- DENDA --}}
                                        <td>
                                            Rp
                                            {{ number_format(
                                                $booking->late_fee ?? 0,
                                                0,
                                                ',',
                                                '.'
                                            ) }}
                                        </td>


                                        {{-- STATUS BOOKING --}}
                                        <td>

                                            @if($booking->status == 'pending')

                                                <span class="label label-warning">
                                                    Pending
                                                </span>

                                            @elseif($booking->status == 'approved')

                                                <span class="label label-info">
                                                    Approved
                                                </span>

                                            @elseif($booking->status == 'active')

                                                <span class="label label-primary">
                                                    Active
                                                </span>

                                            @elseif($booking->status == 'completed')

                                                <span class="label label-success">
                                                    Completed
                                                </span>

                                            @elseif($booking->status == 'rejected')

                                                <span class="label label-danger">
                                                    Rejected
                                                </span>

                                            @else

                                                <span class="label label-default">
                                                    {{ ucfirst($booking->status) }}
                                                </span>

                                            @endif

                                        </td>


                                        {{-- STATUS PEMBAYARAN --}}
                                        <td>

                                            @if($booking->payment)

                                                @if($booking->payment->payment_status == 'pending')

                                                    <span class="label label-warning">
                                                        Pending
                                                    </span>

                                                @elseif($booking->payment->payment_status == 'paid')

                                                    <span class="label label-success">
                                                        Paid
                                                    </span>

                                                @elseif($booking->payment->payment_status == 'rejected')

                                                    <span class="label label-danger">
                                                        Rejected
                                                    </span>

                                                @endif

                                            @else

                                                <span class="label label-default">
                                                    Belum Bayar
                                                </span>

                                            @endif

                                        </td>


                                        {{-- DIKEMBALIKAN --}}
                                        <td>
                                            {{ $booking->returned_at ?? '-' }}
                                        </td>


                                        {{-- AKSI ADMIN --}}
                                        <td>

                                            @if(
                                                $booking->payment &&
                                                $booking->payment->payment_status == 'pending'
                                            )

                                                <form
                                                    action="{{ route(
                                                        'admin.payments.approve',
                                                        $booking->payment->id
                                                    ) }}"
                                                    method="POST"
                                                    style="margin-bottom:5px;"
                                                >

                                                    @csrf

                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        class="btn btn-success btn-sm"
                                                        onclick="return confirm(
                                                            'Validasi pembayaran ini sebagai LUNAS?'
                                                        )"
                                                    >
                                                        Validasi Lunas
                                                    </button>

                                                </form>


                                                <form
                                                    action="{{ route(
                                                        'admin.payments.reject',
                                                        $booking->payment->id
                                                    ) }}"
                                                    method="POST"
                                                >

                                                    @csrf

                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm(
                                                            'Tolak bukti pembayaran ini?'
                                                        )"
                                                    >
                                                        Tolak
                                                    </button>

                                                </form>

                                            @elseif(
                                                $booking->payment &&
                                                $booking->payment->payment_status == 'paid'
                                            )

                                                <span class="label label-success">
                                                    Pembayaran Lunas
                                                </span>

                                            @elseif(
                                                $booking->payment &&
                                                $booking->payment->payment_status == 'rejected'
                                            )

                                                <span class="label label-danger">
                                                    Pembayaran Ditolak
                                                </span>

                                            @else

                                                <span class="label label-default">
                                                    -
                                                </span>

                                            @endif

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="11" class="text-center">

                                            Belum ada transaksi.

                                        </td>

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

@endsection