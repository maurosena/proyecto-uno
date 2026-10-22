<?php

namespace Tests\Unit;

use App\Support\InventoryRules;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * PRÁCTICA 2 — Una clase de negocio real del proyecto, probada sola.
 *
 * App\Support\InventoryRules no toca la base de datos, por eso se puede
 * probar como una unidad pura.
 */
class InventoryRulesTest extends TestCase
{
    private InventoryRules $rules;

    protected function setUp(): void
    {
        $this->rules = new InventoryRules;
    }

    public function test_clasifica_el_stock_segun_la_cantidad(): void
    {
        $this->assertSame('critico', $this->rules->level(5));
        $this->assertSame('advertencia', $this->rules->level(20));
        $this->assertSame('normal', $this->rules->level(100));
    }

    public function test_detecta_el_stock_bajo(): void
    {
        $this->assertTrue($this->rules->isLowStock(10));
        $this->assertFalse($this->rules->isLowStock(11));
    }

    public function test_una_entrada_aumenta_y_una_salida_resta(): void
    {
        $this->assertSame(15.0, $this->rules->applyMovement(10, 'entrada', 5));
        $this->assertSame(7.0, $this->rules->applyMovement(10, 'salida', 3));
    }

    public function test_una_salida_mayor_al_inventario_lanza_excepcion(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('mayor a la cantidad de inventario');

        $this->rules->applyMovement(5, 'salida', 10);
    }
}
