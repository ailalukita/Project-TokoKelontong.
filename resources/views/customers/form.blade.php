@extends('layouts.app')

@section('title', 'Ubah pelanggan')

@section('content')
    <div class="page-heading">
        <div><div class="eyebrow">Kenali pelanggan</div><h1>Ubah pelanggan</h1><p>Perbarui informasi {{ $customer->name }}.</p></div>
        <a class="button button-soft" href="{{ route('customers.index') }}">Kembali</a>
    </div>
    <section class="card form-card">
        <form method="POST" action="{{ route('customers.update', $customer) }}">
            @csrf @method('PUT')
            <div class="form-grid">
                <div class="form-field"><label for="name">Nama pelanggan</label><input id="name" name="name" value="{{ old('name', $customer->name) }}" maxlength="255" required></div>
                <div class="form-field"><label for="phone">Nomor telepon</label><input id="phone" name="phone" value="{{ old('phone', $customer->phone) }}" maxlength="20"></div>
            </div>
            <div class="form-actions">
                <button class="button" type="submit">Simpan perubahan</button>
                <a class="button button-soft" href="{{ route('customers.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection
