<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Ads;
use App\Models\AdsProperty;
use App\Models\AdsBankLelang;
use App\Models\Media;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;

class LelangSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

      
        // Create sample Ads
        $ads = new Ads();
        $ads->title = 'ini baru'.$faker->sentence(3) . ' - ' . uniqid();
        $ads->slug = Str::slug($ads->title) . '-' . uniqid();
        $ads->description = $faker->paragraph;
        $ads->type = 'lelang';
        $ads->published_at = Carbon::now();
        $ads->user_id = 158;
        $ads->is_active = 1; 
        $ads->is_archived =1;
        $ads->status = 'available';
        $ads->save();

        $ads->uuid = $this->kodeIklanLelang('lelang', 1, $ads->created_at, Ads::whereMonth('created_at', Carbon::now()->month)->count());
        $ads->save();

        // Create sample AdsProperty
        $adsProperty = new AdsProperty();
        $adsProperty->ads_id = (string) $ads->id;
        $adsProperty->district_id = $faker->numberBetween(1, 10);
        $adsProperty->district_name = $faker->city;
        $adsProperty->lat = '-6.1570781';
        $adsProperty->lng = '106.5811157';
        $adsProperty->area = $faker->state;
        $adsProperty->address = $faker->address;
        $adsProperty->ads_type = 'lelang';
        $adsProperty->property_type = $faker->randomElement(['house', 'apartment', 'villa']);
        $adsProperty->price = $faker->numberBetween(100000000, 5000000000); // Random price
        $adsProperty->certificate = $faker->randomElement(['SHM', 'HGB']);
        $adsProperty->year_built = $faker->year;
        $adsProperty->lt = $faker->numberBetween(50, 500);
        $adsProperty->lb = $faker->numberBetween(50, 500);
        $adsProperty->dl = $faker->numberBetween(1300, 5500);
        $adsProperty->jl = $faker->numberBetween(1, 3);
        $adsProperty->jk = $faker->numberBetween(1, 6);
        $adsProperty->jkm = $faker->numberBetween(1, 4);
        $adsProperty->furniture_condition = $faker->randomElement(['Furnished', 'Unfurnished', 'Semi-furnished']);
        $adsProperty->house_facility = json_encode($faker->randomElements(['AC', 'Water Heater', 'Swimming Pool', 'Garage'], 2));
        $adsProperty->other_facility = json_encode($faker->randomElements(['Garden', 'Gym', 'Playground'], 2));
        $adsProperty->video = 'https://youtube.com/' . $faker->word;
        $adsProperty->save();

        // Create sample Media
        $media = new Media();
        $media->model_type = 'App\\Models\\Ads';
        $media->model_id = $ads->id;
        $media->collection_name = 'images';
        $media->name = 'photo_17223828387908304864_0.jpg';
        $media->file_name = $media->name;
        $media->manipulations = '[]';
        $media->custom_properties = '[]';
        $media->generated_conversions = '[]';
        $media->responsive_images = '[]';
        $media->mime_type = 'image/jpeg';
        $media->disk = '/storage/images/properti/merchant/1404';
        $media->size = $faker->numberBetween(1024, 2048);
        $media->save();

        $adsProperty->image = $media->disk . '/' . $media->file_name;
        $adsProperty->save();

        // Create sample AdsBankLelang
        $adsBankLelang = new AdsBankLelang();
        $adsBankLelang->bank_id = 1; // Assuming a bank with ID 1 exists
        $adsBankLelang->ads_id = $ads->id;
        $adsBankLelang->save();
    }

    private function kodeIklanLelang($type, $bank_id, $created_at, $count)
    {
        return strtoupper(substr($type, 0, 3)) . '-' . $bank_id . '-' . $created_at->format('Ym') . '-' . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
    }
}
