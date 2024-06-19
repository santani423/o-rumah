<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Merchant;
use App\Models\KategoriMarchent;
use App\Models\Kategori;
use App\Models\SupKategori;

class SetKategoriMarchentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foods = Merchant::all();

        foreach ($foods as $fd) {
            $existingKategoriMarchnt = KategoriMarchent::where('marchent_id', $fd->id)->first();
            if (!$existingKategoriMarchnt) {
                for ($i = 0; $i < rand(1, 3); $i++) {
                    $kategori = Kategori::where('tipe', 'merchant')->inRandomOrder()->first();
                    for ($h = 0; $h < rand(1, 3); $h++) {
                        $subKategori = SupKategori::where('kategori_id', $kategori->id)->inRandomOrder()->first();
                        $newKategori = new KategoriMarchent();
                        $newKategori->kategori_id = $subKategori->id;
                        $newKategori->marchent_id = $fd->id;
                        $newKategori->save();
                    }
                }
            }
        }
    }
}
// php artisan db:seed --class=SetKategoriMarchentSeeder
// 