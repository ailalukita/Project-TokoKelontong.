<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#fdf7fb">
    <title>@yield('title', 'TokoKu') · TokoKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="topbar">
        <nav class="navigation" aria-label="Navigasi utama">
            <a class="brand" href="{{ route('dashboard') }}">
                <span class="brand-mark" aria-hidden="true">T</span>
                <span>Toko<span class="brand-accent">Ku</span><small>Kelontong harian</small></span>
            </a>
            @auth
                <div class="nav-links">
                    <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    <a class="{{ request()->routeIs('sales.*') ? 'active' : '' }}" href="{{ route('sales.index') }}">Penjualan</a>
                    <a class="{{ request()->routeIs('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">Pelanggan</a>
                    @if (auth()->user()->isAdmin())
                        <a class="{{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Produk</a>
                        <a class="{{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">Kategori</a>
                    @endif
                </div>
                <div class="account-menu">
                    <span class="avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                    <span class="account-name">{{ auth()->user()->name }}<small>{{ ucfirst(auth()->user()->role) }}</small></span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="button button-quiet button-small" type="submit">Keluar</button>
                    </form>
                </div>
            @endauth
        </nav>
    </header>

    <main class="page-container">
        @if (session('success') || session('status'))
            <div class="notice notice-success" role="status">{{ session('success') ?? session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="notice notice-error" role="alert">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="notice notice-error" role="alert">
                <strong>Mohon periksa kembali:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>
