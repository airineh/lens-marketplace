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

                    <h2>Pengaturan Platform</h2>

                    <p>
                        Kelola komisi platform dan informasi rekening resmi Lens Marketplace.
                    </p>

                    <hr>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.platform.settings.update') }}" method="POST">

                        @csrf

                        <div class="form-group">
                            <label>Komisi Platform (%)</label>
                            <input
                                type="number"
                                step="0.01"
                                name="commission_percentage"
                                class="form-control"
                                value="{{ $setting->commission_percentage }}">
                        </div>

                        <div class="form-group">
                            <label>Nama Bank</label>
                            <input
                                type="text"
                                name="bank_name"
                                class="form-control"
                                value="{{ $setting->bank_name }}">
                        </div>

                        <div class="form-group">
                            <label>Nomor Rekening</label>
                            <input
                                type="text"
                                name="bank_account_number"
                                class="form-control"
                                value="{{ $setting->bank_account_number }}">
                        </div>

                        <div class="form-group">
                            <label>Atas Nama</label>
                            <input
                                type="text"
                                name="bank_account_name"
                                class="form-control"
                                value="{{ $setting->bank_account_name }}">
                        </div>

                        <br>

                        <button type="submit" class="primary-btn">
                            Simpan Pengaturan
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>
</div>

@endsection