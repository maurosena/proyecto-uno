<?php

namespace Tests\Unit;

use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\Provider;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

/**
 * EXTRA (opcional) — Probar sin pasar por HTTP y simular el PDF.
 *
 * En las prácticas 4, 5 y 6 se hace una petición HTTP real.
 * Aquí se llama al método del controlador directamente y se sustituyen
 * los colaboradores externos (el PDF) por simulaciones (mocks).
 */
class ProductControllerUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_el_controlador_crea_el_producto_sin_pasar_por_http(): void
    {
        $proveedor = Provider::factory()->create();

        $request = Request::create('/productos', 'POST', [
            'code' => 'P-7001',
            'name' => 'Router WiFi',
            'amount' => 12,
            'unit' => 'und',
            'price' => 150000,
            'provider_id' => $proveedor->id,
        ]);

        $response = (new ProductController)->store($request);

        $this->assertTrue($response->isRedirect(route('productos.index')));
        $this->assertDatabaseHas('products', ['code' => 'P-7001']);
    }

    public function test_el_pdf_se_puede_simular_con_mockery(): void
    {
        $product = Product::factory()->create(['name' => 'Monitor Gamer']);

        $pdfSimulado = Mockery::mock(\Barryvdh\DomPDF\PDF::class);
        $pdfSimulado->shouldReceive('stream')
            ->once()
            ->andReturn(response('PDF-SIMULADO', 200, ['Content-Type' => 'application/pdf']));

        PDF::shouldReceive('loadView')
            ->once()
            ->with('products.pdf', Mockery::on(
                fn (array $datos) => $datos['product']->id === $product->id
            ))
            ->andReturn($pdfSimulado);

        $response = (new ProductController)->pdf($product->id);

        $this->assertSame('PDF-SIMULADO', $response->getContent());
    }
}
