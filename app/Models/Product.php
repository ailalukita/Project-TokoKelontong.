<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Product.php
class Product extends Model
{
    protected $fillable = ['category_id','code','name','price','stock','min_stock','unit'];

    public function category()  { return $this->belongsTo(Category::class); }
    public function saleItems() { return $this->hasMany(SaleItem::class); }
    public function movements() { return $this->hasMany(StockMovement::class); }

    public function isLowStock(): bool { return $this->stock <= $this->min_stock; }
}