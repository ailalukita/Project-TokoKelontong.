<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesTest extends TestCase
{
    use RefreshDatabase;

    public function test_cashier_can_record_a_sale_and_stock_is_decremented(): void
    {
        $cashier = User::factory()->create(['role' => 'kasir']);
        $product = $this->createProduct(['price' => 2500, 'stock' => 5]);

        $response = $this->actingAs($cashier)->post(route('sales.store'), [
            'paid' => 6000,
            'items' => [
                ['product_id' => $product->id, 'qty' => 2],
            ],
        ]);

        $sale = Sale::firstOrFail();
        $response->assertRedirect(route('sales.show', $sale));
        $this->assertSame(5000, $sale->total);
        $this->assertSame(1000, $sale->change);
        $this->assertSame(3, $product->fresh()->stock);
        $this->actingAs($cashier)
            ->get(route('sales.show', $sale))
            ->assertOk()
            ->assertSee($sale->invoice_no);
        $this->assertDatabaseHas('sale_items', [
            'sale_id' => $sale->id,
            'product_id' => $product->id,
            'qty' => 2,
            'subtotal' => 5000,
        ]);
        $this->assertDatabaseHas('stock_movements', [
            'product_id' => $product->id,
            'sale_id' => $sale->id,
            'type' => 'out',
            'qty' => 2,
        ]);
    }

    public function test_sale_is_rejected_without_changing_stock_when_quantity_exceeds_stock(): void
    {
        $cashier = User::factory()->create(['role' => 'kasir']);
        $product = $this->createProduct(['stock' => 1]);

        $response = $this->actingAs($cashier)->from(route('sales.create'))->post(route('sales.store'), [
            'paid' => 10000,
            'items' => [
                ['product_id' => $product->id, 'qty' => 2],
            ],
        ]);

        $response->assertRedirect(route('sales.create'));
        $response->assertSessionHasErrors('items.0.qty');
        $this->assertSame(1, $product->fresh()->stock);
        $this->assertSame(0, Sale::count());
        $this->assertSame(0, SaleItem::count());
        $this->assertSame(0, StockMovement::count());
    }

    public function test_cashier_cannot_access_admin_product_routes(): void
    {
        $cashier = User::factory()->create(['role' => 'kasir']);

        $this->actingAs($cashier)->get(route('products.index'))->assertForbidden();
    }

    private function createProduct(array $attributes = []): Product
    {
        $category = Category::create(['name' => 'Sembako']);

        return Product::create(array_merge([
            'category_id' => $category->id,
            'code' => 'BRG001',
            'name' => 'Beras',
            'price' => 5000,
            'stock' => 10,
            'min_stock' => 2,
            'unit' => 'pcs',
        ], $attributes));
    }
}
