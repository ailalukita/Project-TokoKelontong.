@extends('layouts.app')

@section('title', 'Tambah produk')

@section('content')
    <div class="page-heading">
        <div><div class="eyebrow">Persediaan toko</div><h1>Tambah produk</h1><p>Masukkan detail produk baru ke daftar persediaan.</p></div>
        <a class="button button-soft" href="{{ route('products.index') }}">Kembali</a>
    </div>
    <section class="card">
        <form method="POST" action="{{ route('products.store') }}">
            @csrf
            @include('products.form')
        </form>
    </section>
@endsection
