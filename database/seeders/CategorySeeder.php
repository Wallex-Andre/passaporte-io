<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Tecnologia',
            'Música',
            'Negócios',
            'Esportes',
            'Arte',
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate([
                'name' => $category,
            ]);
        }
    }
}