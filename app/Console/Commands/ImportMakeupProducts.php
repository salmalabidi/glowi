<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\Category;

class ImportMakeupProducts extends Command
{
    protected $signature = 'makeup:import';
    protected $description = 'Importe les produits maquillage depuis l\'API';

    public function handle()
    {
        $this->info('📥 Import des produits maquillage...');

        $category = Category::where('slug', 'maquillage')->first();

        $types = [
            'lipstick', 'foundation', 'eyeshadow',
            'mascara', 'blush', 'eyeliner', 'bronzer', 'nail_polish'
        ];

        $total = 0;

        foreach ($types as $type) {
            $this->info("→ Récupération : $type");

            $response = Http::get('http://makeup-api.herokuapp.com/api/v1/products.json', [
                'product_type' => $type
            ]);

            if (!$response->successful()) continue;

            $products = $response->json();

            foreach ($products as $p) {
                Product::updateOrCreate(
                    [
                        'name'   => $p['name'],
                        'source' => 'api'
                    ],
                    [
                        'category_id'  => $category->id,
                        'description'  => $p['description'] ?? 'Produit maquillage',
                        'price'        => is_numeric($p['price']) && $p['price'] > 0
                                            ? $p['price']
                                            : rand(10, 50),
                        'brand'        => $p['brand'] ?? null,
                        'product_type' => $type,
                        'image'        => $p['image_link'] ?? null,
                        'source'       => 'api',
                        'stock'        => 15,
                        'active'       => true,
                    ]
                );
                $total++;
            }
        }

        $this->info("✅ Import terminé ! $total produits importés.");
    }
}