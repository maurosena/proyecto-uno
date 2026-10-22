<?php

namespace Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * PRÁCTICA 1 — Una prueba unitaria "de verdad", sin Laravel.
 *
 * Hereda de PHPUnit\Framework\TestCase (NO de Tests\TestCase), por lo que
 * Laravel NO se arranca: la prueba corre en milisegundos y sin base de datos.
 */
class CalculadoraTest extends TestCase
{
    public function test_la_suma_devuelve_el_resultado_correcto(): void
    {
        // Arrange (preparar)
        $a = 3;
        $b = 4;

        // Act (ejecutar)
        $resultado = $a + $b;

        // Assert (verificar)
        $this->assertSame(7, $resultado);
    }

    public function test_verificaciones_de_booleano_y_nulo(): void
    {
        $this->assertTrue(true);
        $this->assertFalse(false);
        $this->assertNull(null);
    }

    public function test_verificaciones_de_colecciones_y_texto(): void
    {
        $productos = ['P-001', 'P-002', 'P-003'];

        $this->assertCount(3, $productos);
        $this->assertContains('P-002', $productos);
        $this->assertStringContainsString('Inventario', 'Sistema de Gestion de Inventario');
    }

    public function test_se_espera_una_excepcion(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('mayor que cero');

        throw new InvalidArgumentException('La cantidad del movimiento debe ser mayor que cero.');
    }
}
