<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'code'         => $this->code,
            'name'         => $this->name,
            'category'     => $this->category?->name,
            'price'        => $this->price,
            'stock'        => $this->stock,
            'unit'         => $this->unit,
            'is_low_stock' => $this->isLowStock(),
        ];
    }
}
