<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_pages_render_when_the_store_is_empty(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        foreach ([
            'dashboard',
            'categories.index',
            'customers.index',
            'products.index',
            'products.create',
            'sales.index',
            'sales.create',
        ] as $route) {
            $this->get(route($route))->assertOk();
        }
    }
}
