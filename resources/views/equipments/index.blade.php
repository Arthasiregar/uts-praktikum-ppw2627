@extends('layouts.app')

@section('title', 'Katalog Aset')

@section('content')
<section>
    <h2>Katalog Aset Laboratorium</h2>

    <form method="GET" action="{{ route('equipments.index') }}" class="filter-form">
        <input type="text" name="search" placeholder="Cari nama / kode aset" value="{{ request('search') }}">

        <select name="category_id">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>

        <select name="status">
            <option value="semua">Semua Status</option>
            <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
            <option value="dalam_perbaikan" {{ request('status') == 'dalam_perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
        </select>

        <button type="submit">Cari</button>
    </form>

    <div class="grid">
        @forelse ($equipments as $eq)
            <article class="card">
                @if ($eq->image_path)
                    <img src="{{ asset('storage/' . $eq->image_path) }}" alt="{{ $eq->name }}">
                @else
                    <div class="no-image">Tidak ada foto</div>
                @endif
                <div class="card-body">
                    <small>{{ $eq->asset_code }} &middot; {{ $eq->category->name }}</small>
                    <h3>{{ $eq->name }}</h3>
                    <p>Rp {{ number_format($eq->daily_rental_fee, 0, ',', '.') }} / hari</p>
                    <span class="badge badge-{{ $eq->status }}">{{ ucwords(str_replace('_', ' ', $eq->status)) }}</span>
                    <div class="card-actions">
                        <a href="{{ route('equipments.show', $eq->id) }}">Detail</a>
                        @if ($eq->status === 'tersedia')
                            <a href="{{ route('loans.create', ['equipment_id' => $eq->id]) }}">Pinjam</a>
                        @endif
                    </div>
                </div>
            </article>
        @empty
            <p>Tidak ada aset yang ditemukan.</p>
        @endforelse
    </div>

    <div class="pagination-wrap">
        {{ $equipments->links() }}
    </div>
</section>
@endsection