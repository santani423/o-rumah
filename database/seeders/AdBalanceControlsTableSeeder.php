<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdBalanceControlsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adBalanceControls = [
            ['code' => 'ABC001', 'title' => 'Ads KPR', 'klik' => 0, 'nilai' => 10, 'description' => 'Description for Ad Campaign 1'],
            ['code' => 'ABC002', 'title' => 'Ads Titip', 'klik' => 0, 'nilai' => 3, 'description' => 'Description for Ad Campaign 2'],
            ['code' => 'ABC003', 'title' => 'Ads Group Supplier', 'klik' => 0, 'nilai' => 0, 'description' => 'Description for Ad Campaign 3'],
            ['code' => 'ABC004', 'title' => 'Ads Export Import', 'klik' => 0, 'nilai' => 0, 'description' => 'Description for Ad Campaign 4'],
            ['code' => 'ABC005', 'title' => 'Ads Chart', 'klik' => 0, 'nilai' => 0, 'description' => 'Description for Ad Campaign 5'],
            ['code' => 'ABC006', 'title' => 'Ads Project Developer', 'klik' => 350, 'nilai' => 175, 'description' => 'Description for Ad Campaign 6'],
            ['code' => 'ABC007', 'title' => 'Ads Klik', 'klik' => 10, 'nilai' => 1, 'description' => 'Description for Ad Campaign 7'],
            ['code' => 'ABC008', 'title' => 'Ambil Lelang', 'klik' => 10, 'nilai' => 1, 'description' => 'Description for Ad Campaign 8'],
            ['code' => 'ABC014', 'title' => 'Titip Ads', 'klik' => 1, 'nilai' => 1, 'description' => 'Titip Ads'],
        ];

        foreach ($adBalanceControls as $control) {
            DB::table('ad_balace_controls')->updateOrInsert(
                ['code' => $control['code']], // Search for this condition
                array_merge($control, ['created_at' => now(), 'updated_at' => now()]) // Insert/update with this data
            );
        }

        // To run: php artisan db:seed --class=AdBalanceControlsTableSeeder
    }
}
