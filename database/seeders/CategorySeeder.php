<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Skincare',     'slug' => 'skincare'],
            ['name' => 'Maquillage',   'slug' => 'maquillage'],
            ['name' => 'Accessoires',  'slug' => 'accessoires'],
            ['name' => 'Parfums',      'slug' => 'parfums'],
            ['name' => 'Corps',        'slug' => 'corps'],
            ['name' => 'Cheveux',      'slug' => 'cheveux'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
