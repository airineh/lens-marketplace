@extends('layouts.lens')

@section('content')
<div class="section">
    <div class="container">

        <div class="product" style="padding:30px;">
            <h2>Booking Alat</h2>
            <p>Ajukan penyewaan alat fotografi berikut.</p>
            <hr>

            <div class="row">
                <div class="col-md-5">
                    @if($equipment->photo)
                        <img src="{{ asset('storage/' . $equipment->photo) }}"
                             style="max-width:100%; max-height:300px;">
                    @endif
                </div>

                <div class="col-md-7">
                    <h3>{{ $equipment->name }}</h3>
                    <p>{{ $equipment->description }}</p>

                    <p>
                        Harga:
                        <strong>
                            Rp {{ number_format($equipment->price_per_hour, 0, ',', '.') }} / jam
                        </strong>
                    </p>

                    <p>
                        Pemilik:
                        <strong>{{ $equipment->user->name ?? '-' }}</strong>
                    </p>

                    <form action="{{ route('booking.store', $equipment->id) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Waktu Mulai Sewa</label>
                            <input type="datetime-local" name="start_time" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Waktu Selesai Sewa</label>
                            <input type="datetime-local" name="end_time" class="form-control" required>
                        </div>

                        <button type="submit" class="primary-btn">
                            Ajukan Booking
                        </button>

                        <a href="{{ route('catalog.show', $equipment->id) }}" class="primary-btn">
                            Kembali
                        </a>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection