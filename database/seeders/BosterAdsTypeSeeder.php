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
                'code' => Str::random(10),
                'slug' => Str::slug('Sample Slug 1'),
                'type' => 'Type1',
                'title' => 'Sample Title 1',
                'limit' => 100,
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => Str::random(10),
                'slug' => Str::slug('Sample Slug 2'),
                'type' => 'Type2',
                'title' => 'Sample Title 2',
                'limit' => 200,
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => Str::random(10),
                'slug' => Str::slug('Sample Slug 3'),
                'type' => 'Type3',
                'title' => 'Sample Title 3',
                'limit' => 300,
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
