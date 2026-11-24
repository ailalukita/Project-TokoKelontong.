<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;

class SummaryApiController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'sales_today' => (int) Sale::whereDate('created_at', today())->sum('total'),
            'transactions' => Sale::whereDate('created_at', today())->count(),
            'total_products' => Product::count(),
            'low_stock_count' => Product::whereColumn('stock', '<=', 'min_stock')->count(),
        ]);
    }
}
