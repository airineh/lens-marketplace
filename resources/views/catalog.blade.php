@extends('layouts.lens')

@section('content')
<div class="section">
    <div class="container">

        <h2>Katalog Alat</h2>
        <p>Pilih alat fotografi yang tersedia untuk disewa.</p>
        <hr>

        <div class="row">
            @forelse($equipments as $equipment)
                <div class="col-md-4">
                    <div class="product" style="padding:15px; min-height:430px;">

                        @if($equipment->photo)
                            <div style="height:190px; display:flex; align-items:center; justify-content:center;">
                                <img src="{{ asset('storage/' . $equipment->photo) }}"
                                     style="max-width:100%; max-height:180px;">
                            </div>
                        @endif

                        <div class="product-body">
                            <p class="product-category">
                                {{ $equipment->category->name ?? 'Tanpa Kategori' }}
                            </p>

                            <h3 class="product-name">
                                {{ $equipment->name }}
                            </h3>

                            <p style="min-height:70px;">
                                {{ Str::limit($equipment->description, 90) }}
                            </p>

                            <h4 class="product-price">
                                Rp {{ number_format($equipment->price_per_hour, 0, ',', '.') }} / jam
                            </h4>

                            <p>
                                Pemilik:
                                <strong>{{ $equipment->user->name ?? '-' }}</strong>
                            </p>

                            <a href="{{ route('catalog.show', $equipment->id) }}" class="primary-btn">
                                Lihat Detail
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <div class="alert alert-info">
                        Belum ada alat yang tersedia.
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection