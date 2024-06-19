<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravolt\Indonesia\Seeds\CitiesSeeder;
use Laravolt\Indonesia\Seeds\DistrictsSeeder;
use Laravolt\Indonesia\Seeds\ProvincesSeeder;
use Laravolt\Indonesia\Seeds\VillagesSeeder;
use MatanYadaev\EloquentSpatial\Objects\Point;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProvincesSeeder::class,
            CitiesSeeder::class,
            DistrictsSeeder::class,
            VillagesSeeder::class,
            TestSeeder::class,
        ]);

        // create faker instance
        $faker = Faker::create('id_ID');

        $this->command->info('Seeding banner...');

        foreach (range(1, 5) as $idx) {
            \App\Models\Banner::create([
                'name' => 'Banner ' . $idx,
                'description' => $faker->sentence(),
                'url' => $faker->url(),
                'image' => $faker->imageUrl(1120, 340, 'banner', true),
                'is_active' => true,
                'order' => $idx,
            ]);
        }

        $this->command->info('Seeding company...');

        // create at least 5 company using faker
        foreach (range(1, 5) as $idx) {
            \App\Models\Company::create([
                'name' => $faker->company(),
                'email' => $faker->email(),
                'phone' => $faker->phoneNumber(),
                'address' => $faker->address(),
                'image' => $faker->imageUrl(150, 150, 'company', true),
                'website' => $faker->url(),
            ]);
        }

        $this->command->info('Seeding users...');

        // create at least 25 user between user or agent
        foreach (range(1, 25) as $idx) {
            $type = $faker->randomElement(['user', 'agent']);

            \App\Models\User::create([
                'name' => ucfirst($type) . ' ' . $idx,
                'username' => $type . '-' . $idx,
                'phone' => $faker->phoneNumber(),
                'email' => $type . '-' . $idx . '@orumah.com',
                'password' => bcrypt('password'),
                'image' => $faker->imageUrl(150, 150, 'company', true),
                'bio' => $faker->sentence(),
                'address' => 'Address ' . $idx,
                'type' => $type,
                'company_id' => $type === 'agent' ? \App\Models\Company::inRandomOrder()->first()->id : null,
            ]);
        }

        $this->command->info('Seeding property types...');

        // create property types (only 3 for now)
        \App\Models\PropertyType::insert([
            [
                'name' => 'Rumah',
                'slug' => 'rumah',
                'description' => 'Rumah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Apartemen',
                'slug' => 'apartemen',
                'description' => 'Apartemen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tanah',
                'slug' => 'tanah',
                'description' => 'Tanah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('Seeding ads...');

        // create at least 1000 ads
        foreach (range(1, 10) as $idx) {

            // Create ads
            $ads = \App\Models\Ads::create([
                'title' => 'Ads ' . $idx,
                'slug' => 'ads-' . $idx,
                'description' => $faker->sentence(),
                'type' => 'property',
                'published_at' => $faker->dateTimeBetween('-3 months', now()),
                'points' => 200,
                'is_active' => true,
                'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            ]);

            // Add media
            $ads->addMediaFromUrl('https://picsum.photos/1920/1080.jpg')
                ->setFilename('image-' . $idx . '.jpg')
                ->toMediaCollection('ads');
            $ads->addMediaFromUrl('https://picsum.photos/1920/1080.jpg')
                ->setFilename('image-' . $idx . '.jpg')
                ->toMediaCollection('ads');
            // $ads->addMediaFromUrl('https://picsum.photos/1920/1080.jpg')
            //     ->setFilename('image-' . $idx . '.jpg')
            //     ->toMediaCollection('ads');
            // $ads->addMediaFromUrl('https://picsum.photos/1920/1080.jpg')
            //     ->setFilename('image-' . $idx . '.jpg')
            //     ->toMediaCollection('ads');
            // $ads->addMediaFromUrl('https://picsum.photos/1920/1080.jpg')
            //     ->setFilename('image-' . $idx . '.jpg')
            //     ->toMediaCollection('ads');
            // $ads->addMediaFromUrl('https://picsum.photos/1920/1080.jpg')
            //     ->setFilename('image-' . $idx . '.jpg')
            //     ->toMediaCollection('ads');

            // Add property
            $district = \Laravolt\Indonesia\Models\District::inRandomOrder()->first();
            $lat = $faker->latitude();
            $lng = $faker->longitude();

            $propertyType = \App\Models\PropertyType::whereIn('name', ['Rumah', 'Apartemen'])->inRandomOrder()->first();

            $furnishedConditionArray = \App\Models\AdsProperty::getFurnishedCondition();
            $certificatesArray = \App\Models\AdsProperty::getAllCertificates();
            $houseFacilityArray = \App\Models\AdsProperty::getAllHouseFacility();
            $otherFacilityArray = \App\Models\AdsProperty::getAllOtherFacility();
            $adsType = $faker->randomElement(['Jual', 'Sewa']);

            \App\Models\AdsProperty::create([
                'ads_id' => $ads->id,
                'district_id' => $district?->id,
                'district_name' => $district?->name,
                'lat' => $lat,
                'lng' => $lng,
                'location' => new Point($lat, $lng),
                'area' => $faker->streetName() . ', ' . $district->name,
                'address' => $faker->streetAddress(),
                'ads_type' => $adsType,
                'rent_type' => $adsType === 'Sewa' ? $faker->randomElement(['Bulan', 'Tahun']) : null,
                'property_type_id' => $propertyType->id,
                'property_type' => $propertyType->name,
                'price' => $faker->numberBetween(50_000_000, 2_350_000_000),
                'certificate' => $faker->randomElement($certificatesArray),
                'housing_name' => $faker->words(2, true),
                'cluster_name' => $faker->words(2, true),
                'year_built' => $faker->numberBetween(1998, now()->year),
                'lt' => $faker->numberBetween(50, 300),
                'lb' => $faker->numberBetween(50, 300),
                'dl' => $faker->randomElement([900, 1100, 1300, 2000, 3300]),
                'jl' => $faker->randomElement([1, 2, 3, 4]),
                'jk' => $faker->randomElement([1, 2, 3, 4]),
                'jkm' => $faker->randomElement([1, 2, 3, 4]),
                'furniture_condition' => $faker->randomElement($furnishedConditionArray),
                'house_facility' => json_encode($faker->randomElements($houseFacilityArray, $faker->numberBetween(1, count($houseFacilityArray)))),
                'other_facility' => json_encode($faker->randomElements($otherFacilityArray, $faker->numberBetween(1, count($otherFacilityArray)))),
                'video' => 'https://www.youtube.com/watch?v=uedb8o-iZ0c',
            ]);
        }
    }
}
// php artisan db:seed --class=PropertiBaruSeeder