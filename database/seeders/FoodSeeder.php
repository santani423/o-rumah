<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::where('type', '!=', 'administrator')->get();
        $faker = Faker::create();
        foreach ($users as $user) {
            for ($i = 0; $i < 5; $i++) {


                $title = $faker->sentence;
                $ad = \App\Models\Ads::create([
                    'title' => $title,
                    'slug' => Str::slug($title, '-'),
                    'description' => $faker->paragraphs(2, true),
                    'type' => 'property',
                    'published_at' => now(),
                    'user_id' => $user->id,
                    'is_active' => true,
                    'is_archived' => false,
                    'status' => 'available'
                ]);


                \App\Models\Food::create([
                    'ads_id' => $ad->id,
                    'districtId' => rand(1, 100),
                    'district' => 'Nama Distrik',
                    'districtLocation_lat' => 0.0000000,
                    'districtLocation_long' => 0.0000000,
                    'kawasan' => 'kawasan ' . $i,
                    'price' => 1000000 * $i,
                    'alamat' => 'Alamat ' . $i,
                    'image' => '/assets/food/food-' . rand(1, 3) . '.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                for ($j = 0; $j < 5; $j++) {
                    $n = rand(1, 5);
                    \App\Models\Media::create([
                        'model_type' => 'App\Models\Ad',
                        'model_id' => $ad->id,
                        'collection_name' => 'images',
                        'name' => 'house-' . $n,
                        'file_name' => 'house-' . $n . '.jpg',
                        'mime_type' => 'image/jpeg',
                        'disk' => '/assets/food',
                        'manipulations' => '[]',
                        'custom_properties' => '[]',
                        'generated_conversions' => '[]',
                        'size' => 1024,
                        'responsive_images' => '[]',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
    }
}
