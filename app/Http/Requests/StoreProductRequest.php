<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }   // akses sudah dijaga middleware

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'code' => ['required', 'string', 'max:30', Rule::unique('products', 'code')->ignore($this->route('product'))],
            'name' => ['required', 'string', 'max:150'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'min_stock' => ['required', 'integer', 'min:0'],
            'unit' => ['required', 'string', 'max:20'],
        ];
    }

    public function attributes(): array
    {
        return ['category_id' => 'kategori', 'code' => 'kode', 'name' => 'nama', 'price' => 'harga',
            'stock' => 'stok', 'min_stock' => 'stok minimum', 'unit' => 'satuan'];
    }
}
