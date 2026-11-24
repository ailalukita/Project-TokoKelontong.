@extends('layouts.app')

@section('title', 'Ubah kategori')

@section('content')
    <div class="page-heading">
        <div><div class="eyebrow">Pengaturan persediaan</div><h1>Ubah kategori</h1><p>Perbarui nama kategori.</p></div>
        <a class="button button-soft" href="{{ route('categories.index') }}">Kembali</a>
    </div>
    <section class="card form-card">
        <form method="POST" action="{{ route('categories.update', $category) }}">
            @csrf @method('PUT')
            <div class="form-field">
                <label for="name">Nama kategori</label>
                <input id="name" name="name" value="{{ old('name', $category->name) }}" maxlength="100" required>
            </div>
            <div class="form-actions">
                <button class="button" type="submit">Simpan perubahan</button>
                <a class="button button-soft" href="{{ route('categories.index') }}">Batal</a>
            </div>
        </form>
    </section>
@endsection
