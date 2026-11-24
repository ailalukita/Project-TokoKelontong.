@extends('layouts.app')

@section('title', 'Ubah produk')

@section('content')
    <div class="page-heading">
        <div><div class="eyebrow">Persediaan toko</div><h1>Ubah produk</h1><p>Perbarui informasi {{ $product->name }}.</p></div>
        <a class="button button-soft" href="{{ route('products.index') }}">Kembali</a>
    </div>
    <section class="card">
        <form method="POST" action="{{ route('products.update', $product) }}">
            @csrf @method('PUT')
            @include('products.form')
        </form>
    </section>
@endsection
