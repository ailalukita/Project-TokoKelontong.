@extends('layouts.app')

@section('title', 'Pelanggan')

@section('content')
    <div class="page-heading">
        <div><div class="eyebrow">Kenali pelanggan</div><h1>Pelanggan</h1><p>Kelola informasi pelanggan dan riwayat transaksinya.</p></div>
    </div>
    <section class="card">
        <div class="card-header"><div><h2>Tambah pelanggan</h2><p class="card-description">Simpan informasi pelanggan baru.</p></div></div>
        <form class="inline-form" method="POST" action="{{ route('customers.store') }}">
            @csrf
            <div class="form-field"><label for="name">Nama pelanggan</label><input id="name" name="name" value="{{ old('name') }}" maxlength="255" placeholder="Nama lengkap" required></div>
            <div class="form-field"><label for="phone">Nomor telepon <span class="muted">(opsional)</span></label><input id="phone" name="phone" value="{{ old('phone') }}" maxlength="20" placeholder="08xx xxxx xxxx"></div>
            <button class="button" type="submit">+ Tambah pelanggan</button>
        </form>
    </section>
    <section class="card">
        <div class="card-header"><div><h2>Daftar pelanggan</h2><p class="card-description">Pelanggan yang tersimpan di toko.</p></div></div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Nama pelanggan</th><th>Nomor telepon</th><th>Transaksi</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td><span class="table-primary">{{ $customer->name }}</span></td>
                        <td>{{ $customer->phone ?: '—' }}</td>
                        <td><span class="badge">{{ $customer->sales_count }} transaksi</span></td>
                        <td>
                            <div class="row-actions">
                                <a class="button button-soft button-small" href="{{ route('customers.edit', $customer) }}">Ubah</a>
                                <form method="POST" action="{{ route('customers.destroy', $customer) }}" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="button button-danger button-small" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td class="table-empty" colspan="4"><strong>Belum ada pelanggan</strong><br>Tambahkan pelanggan agar mudah mencatat transaksi.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
