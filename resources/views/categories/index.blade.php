@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
    <div class="page-heading">
        <div><div class="eyebrow">Pengaturan persediaan</div><h1>Kategori</h1><p>Kelompokkan produk agar lebih mudah dikelola.</p></div>
    </div>

    <section class="card">
        <div class="card-header"><div><h2>Tambah kategori</h2><p class="card-description">Buat kategori baru untuk produk toko.</p></div></div>
        <form class="inline-form" method="POST" action="{{ route('categories.store') }}">
            @csrf
            <div class="form-field">
                <label for="name">Nama kategori</label>
                <input id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Minuman" maxlength="100" required>
            </div>
            <button class="button" type="submit">+ Tambah kategori</button>
        </form>
    </section>

    <section class="card">
        <div class="card-header"><div><h2>Daftar kategori</h2><p class="card-description">Kategori yang tersedia di toko.</p></div></div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Nama kategori</th><th>Jumlah produk</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td><span class="table-primary">{{ $category->name }}</span></td>
                        <td><span class="badge">{{ $category->products_count }} produk</span></td>
                        <td>
                            <div class="row-actions">
                                <a class="button button-soft button-small" href="{{ route('categories.edit', $category) }}">Ubah</a>
                                @if ($category->products_count === 0)
                                    <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf @method('DELETE')
                                        <button class="button button-danger button-small" type="submit">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td class="table-empty" colspan="3"><strong>Belum ada kategori</strong><br>Kategori yang dibuat akan tampil di sini.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
