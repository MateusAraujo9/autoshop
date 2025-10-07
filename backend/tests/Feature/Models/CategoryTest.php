<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_cria_categoria_com_sucesso() {
        $category = Category::factory()->create([
            'name' => 'Itens de Segurança',
            'slug' => 'itens_de_segurança'
        ]);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'slug' => 'itens_de_segurança'
        ]);
    }

    public function test_nao_permite_slug_duplicado() {
        Category::factory()->create(['slug' => 'seguranca']);

        $this->expectException(QueryException::class);

        Category::factory()->create(['slug' => 'seguranca']);
    }

    public function test_vincula_produto_as_categorias() {
        $category = Category::factory()->create(['name' => 'Acessórios']);
        $products = Product::factory()->count(3)->create();

        $category->products()->attach($products->pluck('id'));

        $this->assertCount(3, $category->products);
    }
}