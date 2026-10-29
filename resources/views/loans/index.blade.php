@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
<section>
    <h2>Riwayat Peminjaman</h2>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Perangkat</th>
                    <th>Peminjam</th>
                    <th>NIM</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Estimasi Biaya</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($loans as $loan)
                    <tr>
                        <td>{{ $loan->equipment->name }}</td>
                        <td>{{ $loan->borrower_name }}</td>
                        <td>{{ $loan->borrower_nim }}</td>
                        <td>{{ $loan->loan_date->format('d M Y') }}</td>
                        <td>{{ $loan->expected_return_date->format('d M Y') }}</td>
                        <td>Rp {{ number_format($loan->total_estimated_fee, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($loan->status) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7">Belum ada riwayat peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $loans->links() }}
    </div>
</section>
@endsection