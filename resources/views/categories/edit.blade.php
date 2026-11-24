@extends('layouts.app')
@section('title', 'Edit Kategori')
@section('content')
<h4>Edit Kategori</h4>
<form method="POST" action="{{ route('categories.update', $category) }}" class="col-md-5">
  @csrf @method('PUT')
  <input name="name" value="{{ old('name', $category->name) }}" class="form-control mb-3" required>
  <button class="btn btn-primary">Simpan</button>
  <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection