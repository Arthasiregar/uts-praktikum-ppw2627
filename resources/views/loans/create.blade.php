@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')

@section('content')
<section>
    <h2>Formulir Pengajuan Peminjaman</h2>

    <form method="POST" action="{{ route('loans.store') }}" class="form">
        @csrf

        <div class="form-group">
            <label for="equipment_id">Perangkat</label>
            <select id="equipment_id" name="equipment_id">
                <option value="">-- Pilih Perangkat --</option>
                @foreach ($equipments as $eq)
                    <option value="{{ $eq->id }}" {{ old('equipment_id', $selected) == $eq->id ? 'selected' : '' }}>{{ $eq->asset_code }} - {{ $eq->name }}</option>
                @endforeach
            </select>
            @error('equipment_id') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="borrower_name">Nama Peminjam</label>
            <input type="text" id="borrower_name" name="borrower_name" value="{{ old('borrower_name') }}">
            @error('borrower_name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="borrower_nim">NIM (8 karakter)</label>
            <input type="text" id="borrower_nim" name="borrower_nim" maxlength="8" value="{{ old('borrower_nim') }}">
            @error('borrower_nim') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="borrower_email">Email</label>
            <input type="email" id="borrower_email" name="borrower_email" value="{{ old('borrower_email') }}">
            @error('borrower_email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="loan_date">Tanggal Pinjam</label>
            <input type="date" id="loan_date" name="loan_date" value="{{ old('loan_date') }}">
            @error('loan_date') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="expected_return_date">Tanggal Kembali (maks 7 hari)</label>
            <input type="date" id="expected_return_date" name="expected_return_date" value="{{ old('expected_return_date') }}">
            @error('expected_return_date') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="purpose">Tujuan Peminjaman</label>
            <textarea id="purpose" name="purpose" rows="3">{{ old('purpose') }}</textarea>
            @error('purpose') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit">Ajukan</button>
    </form>
</section>
@endsection