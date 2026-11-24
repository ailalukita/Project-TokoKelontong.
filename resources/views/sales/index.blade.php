@extends('layouts.app')

@section('title', 'Riwayat Penjualan')

@section('content')
    <div class="page-heading">
        <div>
            <div class="eyebrow">Aktivitas toko</div>
            <h1>Riwayat penjualan</h1>
            <p>Lihat kembali transaksi dan detail pembayaran.</p>
        </div>
        <a class="button" href="{{ route('sales.create') }}">+ Transaksi baru</a>
    </div>

    <section class="card">
        <div class="card-header">
            <div><h2>Semua transaksi</h2><p class="card-description">Daftar penjualan terbaru.</p></div>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Nomor faktur</th><th>Tanggal</th><th>Kasir</th><th>Pelanggan</th><th class="text-right">Total</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse ($sales as $sale)
                    <tr>
                        <td><span class="table-primary">{{ $sale->invoice_no }}</span></td>
                        <td class="nowrap">{{ $sale->created_at->format('d M Y, H:i') }}</td>
                        <td>{{ $sale->user->name }}</td>
                        <td>{{ $sale->customer?->name ?? 'Pelanggan umum' }}</td>
                        <td class="text-right nowrap"><strong>Rp {{ number_format($sale->total, 0, ',', '.') }}</strong></td>
                        <td><a class="button button-soft button-small" href="{{ route('sales.show', $sale) }}">Detail</a></td>
                    </tr>
                @empty
                    <tr><td class="table-empty" colspan="6"><strong>Belum ada transaksi</strong><br>Transaksi yang dibuat akan tampil di sini.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if ($sales->hasPages())
            <div class="pagination">{{ $sales->links() }}</div>
        @endif
    </section>
@endsection
