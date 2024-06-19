<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        \App\Models\WebsiteAdsContent::truncate();
        \App\Models\WebsiteAdsSection::truncate();
        Schema::enableForeignKeyConstraints();

        // create faker instance
        $faker = Faker::create('id_ID');

        $homepageAds = \App\Models\WebsiteAdsSection::create([
            'name' => 'Iklan Homepage (bawah search)',
            'slug' => slugify('Iklan Homepage (bawah search)'),
            'description' => 'Iklan Homepage (bawah search)',
            'location' => 'homepage',
            'is_active' => true
        ]);

        \App\Models\WebsiteAdsContent::create([
            'name' => 'Iklan utama (sisi kiri)',
            'slug' => slugify('Iklan utama (sisi kiri)'),
            'description' => 'Iklan utama (sisi kiri)',
            'website_ads_section_id' => $homepageAds->id,
            'url' => 'https://google.com',
            'image' => 'https://via.placeholder.com/400x224',
            'location' => 'homepage-ads-left',
            'is_active' => true
        ]);

        \App\Models\WebsiteAdsContent::create([
            'name' => 'Iklan utama (sisi kanan)',
            'slug' => slugify('Iklan utama (sisi kanan)'),
            'description' => 'Iklan utama (sisi kanan)',
            'website_ads_section_id' => $homepageAds->id,
            'url' => 'https://google.com',
            'image' => 'https://via.placeholder.com/400x224',
            'location' => 'homepage-ads-right',
            'is_active' => true
        ]);

        $listingAds = \App\Models\WebsiteAdsSection::create([
            'name' => 'Iklan di listing (sisi kanan)',
            'slug' => slugify('Iklan di listing (sisi kanan)'),
            'description' => 'Iklan di listing (sisi kanan)',
            'location' => 'jual',
            'is_active' => true
        ]);

        \App\Models\WebsiteAdsContent::create([
            'name' => 'Iklan listing 1',
            'slug' => slugify('Iklan listing 1'),
            'description' => 'Iklan listing 1',
            'website_ads_section_id' => $listingAds->id,
            'url' => 'https://google.com',
            'image' => 'https://via.placeholder.com/260x530',
            'location' => 'listing-ads-1',
            'is_active' => true
        ]);

        \App\Models\WebsiteAdsContent::create([
            'name' => 'Iklan listing 2',
            'slug' => slugify('Iklan listing 2'),
            'description' => 'Iklan listing 2',
            'website_ads_section_id' => $listingAds->id,
            'url' => 'https://google.com',
            'image' => 'https://via.placeholder.com/260x530',
            'location' => 'listing-ads-2',
            'is_active' => true
        ]);
    }
}
