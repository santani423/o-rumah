<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
        ]);
    }
}
