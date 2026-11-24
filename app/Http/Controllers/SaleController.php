<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Services\SaleService;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['user', 'customer'])->latest()->paginate(10);

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        return view('sales.create', [
            'products' => Product::where('stock', '>', 0)->orderBy('name')->get(['id', 'name', 'price', 'stock', 'unit']),
            'customers' => Customer::orderBy('name')->get(),
        ]);
    }

    public function store(StoreSaleRequest $request, SaleService $service)
    {
        $sale = $service->checkout($request->validated(), $request->user()->id);

        return redirect()->route('sales.show', $sale)->with('success', 'Transaksi berhasil disimpan.');
    }

    public function show(Sale $sale)
    {
        $sale->load(['user', 'customer', 'items.product']);

        return view('sales.show', compact('sale'));
    }
}
