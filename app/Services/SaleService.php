<?php
namespace App\Services;

use App\Models\{Product, Sale, StockMovement};
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SaleService
{
    public function checkout(array $data, int $userId): Sale
    {
        return DB::transaction(function () use ($data, $userId) {
            $items = collect($data['items']);

            // 1. Kunci baris barang supaya stok tidak "bocor" saat 2 kasir bertransaksi bersamaan
            $products = Product::whereIn('id', $items->pluck('product_id'))
                ->lockForUpdate()->get()->keyBy('id');

            // 2. Validasi stok + hitung total
            $total = 0;
            $lines = [];
            foreach ($items as $i => $item) {
                $product = $products[$item['product_id']];

                if ($product->stock < $item['qty']) {
                    throw ValidationException::withMessages([
                        "items.$i.qty" => "Stok {$product->name} tidak cukup (sisa {$product->stock}).",
                    ]);
                }

                $subtotal = $product->price * $item['qty'];
                $total   += $subtotal;
                $lines[]  = ['product'=>$product, 'qty'=>$item['qty'], 'subtotal'=>$subtotal];
            }

            // 3. Validasi pembayaran
            if ($data['paid'] < $total) {
                throw ValidationException::withMessages([
                    'paid' => 'Uang bayar kurang dari total belanja.',
                ]);
            }

            // 4. Simpan header
            $sale = Sale::create([
                'invoice_no' => 'INV-'.now()->format('YmdHis').random_int(100, 999),
                'user_id'    => $userId,
                'customer_id'=> $data['customer_id'] ?? null,
                'total'      => $total,
                'paid'       => $data['paid'],
                'change'     => $data['paid'] - $total,
            ]);

            // 5. Simpan detail + kurangi stok + catat log stok
            foreach ($lines as $line) {
                $sale->items()->create([
                    'product_id' => $line['product']->id,
                    'qty'        => $line['qty'],
                    'price'      => $line['product']->price,
                    'subtotal'   => $line['subtotal'],
                ]);

                $line['product']->decrement('stock', $line['qty']);

                StockMovement::create([
                    'product_id' => $line['product']->id,
                    'sale_id'    => $sale->id,
                    'type'       => 'out',
                    'qty'        => $line['qty'],
                    'note'       => 'Penjualan '.$sale->invoice_no,
                ]);
            }

            return $sale;
        });
    }
}