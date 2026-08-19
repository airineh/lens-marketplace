@extends('layouts.lens') @section('content')
<div class="section">
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                @include('partials.sidebar')
            </div>

            <div class="col-md-9">
                <div class="product" style="padding:30px;">
                    <h2>Inventaris Saya</h2>
                    <p>Kelola daftar alat fotografi yang kamu sewakan di Lens.</p>
                    <hr>

                    <a href="{{ route('equipments.create') }}" class="primary-btn">
                        Tambah Alat
                    </a>

                    <br><br>

                    <div class="row">
                        @forelse($equipments as $equipment)
                        <div class="col-md-4">
                            <div class="product" style="padding:15px; min-height:420px;">

                                @if($equipment->photo)
                                <div
                                    style="height:180px; display:flex; align-items:center; justify-content:center;">
                                    <img
                                        src="{{ asset('storage/' . $equipment->photo) }}"
                                        style="max-width:100%; max-height:170px;">
                                </div>
                                @endif

                                <div class="product-body">
                                    <h3 class="product-name">
                                        {{ $equipment->name }}
                                    </h3>

                                    <p style="min-height:70px;">
                                        {{ Str::limit($equipment->description, 90) }}
                                    </p>

                                    <h4 class="product-price">
                                        Rp
                                        {{ number_format($equipment->price_per_hour, 0, ',', '.') }}
                                        / jam
                                    </h4>

                                    <p>
                                        Status:
                                        <strong>{{ $equipment->stock_status }}</strong>
                                    </p>

                                    <a href="{{ route('equipments.edit', $equipment->id) }}" class="primary-btn">
                                            Edit
                                        </a>

                                    <a href="#" class="primary-btn">
                                        Detail
                                    </a>
                                </div>

                            </div>
                        </div>
                        @empty
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                Belum ada alat yang ditambahkan.
                            </div>
                        </div>
                        @endforelse
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection