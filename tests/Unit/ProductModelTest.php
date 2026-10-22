<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * PRÁCTICA 3 — Un modelo y la base de datos.
 *
 * Aquí Laravel sí se arranca (hereda de Tests\TestCase) porque los modelos
 * necesitan base de datos. Se usa RefreshDatabase para que cada prueba
 * empiece con la base de datos limpia.
 */
class ProductModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_se_puede_crear_un_producto(): void
    {
        $product = Product::factory()->create([
            'code' => 'P-1001',
            'name' => 'Tableta Grafica',
            'amount' => 20,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'code' => 'P-1001',
            'name' => 'Tableta Grafica',
            'amount' => 20,
        ]);
    }

    public function test_un_producto_pertenece_a_un_proveedor(): void
    {
        $proveedor = Provider::factory()->create();
        $product = Product::factory()->create(['provider_id' => $proveedor->id]);

        $this->assertTrue($product->provider->is($proveedor));
    }

    public function test_el_precio_se_guarda_como_numero(): void
    {
        $product = Product::factory()->create(['price' => 850000]);

        $this->assertSame(850000.0, (float) $product->fresh()->price);
    }

    public function test_un_producto_eliminado_no_aparece_en_el_listado(): void
    {
        $product = Product::factory()->create();
        $product->delete();

        $this->assertSoftDeleted('products', ['id' => $product->id]);
        $this->assertCount(0, Product::all());
    }
}
