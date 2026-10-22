<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => 'P-'.fake()->unique()->numerify('####'),
            'name' => fake()->words(3, true),
            'amount' => fake()->numberBetween(0, 200),
            'unit' => fake()->randomElement(['und', 'kg', 'lt', 'caja']),
            'price' => fake()->randomFloat(2, 5_000, 900_000),
            'provider_id' => Provider::factory(),
        ];
    }

    /**
     * Producto con stock crítico (amount <= 5).
     */
    public function critical(): static
    {
        return $this->state(fn () => ['amount' => fake()->numberBetween(1, 5)]);
    }

    /**
     * Producto con stock medio / en advertencia (amount entre 6 y 30).
     */
    public function warning(): static
    {
        return $this->state(fn () => ['amount' => fake()->numberBetween(6, 30)]);
    }

    /**
     * Producto con stock normal (amount > 30).
     */
    public function normal(): static
    {
        return $this->state(fn () => ['amount' => fake()->numberBetween(31, 200)]);
    }

    /**
     * Producto que dispara la alerta de stock bajo (amount <= 10).
     */
    public function lowStock(): static
    {
        return $this->state(fn () => ['amount' => fake()->numberBetween(1, 10)]);
    }

    /**
     * Producto que NO dispara la alerta de stock bajo (amount > 10).
     */
    public function healthyStock(): static
    {
        return $this->state(fn () => ['amount' => fake()->numberBetween(11, 200)]);
    }
}
