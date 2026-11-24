<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
  
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'customer_id'        => ['nullable','exists:customers,id'],
            'items'              => ['required','array','min:1'],
            'items.*.product_id' => ['required','exists:products,id','distinct'],
            'items.*.qty'        => ['required','integer','min:1'],
            'paid'               => ['required','integer','min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'items.required'              => 'Tambahkan minimal satu barang.',
            'items.*.product_id.distinct' => 'Ada barang yang dipilih dua kali.',
        ];
    }
}