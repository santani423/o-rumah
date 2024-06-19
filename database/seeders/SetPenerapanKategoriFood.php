<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Food;
use App\Models\KategoriFood;
use App\Models\Kategori;
use App\Models\SupKategori;

class SetPenerapanKategoriFood extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foods = Food::all();

        foreach ($foods as $fd) {
            $existingKategoriFood = KategoriFood::where('oFood_id', $fd->id)->first();
            if (!$existingKategoriFood) {
                for ($i = 0; $i < rand(1, 3); $i++) {
                    $kategori = Kategori::where('tipe', 'food')->inRandomOrder()->first();
                    for ($h = 0; $h < rand(1, 3); $h++) {
                        $subKategori = SupKategori::where('kategori_id', $kategori->id)->inRandomOrder()->first();
                        $newKategoriFood = new KategoriFood();
                        $newKategoriFood->kategori_id = $subKategori->id;
                        $newKategoriFood->oFood_id = $fd->id;
                        $newKategoriFood->save();
                    }
                }
            }
        }
    }
}

// php artisan db:seed --class=SetPenerapanKategoriFood