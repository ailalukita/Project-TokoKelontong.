@php $p = $product ?? null; @endphp
<div class="form-grid">
    <div class="form-field">
        <label for="code">Kode produk</label>
        <input id="code" name="code" value="{{ old('code', $p?->code) }}" maxlength="30" required>
    </div>
    <div class="form-field">
        <label for="name">Nama produk</label>
        <input id="name" name="name" value="{{ old('name', $p?->name) }}" maxlength="150" required>
    </div>
    <div class="form-field">
        <label for="category_id">Kategori</label>
        <select id="category_id" name="category_id" required>
            <option value="">Pilih kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $p?->category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-field">
        <label for="unit">Satuan</label>
        <input id="unit" name="unit" value="{{ old('unit', $p?->unit ?? 'pcs') }}" maxlength="20" required>
    </div>
    <div class="form-field">
        <label for="price">Harga jual</label>
        <input id="price" type="number" name="price" value="{{ old('price', $p?->price) }}" min="0" step="1" required>
    </div>
    <div class="form-field">
        <label for="stock">Stok tersedia</label>
        <input id="stock" type="number" name="stock" value="{{ old('stock', $p?->stock ?? 0) }}" min="0" step="1" required>
    </div>
    <div class="form-field">
        <label for="min_stock">Batas stok minimum</label>
        <input id="min_stock" type="number" name="min_stock" value="{{ old('min_stock', $p?->min_stock ?? 5) }}" min="0" step="1" required>
        <span class="form-hint">Stok akan ditandai jika sudah mencapai batas ini.</span>
    </div>
</div>
<div class="form-actions">
    <button class="button" type="submit">Simpan produk</button>
    <a class="button button-soft" href="{{ route('products.index') }}">Batal</a>
</div>
