<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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

        foreach ($authors as $author_name) {
            Author::create([
                'name' => $author_name
            ]);
        }
    }
}
