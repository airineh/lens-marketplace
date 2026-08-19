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

                    <h2>Dashboard Admin</h2>

                    <p>
                        Selamat datang di halaman administrasi Lens.
                    </p>

                    <hr>


                    <!-- ================================================= -->
                    <!-- FILTER PERIODE -->
                    <!-- ================================================= -->

                    <h4>Filter Periode Transaksi</h4>

                    <form method="GET" action="{{ route('dashboard') }}">

                        <div class="row">

                            <div class="col-md-4">

                                <label>
                                    <strong>Periode Mulai</strong>
                                </label>

                                <input
                                    type="date"
                                    name="start_date"
                                    class="form-control"
                                    value="{{ $startDate }}"
                                >

                            </div>


                            <div class="col-md-4">

                                <label>
                                    <strong>Periode Selesai</strong>
                                </label>

                                <input
                                    type="date"
                                    name="end_date"
                                    class="form-control"
                                    value="{{ $endDate }}"
                                >

                            </div>


                            <div
                                class="col-md-4"
                                style="padding-top:25px;"
                            >

                                <button
                                    type="submit"
                                    class="primary-btn"
                                >
                                    Filter
                                </button>

                                <a
                                    href="{{ route('dashboard') }}"
                                    class="btn btn-default"
                                >
                                    Reset
                                </a>

                            </div>

                        </div>

                    </form>


                    <!-- INFO PERIODE -->
                    @if($startDate || $endDate)

                        <div
                            class="alert alert-info"
                            style="margin-top:20px;"
                        >

                            <strong>Periode yang dipilih:</strong>

                            {{ $startDate
                                ? \Carbon\Carbon::parse($startDate)->format('d/m/Y')
                                : 'Semua'
                            }}

                            s/d

                            {{ $endDate
                                ? \Carbon\Carbon::parse($endDate)->format('d/m/Y')
                                : 'Sekarang'
                            }}

                        </div>

                    @endif


                    <hr>


                    <!-- ================================================= -->
                    <!-- RINGKASAN SISTEM -->
                    <!-- ================================================= -->

                    <h4>Ringkasan Sistem</h4>

                    <div class="row">

                        <!-- VERIFIKASI -->
                        <div class="col-md-4">

                            <a
                                href="{{ route('admin.verifications') }}"
                                style="text-decoration:none;color:inherit;"
                            >

                                <div
                                    class="product"
                                    style="padding:20px;text-align:center;"
                                >

                                    <h3>
                                        {{ $pendingVerifications }}
                                    </h3>

                                    <p>
                                        Verifikasi Pending
                                    </p>

                                </div>

                            </a>

                        </div>


                        <!-- TRANSAKSI -->
                        <div class="col-md-4">

                            <a
                                href="{{ route('admin.transactions') }}"
                                style="text-decoration:none;color:inherit;"
                            >

                                <div
                                    class="product"
                                    style="padding:20px;text-align:center;"
                                >

                                    <h3>
                                        {{ $totalTransactions }}
                                    </h3>

                                    <p>
                                        Total Transaksi
                                    </p>

                                </div>

                            </a>

                        </div>


                        <!-- ALAT -->
                        <div class="col-md-4">

                            <a
                                href="{{ route('admin.reports') }}"
                                style="text-decoration:none;color:inherit;"
                            >

                                <div
                                    class="product"
                                    style="padding:20px;text-align:center;"
                                >

                                    <h3>
                                        {{ $totalEquipments }}
                                    </h3>

                                    <p>
                                        Total Alat
                                    </p>

                                </div>

                            </a>

                        </div>

                    </div>


                    <br>


                    <!-- ================================================= -->
                    <!-- RINGKASAN KEUANGAN -->
                    <!-- ================================================= -->

                    <h4>Ringkasan Transaksi & Komisi</h4>

                    <div class="row">

                        <!-- NILAI TRANSAKSI -->
                        <div class="col-md-4">

                            <div
                                class="product"
                                style="padding:20px;text-align:center;"
                            >

                                <h3>
                                    Rp {{ number_format(
                                        $totalTransactionValue,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </h3>

                                <p>
                                    Nilai Transaksi
                                </p>

                            </div>

                        </div>


                        <!-- KOMISI -->
                        <div class="col-md-4">

                            <div
                                class="product"
                                style="
                                    padding:20px;
                                    text-align:center;
                                    background:#fef3c7;
                                "
                            >

                                <h3>
                                    Rp {{ number_format(
                                        $totalCommission,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </h3>

                                <p>
                                    <strong>Komisi Lens</strong>
                                </p>

                            </div>

                        </div>


                        <!-- PENDAPATAN PEMILIK -->
                        <div class="col-md-4">

                            <div
                                class="product"
                                style="
                                    padding:20px;
                                    text-align:center;
                                    background:#dcfce7;
                                "
                            >

                                <h3>
                                    Rp {{ number_format(
                                        $totalOwnerIncome,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </h3>

                                <p>
                                    Pendapatan Pemilik
                                </p>

                            </div>

                        </div>

                    </div>


                    <br>


                    <!-- ================================================= -->
                    <!-- DENDA -->
                    <!-- ================================================= -->

                    <h4>Monitoring Denda</h4>

                    <div class="row">

                        <div class="col-md-4">

                            <div
                                class="product"
                                style="padding:20px;text-align:center;"
                            >

                                <h3>
                                    Rp {{ number_format(
                                        $totalLateFee,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </h3>

                                <p>
                                    Total Denda
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection