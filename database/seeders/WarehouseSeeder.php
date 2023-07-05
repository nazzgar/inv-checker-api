<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Database\Factories\WarehouseFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warehouses = ['Warszawa', 'Kraków', 'Wrocław', 'Gdynia', 'Poznań'];

        foreach ($warehouses as $warhouse) {
            Warehouse::create(['name' => $warhouse]);
        }
    }
}
