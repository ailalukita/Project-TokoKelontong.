@extends('layouts.app')

@section('title', 'Transaksi baru')

@section('content')
    <div class="page-heading">
        <div><div class="eyebrow">Kasir</div><h1>Transaksi baru</h1><p>Pilih barang dan masukkan jumlah untuk membuat transaksi.</p></div>
        <a class="button button-soft" href="{{ route('sales.index') }}">Riwayat penjualan</a>
    </div>

    @if ($products->isEmpty())
        <section class="card empty-state">
            <strong>Belum ada stok yang tersedia</strong>
            Produk dengan stok tersedia akan muncul di halaman ini.
        </section>
    @else
        <section class="card">
            <form method="POST" action="{{ route('sales.store') }}" id="sale-form">
                @csrf
                <div class="form-field" style="max-width: 520px">
                    <label for="customer_id">Pelanggan <span class="muted">(opsional)</span></label>
                    <select id="customer_id" name="customer_id">
                        <option value="">Pelanggan umum</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>{{ $customer->name }}{{ $customer->phone ? ' · '.$customer->phone : '' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="card-header" style="margin-top: 28px">
                    <div><h2>Barang belanja</h2><p class="card-description">Pilih produk dan jumlah yang dibeli.</p></div>
                    <button class="button button-blue button-small" id="add-item" type="button">+ Tambah barang</button>
                </div>
                <div class="sale-items" id="items">
                    <div class="sale-item">
                        <div class="form-field">
                            <label>Produk</label>
                            <select name="items[0][product_id]" class="item-product" required>
                                <option value="">Pilih produk</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                        {{ $product->name }} · stok {{ $product->stock }} {{ $product->unit }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-field">
                            <label>Jumlah</label>
                            <input class="item-qty" name="items[0][qty]" type="number" min="1" value="1" required>
                        </div>
                        <button class="button button-danger button-small remove-item" type="button" aria-label="Hapus barang">×</button>
                    </div>
                </div>

                <template id="item-template">
                    <div class="sale-item">
                        <div class="form-field">
                            <label>Produk</label>
                            <select class="item-product" required>
                                <option value="">Pilih produk</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                        {{ $product->name }} · stok {{ $product->stock }} {{ $product->unit }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-field">
                            <label>Jumlah</label>
                            <input class="item-qty" type="number" min="1" value="1" required>
                        </div>
                        <button class="button button-danger button-small remove-item" type="button" aria-label="Hapus barang">×</button>
                    </div>
                </template>

                <div class="sale-total">
                    <span>Perkiraan total belanja</span>
                    <strong>Rp <span id="total">0</span></strong>
                </div>
                <div class="form-field" style="max-width: 360px; margin-top: 21px">
                    <label for="paid">Jumlah dibayar</label>
                    <input id="paid" name="paid" type="number" min="0" step="1" value="{{ old('paid', 0) }}" required>
                    <span class="form-hint">Masukkan nominal pembayaran dari pelanggan.</span>
                </div>
                <div class="form-actions">
                    <button class="button" type="submit">Simpan transaksi</button>
                    <a class="button button-soft" href="{{ route('sales.index') }}">Batal</a>
                </div>
            </form>
        </section>
    @endif
@endsection

@push('scripts')
    <script>
        const saleItems = document.getElementById('items');
        if (saleItems) {
            const formatAmount = amount => new Intl.NumberFormat('id-ID').format(amount);
            const refreshTotal = () => {
                let total = 0;
                saleItems.querySelectorAll('.sale-item').forEach(row => {
                    const selected = row.querySelector('.item-product').selectedOptions[0];
                    total += Number(selected?.dataset.price || 0) * Number(row.querySelector('.item-qty').value || 0);
                });
                document.getElementById('total').textContent = formatAmount(total);
            };
            const refreshNames = () => {
                saleItems.querySelectorAll('.sale-item').forEach((row, index) => {
                    row.querySelector('.item-product').name = `items[${index}][product_id]`;
                    row.querySelector('.item-qty').name = `items[${index}][qty]`;
                });
            };

            document.getElementById('add-item').addEventListener('click', () => {
                saleItems.append(document.getElementById('item-template').content.cloneNode(true));
                refreshNames();
            });
            saleItems.addEventListener('input', refreshTotal);
            saleItems.addEventListener('change', refreshTotal);
            saleItems.addEventListener('click', event => {
                if (event.target.closest('.remove-item') && saleItems.querySelectorAll('.sale-item').length > 1) {
                    event.target.closest('.sale-item').remove();
                    refreshNames();
                    refreshTotal();
                }
            });
            refreshTotal();
        }
    </script>
@endpush
