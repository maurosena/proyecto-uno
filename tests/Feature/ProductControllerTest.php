<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Provider;
use App\Notifications\StockProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * PRÁCTICA 6 — El CRUD de productos y la alerta de stock bajo.
 */
class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_el_listado_de_productos_se_muestra(): void
    {
        Product::factory()->count(3)->create();

        $response = $this->get(route('productos.index'));

        $response->assertStatus(200);
        $response->assertViewIs('products.index');
    }

    public function test_se_puede_crear_un_producto(): void
    {
        Notification::fake();
        $proveedor = Provider::factory()->create();

        $response = $this->post(route('productos.store'), [
            'code' => 'P-5001',
            'name' => 'Tableta Grafica',
            'amount' => 50,
            'unit' => 'und',
            'price' => 850000,
            'provider_id' => $proveedor->id,
        ]);

        $response->assertRedirect(route('productos.index'));
        $this->assertDatabaseHas('products', [
            'code' => 'P-5001',
            'name' => 'Tableta Grafica',
        ]);
    }

    public function test_se_avisa_cuando_el_producto_nace_con_pocas_existencias(): void
    {
        Notification::fake();
        $proveedor = Provider::factory()->create();

        $this->post(route('productos.store'), [
            'code' => 'P-5002',
            'name' => 'Cable de Red',
            'amount' => 5,
            'unit' => 'und',
            'price' => 25000,
            'provider_id' => $proveedor->id,
        ]);

        Notification::assertSentOnDemand(
            StockProduct::class,
            fn (StockProduct $notification) => $notification->product->name === 'Cable de Red'
        );
    }

    public function test_se_puede_eliminar_un_producto(): void
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('productos.destroy', $product));

        $response->assertRedirect(route('productos.index'));
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }
}
