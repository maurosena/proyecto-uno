<?php

namespace App\Support;

use App\Models\Movement;
use Exception;
use InvalidArgumentException;

/**
 * Reglas de negocio del inventario.
 *
 * Esta clase NO toca la base de datos ni usa el framework de Laravel,
 * por lo que se puede probar como una UNIDAD pura: rápido y aislado.
 *
 * Antes estas reglas vivían dentro de MovementController y DashboardController
 * (mezcladas con la vista y el HTML). Extraerlas es el primer paso para
 * poder verificarlas con pruebas unitarias.
 */
class InventoryRules
{
    /** Stock igual o menor a este valor se considera CRÍTICO en el dashboard. */
    public const CRITICAL_MAX = 5;

    /** Rango medio del dashboard: de WARNING_MIN a WARNING_MAX. */
    public const WARNING_MIN = 6;

    public const WARNING_MAX = 30;

    /** Con esta cantidad o menos se envía la notificación de stock bajo. */
    public const LOW_STOCK_MAX = 10;

    public const LEVEL_CRITICAL = 'critico';

    public const LEVEL_WARNING = 'advertencia';

    public const LEVEL_NORMAL = 'normal';

    /**
     * Clasifica la cantidad de stock de un producto para el dashboard.
     */
    public function level(float|int $amount): string
    {
        if ($amount <= self::CRITICAL_MAX) {
            return self::LEVEL_CRITICAL;
        }

        if ($amount <= self::WARNING_MAX) {
            return self::LEVEL_WARNING;
        }

        return self::LEVEL_NORMAL;
    }

    /**
     * ¿El producto debe generar la alerta de stock bajo?
     */
    public function isLowStock(float|int $amount): bool
    {
        return $amount <= self::LOW_STOCK_MAX;
    }

    /**
     * Calcula la cantidad de stock resultante después de aplicar un movimiento.
     *
     * @throws Exception si la salida excede el inventario disponible
     * @throws InvalidArgumentException si la cantidad o el tipo no son válidos
     */
    public function applyMovement(float|int $currentAmount, string $type, float|int $quantity): float
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException('La cantidad del movimiento debe ser mayor que cero.');
        }

        return match ($type) {
            Movement::MOVEMENT_TYPE_IN, Movement::MOVEMENT_TYPE_DEVOLUTION => (float) $currentAmount + (float) $quantity,
            Movement::MOVEMENT_TYPE_OUT => $this->applyOutgoing($currentAmount, $quantity),
            default => throw new InvalidArgumentException("Tipo de movimiento no válido: {$type}"),
        };
    }

    private function applyOutgoing(float|int $currentAmount, float|int $quantity): float
    {
        if ($currentAmount < $quantity) {
            throw new Exception('La cantidad solicitada es mayor a la cantidad de inventario');
        }

        return (float) $currentAmount - (float) $quantity;
    }
}
