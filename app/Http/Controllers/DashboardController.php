<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'todaySales' => Sale::whereDate('created_at', today())->sum('total'),
            'todayTransactions' => Sale::whereDate('created_at', today())->count(),
            'productCount' => Product::count(),
            'customerCount' => Customer::count(),
            'lowStockProducts' => Product::with('category')
                ->whereColumn('stock', '<=', 'min_stock')
                ->orderBy('stock')
                ->limit(10)
                ->get(),
        ]);
    }
}
