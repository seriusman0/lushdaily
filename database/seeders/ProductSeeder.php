<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = config('products');

        foreach ($products as $index => $item) {
            Product::updateOrCreate(
                ['id' => $item['id']],
                [
                    'caption'    => $item['caption'],
                    'image'      => $item['image'],
                    'is_active'  => true,
                    'sort_order' => $index,
                ]
            );
        }
    }
}
