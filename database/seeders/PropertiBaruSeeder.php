<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\AdsProperty;
use App\Models\Ads;
use Carbon\Carbon;

class PropertiBaruSeeder extends Seeder
{
    /**
     * Run the database seeds. php artisan db:seed --class=PropertiBaruSeeder
     */
    public function run(): void
    {
        $users = \App\Models\User::where('type', '!=', 'administrator')->get();
        $faker = Faker::create();
        foreach ($users as $user) {
            for ($i = 0; $i < 5; $i++) {


                $title = $faker->sentence;
                $ad = Ads::create([
                    'title' => '12345'.$title,
                    'slug' => Str::slug($title, '-'),
                    'description' => $faker->paragraphs(2, true),
                    'type' => 'property',
                    'published_at' => now(),
                    'user_id' => $user->id,
                    'is_active' => true,
                    'is_archived' => false,
                    'status' => 'available'
                ]);
                $ad->uuid = Str::uuid() . '-' . str_pad(Ads::whereMonth('created_at', Carbon::now()->month)->count(), 5, '0', STR_PAD_LEFT);
                $ad->save();

                $house_facility = 'Fasilitas ' . rand(1, 10);
                // echo "House Facility: " . $house_facility . "\n"; // Menambahkan pencetakan untuk debugging

                $AdsProperty = AdsProperty::create([
                    'ads_id' => $ad->id,
                    'district_id' => rand(1, 100), // Contoh nilai random untuk district_id
                    'district_name' => 'Nama Distrik',
                    'lat' => -6.207168,
                    'lng' => 106.622738,
                    'location' => DB::raw("ST_GeomFromText('POINT(0 0)')"),
                    'area' => 'Area ' . $i,
                    'address' => 'Alamat ' . $i,
                    'ads_type' => 'Jual',
                    'property_type' => 'Rumah',
                    'rent_type' => 'Bulanan',
                    'price' => 1000000 * $i,
                    'certificate' => 'SHM',
                    'housing_name' => 'Perumahan ' . rand(1, 50), // Contoh nilai random untuk housing_name
                    'cluster_name' => 'Cluster ' . rand(1, 20), // Contoh nilai random untuk cluster_name
                    'year_built' => rand(1990, 2020), // Contoh nilai random untuk year_built
                    'lt' => rand(50, 200), // Contoh nilai random untuk lt
                    'lb' => rand(50, 200), // Contoh nilai random untuk lb
                    'dl' => rand(1, 10), // Contoh nilai random untuk dl
                    'jl' => rand(1, 10), // Contoh nilai random untuk jl
                    'jk' => rand(1, 5), // Contoh nilai random untuk jk
                    'jkm' => rand(1, 5), // Contoh nilai random untuk jkm
                    'apartment_type' => 'Tipe ' . rand(1, 3), // Contoh nilai random untuk apartment_type
                    'floor_location' => rand(1, 10), // Contoh nilai random untuk floor_location
                    'furniture_condition' => (rand(0, 1) == 1 ? 'Furnished' : 'Unfurnished'), // Contoh nilai random untuk furniture_condition
                    // 'house_facility' => $house_facility,
                    // 'other_facility' => 'Fasilitas Lain ' . rand(1, 10), // Contoh nilai random untuk other_facility
                    'video' => 'https://www.youtube.com/embed/iwN-gDjbC88?si', // Contoh nilai random untuk video
                    'image' => '/assets/properties/house-' . rand(1, 5) . '.jpg', // Contoh nilai random untuk image
                    'created_at' => now(),
                    'updated_at' => now(),
                    // 'property_type_id' => rand(1, 10) // Contoh nilai random untuk property_type_id
                ]);
                $AdsProperty->uuid = Str::uuid() . '-' . str_pad(AdsProperty::whereMonth('created_at', Carbon::now()->month)->count(), 5, '0', STR_PAD_LEFT);
                $AdsProperty->save();

                for ($j = 0; $j < 5; $j++) {
                    $n = rand(1, 5);
                    \App\Models\Media::create([
                        'model_type' => 'App\Models\Ad',
                        'model_id' => $ad->id,
                        'collection_name' => 'images',
                        'name' => 'house-' . $n,
                        'file_name' => 'house-' . $n . '.jpg',
                        'mime_type' => 'image/jpeg',
                        'disk' => '/assets/properties',
                        'manipulations' => '[]',
                        'custom_properties' => '[]',
                        'generated_conversions' => '[]',
                        'size' => 1024,
                        'responsive_images' => '[]', // Menambahkan nilai default
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
    }
}
