<?php

namespace Database\Factories;

use App\Models\Product;
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
            'name' => fake()->paragraph(1),
            'description' => fake()->paragraph(6),
            'ean' => fake()->ean13(),
            'sku' => fake()->uuid(),
        ];
    }
}
