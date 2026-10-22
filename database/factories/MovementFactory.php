<?php

namespace Database\Factories;

use App\Models\Movement;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Movement>
 */
class MovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => Movement::MOVEMENT_TYPE_IN,
            'amount' => fake()->numberBetween(1, 10),
            'sale_point' => fake()->randomElement(['Caja 1', 'Caja 2', 'Bodega central']),
            'product_id' => Product::factory(),
        ];
    }

    /**
     * Movimiento de entrada de mercancía.
     */
    public function entrada(): static
    {
        return $this->state(fn () => ['type' => Movement::MOVEMENT_TYPE_IN]);
    }

    /**
     * Movimiento de salida de mercancía.
     */
    public function salida(): static
    {
        return $this->state(fn () => ['type' => Movement::MOVEMENT_TYPE_OUT]);
    }

    /**
     * Movimiento de devolución de mercancía.
     */
    public function devolucion(): static
    {
        return $this->state(fn () => ['type' => Movement::MOVEMENT_TYPE_DEVOLUTION]);
    }
}
