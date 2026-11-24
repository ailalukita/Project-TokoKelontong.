@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-heading">
        <div>
            <div class="eyebrow">Ringkasan toko</div>
            <h1>Dashboard</h1>
            <p>Selamat datang kembali, {{ auth()->user()->name }}. Ini ringkasan tokomu hari ini.</p>
        </div>
        <a class="button" href="{{ route('sales.create') }}">+ Transaksi baru</a>
    </div>

    <div class="stat-grid">
        <article class="stat-card">
            <span class="stat-icon" aria-hidden="true">Rp</span>
            <div class="stat-label">Omzet hari ini</div>
            <p class="stat-value">Rp {{ number_format($todaySales, 0, ',', '.') }}</p>
        </article>
        <article class="stat-card">
            <span class="stat-icon" aria-hidden="true">↗</span>
            <div class="stat-label">Transaksi hari ini</div>
            <p class="stat-value">{{ number_format($todayTransactions) }}</p>
        </article>
        <article class="stat-card">
            <span class="stat-icon" aria-hidden="true">▦</span>
            <div class="stat-label">Total produk</div>
            <p class="stat-value">{{ number_format($productCount) }}</p>
        </article>
        <article class="stat-card">
            <span class="stat-icon" aria-hidden="true">♡</span>
            <div class="stat-label">Pelanggan</div>
            <p class="stat-value">{{ number_format($customerCount) }}</p>
        </article>
    </div>

    <section class="card">
        <div class="card-header">
            <div>
                <h2>Stok perlu diperhatikan</h2>
                <p class="card-description">Produk yang jumlah stoknya sudah mencapai batas minimum.</p>
            </div>
            @if (auth()->user()->isAdmin())
                <a class="button button-soft button-small" href="{{ route('products.index') }}">Lihat produk</a>
            @endif
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Produk</th><th>Kategori</th><th>Stok tersedia</th><th>Batas minimum</th></tr></thead>
                <tbody>
                @forelse ($lowStockProducts as $product)
                    <tr>
                        <td><span class="table-primary">{{ $product->name }}</span><span class="table-secondary">{{ $product->code }}</span></td>
                        <td>{{ $product->category->name }}</td>
                        <td><span class="badge badge-pink">{{ $product->stock }} {{ $product->unit }}</span></td>
                        <td>{{ $product->min_stock }} {{ $product->unit }}</td>
                    </tr>
                @empty
                    <tr><td class="table-empty" colspan="4"><strong>Semua stok aman</strong><br>Belum ada produk yang perlu segera diisi ulang.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
