<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * PRÁCTICA 5 — El dashboard: la pantalla que resume el inventario.
 */
class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_el_dashboard_se_muestra_correctamente(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.dashboard');
    }

    public function test_el_dashboard_separa_los_productos_por_nivel_de_stock(): void
    {
        $critico = Product::factory()->critical()->create(['name' => 'Cable HDMI']);
        $normal = Product::factory()->normal()->create(['name' => 'Monitor 24 pulgadas']);

        $response = $this->get(route('dashboard'));

        // El producto con poco stock va en el grupo "crítico"...
        $response->assertViewHas('criticalProducts', fn ($productos) => $productos->first()->id === $critico->id);

        // ...y el que tiene stock de sobra va en "normal".
        $response->assertViewHas('normalProducts', fn ($productos) => $productos->first()->id === $normal->id);
    }

    public function test_el_dashboard_muestra_los_contadores_correctos(): void
    {
        Product::factory()->count(2)->critical()->create();
        Product::factory()->count(3)->normal()->create();

        $response = $this->get(route('dashboard'));

        $response->assertViewHas('criticalCount', 2);
        $response->assertViewHas('normalCount', 3);
        $response->assertViewHas('totalProducts', 5);
    }
}
