<?php

namespace Tests\Feature;

use App\Models\Movement;
use App\Models\Product;
use App\Notifications\StockProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * PRÁCTICA 4 — Un controlador HTTP: el corazón del inventario.
 *
 * Estas pruebas hacen una petición HTTP real (como si un usuario escribiera
 * en el formulario), por eso van en tests/Feature.
 */
class MovementControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Atajo: envía el formulario de movimiento de un producto.
     */
    private function registrarMovimiento(Product $product, string $type, float $amount)
    {
        return $this->post(route('movimientos.store'), [
            'type' => $type,
            'amount' => $amount,
            'sale_point' => 'Caja 1',
            'producto' => $product->id,
        ]);
    }

    public function test_el_listado_de_movimientos_se_muestra(): void
    {
        $product = Product::factory()->create();
        Movement::factory()->count(2)->create(['product_id' => $product->id]);

        $response = $this->get(route('movimientos.index'));

        $response->assertStatus(200);
        $response->assertViewIs('movements.index');
    }

    public function test_una_entrada_aumenta_el_stock_del_producto(): void
    {
        $product = Product::factory()->create(['amount' => 10]);

        $response = $this->registrarMovimiento($product, Movement::MOVEMENT_TYPE_IN, 5);

        $response->assertRedirect(route('movimientos.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'amount' => 15,
        ]);
    }

    public function test_una_salida_resta_el_stock_del_producto(): void
    {
        $product = Product::factory()->create(['amount' => 10]);

        $this->registrarMovimiento($product, Movement::MOVEMENT_TYPE_OUT, 3);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'amount' => 7,
        ]);
    }

    public function test_una_salida_mayor_al_inventario_no_modifica_el_stock(): void
    {
        $product = Product::factory()->create(['amount' => 5]);

        $response = $this->registrarMovimiento($product, Movement::MOVEMENT_TYPE_OUT, 10);

        // El usuario recibe el error del negocio...
        $response->assertSessionHas('error');

        // ...no se registra el movimiento...
        $this->assertDatabaseMissing('movements', ['product_id' => $product->id]);

        // ...y el stock queda intacto.
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'amount' => 5,
        ]);
    }

    public function test_se_avisa_cuando_el_producto_queda_con_pocas_existencias(): void
    {
        Notification::fake();

        $product = Product::factory()->create(['amount' => 12]);

        $this->registrarMovimiento($product, Movement::MOVEMENT_TYPE_OUT, 5);

        Notification::assertSentOnDemand(
            StockProduct::class,
            fn (StockProduct $notification) => $notification->product->id === $product->id
        );
    }
}
