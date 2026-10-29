@extends('layouts.app')

@section('title', $equipment->name)

@section('content')
<section>
    <article class="detail">
        @if ($equipment->image_path)
            <img src="{{ asset('storage/' . $equipment->image_path) }}" alt="{{ $equipment->name }}">
        @endif

        <h2>{{ $equipment->name }}</h2>
        <p><strong>Kode:</strong> {{ $equipment->asset_code }}</p>
        <p><strong>Kategori:</strong> {{ $equipment->category->name }}</p>
        <p><strong>Spesifikasi:</strong> {{ $equipment->specification ?? '-' }}</p>
        <p><strong>Kondisi:</strong> {{ ucwords(str_replace('_', ' ', $equipment->condition)) }}</p>
        <p><strong>Tarif harian:</strong> Rp {{ number_format($equipment->daily_rental_fee, 0, ',', '.') }}</p>
        <p><strong>Status:</strong>
            <span class="badge badge-{{ $equipment->status }}">{{ ucwords(str_replace('_', ' ', $equipment->status)) }}</span>
        </p>

        <div class="card-actions">
            <a href="{{ route('equipments.index') }}">&larr; Kembali</a>
            @if ($equipment->status === 'tersedia')
                <a href="{{ route('loans.create', ['equipment_id' => $equipment->id]) }}">Ajukan Peminjaman</a>
            @endif
        </div>
    </article>
</section>
@endsection