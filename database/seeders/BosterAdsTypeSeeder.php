<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BosterAdsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('boster_ads_t_ypes')->insert([
            [
                'code' => 'PTYHOME',
                'slug' => 'home-property',
                'type' => 'property',
                'title' => 'property homepage',
                'limit' => 5,
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'PTYESKL',
                'slug' => 'esklusif-property',
                'type' => 'property',
                'title' => 'esklusif property',
                'limit' => 5,
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'PTYSDL',
                'slug' => 'sundul-property',
                'type' => 'property',
                'title' => 'sundul-property',
                'limit' => 5,
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Adding sample data for food
            [
                'code' => 'FOODDL',
                'slug' => 'daily-food',
                'type' => 'food',
                'title' => 'daily food ads',
                'limit' => 3,
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'FOODESKL',
                'slug' => 'exclusive-food',
                'type' => 'food',
                'title' => 'exclusive food ads',
                'limit' => 3,
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'FOODSDL',
                'slug' => 'promo-food',
                'type' => 'food',
                'title' => 'promo food ads',
                'limit' => 3,
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Adding sample data for merchant
            [
                'code' => 'MCHHOME',
                'slug' => 'home-merchant',
                'type' => 'merchant',
                'title' => 'merchant homepage',
                'limit' => 4,
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'MCHESKL',
                'slug' => 'exclusive-merchant',
                'type' => 'merchant',
                'title' => 'exclusive merchant ads',
                'limit' => 4,
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'MCHSDL',
                'slug' => 'promo-merchant',
                'type' => 'merchant',
                'title' => 'promo merchant ads',
                'limit' => 4,
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
