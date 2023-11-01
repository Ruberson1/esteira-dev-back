<?php

namespace Database\Seeders;

use App\Models\Category\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'BLOCKER'],
            ['name' => 'CRITICO'],
            ['name' => 'GRAVE'],
            ['name' => 'MODERADO'],
            ['name' => 'PEQUENO']
        ];

        Category::insert($categories);
    }
}