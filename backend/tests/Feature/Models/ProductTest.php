<?php

namespace Tests\Feature\Models;

use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_produto_com_sucesso() {
        $product = Product::factory()->create([
            'name' => 'Pastilha de Freio Fiat',
            'slug' => 'pastilha-de-freio-fiat',
            'description' => 'Pastilha de freio para carros da fiat',
            'active' => true
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'slug' => 'pastilha-de-freio-fiat',
            'description' => 'Pastilha de freio para carros da fiat',
            'active' => 1
        ]);
    }

    public function test_nao_permite_slug_duplicado() {
        Product::factory()->create(['slug' => 'volante-esportivo-onix']);

        $this->expectException(QueryException::class);

        Product::factory()->create(['slug' => 'volante-esportivo-onix']);
    }

    public function test_escopo_active_retornar_somente_produtos_ativos() {
        Product::factory()->count(2)->create(['active' => true]);
        Product::factory()->count(1)->create(['active' => false]);

        $ativos = Product::active()->get();

        $this->assertCount(2, $ativos);
        $this->assertTrue($ativos->every(fn ($p) => $p->active === true));
    }
}
