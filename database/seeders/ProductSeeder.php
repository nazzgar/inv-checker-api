<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()->count(100)->create()->each(fn(Product $model) => $model->authors()->attach(Author::all()->random(rand(1, 3))));
    }
}
