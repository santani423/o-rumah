<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KategoriMarchantSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Electronics' => ['Mobile Phones', 'Laptops', 'Cameras'],
            'Fashion' => ['Men\'s Clothing', 'Women\'s Clothing', 'Accessories'],
            'Home & Kitchen' => ['Furniture', 'Home Decor', 'Kitchen Appliances'],
            'Beauty & Personal Care' => ['Skincare', 'Hair Care', 'Makeup'],
            'Sports & Outdoors' => ['Fitness Equipment', 'Outdoor Gear', 'Sportswear'],
            'Books & Stationery' => ['Fiction', 'Non-Fiction', 'Stationery'],
        ];

        foreach ($categories as $categoryName => $subCategories) {
            $categoryId = DB::table('kategoris')->insertGetId([
                'nama' => $categoryName,
                'tipe' => 'merchant',
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
