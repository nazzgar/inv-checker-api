<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * TODO: use batch insert to speed up seeding
     * @link https://laravelproject.com/how-to-seed-records-in-laravel-quickly/
     */
    public function run(): void
    {
        Product::factory()->count(100000)->create()->each(fn(Product $model) => $model->authors()->attach(Author::all()->random(rand(1, 3))));
    }
}
