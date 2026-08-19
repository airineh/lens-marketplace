@extends('layouts.lens')

@section('content')
<div class="section">
    <div class="container">
        <div class="row">

            <<div class="col-md-3">
    @include('partials.sidebar')
</div>

            <div class="col-md-9">
                <div class="product" style="padding:30px;">
                    <h2>Tambah Alat</h2>
                    <p>Tambahkan data alat fotografi yang ingin disewakan.</p>
                    <hr>

                    <form action="{{ route('equipments.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Nama Alat</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Canon EOS R50" required>
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="category_id" class="form-control" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="Tuliskan deskripsi alat..." required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Harga Sewa per Jam</label>
                            <input type="number" name="price_per_hour" class="form-control" placeholder="Contoh: 250000" required>
                        </div>

                        <div class="form-group">
                            <label>Foto Alat</label>
                            <input type="file" name="photo" class="form-control" required>
                        </div>

                        <button type="submit" class="primary-btn">
                            Simpan Alat
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