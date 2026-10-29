@extends('layouts.app')

@section('title', 'Tambah Aset')

@section('content')
<section>
    <h2>Tambah Aset Baru</h2>

    <form method="POST" action="{{ route('equipments.store') }}" enctype="multipart/form-data" class="form">
        @csrf

        <div class="form-group">
            <label for="asset_code">Kode Aset (EQ-[KODE_KAT]-[NOMOR])</label>
            <input type="text" id="asset_code" name="asset_code" value="{{ old('asset_code') }}">
            @error('asset_code') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="name">Nama Perangkat</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="category_id">Kategori</label>
            <select id="category_id" name="category_id">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="specification">Spesifikasi</label>
            <textarea id="specification" name="specification" rows="3">{{ old('specification') }}</textarea>
            @error('specification') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="condition">Kondisi</label>
            <select id="condition" name="condition">
                @foreach (['baik' => 'Baik', 'rusak_ringan' => 'Rusak Ringan', 'rusak_berat' => 'Rusak Berat'] as $val => $label)
                    <option value="{{ $val }}" {{ old('condition', 'baik') == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('condition') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="daily_rental_fee">Tarif Harian (Rp)</label>
            <input type="number" id="daily_rental_fee" name="daily_rental_fee" value="{{ old('daily_rental_fee') }}">
            @error('daily_rental_fee') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="image">Foto Perangkat (jpeg/png/webp, maks 2MB)</label>
            <input type="file" id="image" name="image">
            @error('image') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit">Simpan</button>
    </form>
</section>
@endsection