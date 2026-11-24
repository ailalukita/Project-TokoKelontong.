@extends('layouts.app')

@section('title', 'Produk')

@section('content')
    <div class="page-heading">
        <div>
            <div class="eyebrow">Persediaan toko</div>
            <h1>Produk</h1>
            <p>Atur barang, harga, dan jumlah stok yang tersedia.</p>
        </div>
        <a class="button" href="{{ route('products.create') }}">+ Tambah produk</a>
    </div>

    <section class="card">
        <div class="card-header"><div><h2>Daftar produk</h2><p class="card-description">Produk ditampilkan berdasarkan nama.</p></div></div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Produk</th><th>Kategori</th><th class="text-right">Harga</th><th>Stok</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td><span class="table-primary">{{ $product->name }}</span><span class="table-secondary">{{ $product->code }}</span></td>
                        <td>{{ $product->category->name }}</td>
                        <td class="text-right nowrap">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td><span class="badge {{ $product->isLowStock() ? 'badge-pink' : '' }}">{{ $product->stock }} {{ $product->unit }}</span></td>
                        <td>
                            <div class="row-actions">
                                <a class="button button-soft button-small" href="{{ route('products.edit', $product) }}">Ubah</a>
                                <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button class="button button-danger button-small" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td class="table-empty" colspan="5"><strong>Belum ada produk</strong><br>Tambahkan produk pertama untuk mulai mengelola stok.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if ($products->hasPages())
            <div class="pagination">{{ $products->links() }}</div>
        @endif
    </section>
@endsection
