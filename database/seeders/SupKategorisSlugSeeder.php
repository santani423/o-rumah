<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SupKategorisSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategoris = DB::table('sup_kategoris')->get();

        foreach ($kategoris as $kategori) {
            $slug = Str::slug($kategori->nama);
            DB::table('sup_kategoris')
                ->where('id', $kategori->id)
                ->update(['slug' => $slug]);
        }
    }
}
