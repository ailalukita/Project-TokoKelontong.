@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
    <div class="login-shell">
        <section class="card login-card">
            <a class="brand" href="{{ route('login') }}">
                <span class="brand-mark" aria-hidden="true">T</span>
                <span>Toko<span class="brand-accent">Ku</span><small>Kelontong harian</small></span>
            </a>
            <h1>Selamat datang</h1>
            <p>Masuk untuk mengelola tokomu.</p>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" placeholder="nama@email.com" required>
                </div>
                <div class="form-field" style="margin-top: 17px">
                    <label for="password">Kata sandi</label>
                    <input id="password" type="password" name="password" autocomplete="current-password" placeholder="Masukkan kata sandi" required>
                </div>
                <button class="button" type="submit">Masuk ke akun</button>
            </form>
        </section>
    </div>
@endsection