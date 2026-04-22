<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Skincare', 'slug' => 'skincare'],
            ['name' => 'Maquillage', 'slug' => 'maquillage'],
            ['name' => 'Accessoires', 'slug' => 'accessoires'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}