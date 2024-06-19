<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KategoriFoodSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Fruits' => ['Citrus', 'Berries', 'Tropical'],
            'Vegetables' => ['Leafy Greens', 'Root Vegetables', 'Cruciferous'],
            'Meat' => ['Red Meat', 'Poultry', 'Seafood'],
            'Dairy' => ['Milk', 'Cheese', 'Yogurt'],
            'Grains' => ['Whole Grains', 'Refined Grains', 'Pseudocereals'],
            'Beverages' => ['Non-Alcoholic', 'Alcoholic', 'Hot Beverages'],
        ];

        foreach ($categories as $categoryName => $subCategories) {
            $categoryId = DB::table('kategoris')->insertGetId([
                'nama' => $categoryName,
                'tipe' => 'food',
                'gambar' => 'default.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            foreach ($subCategories as $subCategoryName) {
                DB::table('sup_kategoris')->insert([
                    'kategori_id' => $categoryId,
                    'nama' => $subCategoryName,
                    'gambar' => 'default.jpg',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
// php artisan db:seed --class=KategoriFoodSeeder
