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
                    <h2>Edit Alat</h2>
                    <p>Perbarui data alat fotografi yang disewakan.</p>
                    <hr>

                    <form action="{{ route('equipments.update', $equipment->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Nama Alat</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ $equipment->name }}" required>
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="category_id" class="form-control" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $equipment->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" rows="5" required>{{ $equipment->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Harga Sewa per Jam</label>
                            <input type="number" name="price_per_hour" class="form-control"
                                   value="{{ $equipment->price_per_hour }}" required>
                        </div>

                        <div class="form-group">
                            <label>Status Alat</label>
                            <select name="stock_status" class="form-control" required>
                                <option value="available" {{ $equipment->stock_status == 'available' ? 'selected' : '' }}>
                                    Available
                                </option>
                                <option value="unavailable" {{ $equipment->stock_status == 'unavailable' ? 'selected' : '' }}>
                                    Unavailable
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Foto Alat</label><br>

                            @if($equipment->photo)
                                <img src="{{ asset('storage/' . $equipment->photo) }}"
                                     style="max-width:160px; margin-bottom:10px;">
                            @endif

                            <input type="file" name="photo" class="form-control">
                        </div>

                        <button type="submit" class="primary-btn">
                            Simpan Perubahan
                        </button>

                        <a href="{{ route('equipments.index') }}" class="primary-btn">
                            Kembali
                        </a>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection