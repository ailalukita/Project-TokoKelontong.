@extends('layouts.app')

@section('title', 'Nota penjualan')

@section('content')
    <div class="page-heading">
        <div>
            <div class="eyebrow">Rincian pembayaran</div>
            <h1>Nota penjualan</h1>
            <p>Faktur {{ $sale->invoice_no }}</p>
        </div>
        <a class="button button-blue" href="{{ route('sales.create') }}">+ Transaksi baru</a>
    </div>

    <section class="card">
        <dl class="sale-summary">
            <div><dt>Nomor faktur</dt><dd>{{ $sale->invoice_no }}</dd></div>
            <div><dt>Tanggal transaksi</dt><dd>{{ $sale->created_at->format('d M Y, H:i') }}</dd></div>
            <div><dt>Kasir</dt><dd>{{ $sale->user->name }}</dd></div>
            <div><dt>Pelanggan</dt><dd>{{ $sale->customer?->name ?? 'Pelanggan umum' }}</dd></div>
        </dl>
        <div class="table-wrap" style="margin-top: 24px">
            <table>
                <thead><tr><th>Produk</th><th class="text-right">Jumlah</th><th class="text-right">Harga</th><th class="text-right">Subtotal</th></tr></thead>
                <tbody>
                @foreach ($sale->items as $item)
                    <tr>
                        <td><span class="table-primary">{{ $item->product->name }}</span></td>
                        <td class="text-right">{{ $item->qty }}</td>
                        <td class="text-right nowrap">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="text-right nowrap"><strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <dl class="receipt-total">
            <div class="grand-total"><dt>Total belanja</dt><dd>Rp {{ number_format($sale->total, 0, ',', '.') }}</dd></div>
            <div><dt>Jumlah dibayar</dt><dd>Rp {{ number_format($sale->paid, 0, ',', '.') }}</dd></div>
            <div><dt>Kembalian</dt><dd>Rp {{ number_format($sale->change, 0, ',', '.') }}</dd></div>
        </dl>
    </section>
@endsection
