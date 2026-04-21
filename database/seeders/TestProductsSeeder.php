<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestProductsSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Créer ou récupérer les catégories
        $existingSkincare = DB::table('categories')->where('slug', 'skincare')->first();
        $existingMakeup = DB::table('categories')->where('slug', 'maquillage')->first();

        if (! $existingSkincare) {
            $skincareId = DB::table('categories')->insertGetId([
                'name' => 'Skincare',
                'slug' => 'skincare',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        } else {
            $skincareId = $existingSkincare->id;
        }

        if (! $existingMakeup) {
            $makeupId = DB::table('categories')->insertGetId([
                'name' => 'Maquillage',
                'slug' => 'maquillage',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        } else {
            $makeupId = $existingMakeup->id;
        }

        // Ajouter 2 produits de test seulement s'ils n'existent pas déjà
        $serumExists = DB::table('products')->where('name', 'Serum Eclat Rose')->exists();
        $rougeExists = DB::table('products')->where('name', 'Rouge Velours Nude')->exists();

        if (! $serumExists) {
            DB::table('products')->insert([
                'name' => 'Serum Eclat Rose',
                'brand' => 'Glowi',
                'description' => 'Serum hydratant pour une peau lumineuse, douce et eclatante au quotidien.',
                'price' => 89.90,
                'image' => null,
                'category_id' => $skincareId,
                'product_type' => 'Serum',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        if (! $rougeExists) {
            DB::table('products')->insert([
                'name' => 'Rouge Velours Nude',
                'brand' => 'Glowi',
                'description' => 'Rouge a levres longue tenue avec une texture velours elegante et confortable.',
                'price' => 54.50,
                'image' => null,
                'category_id' => $makeupId,
                'product_type' => 'Gloss',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}