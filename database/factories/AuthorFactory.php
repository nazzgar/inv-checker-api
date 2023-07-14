<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $authors = [
            'Remigiusz Mróz',
            'Henryk Sienkiewicz',
            'J.K. Rowling',
            'Adam Mickiewicz',
            'Nicholas Sparks',
            'Harlan Coben',
            'Jo Nesbø',
            'Stephen King',
            'Aleksander Kamiński',
            'Katarzyna Bonda',
            'Adam Dzierżek'
        ];

        $random_key = array_rand($authors, 1);

        return [
            'name' => $authors[$random_key]
        ];
    }
}
