<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;

class JobsTableSeeder extends Seeder
{
    public function run()
    {
        Job::create([
            'title' => 'Pengembang Perangkat Lunak',
            'description' => 'Mengembangkan dan memelihara perangkat lunak.'
        ]);

        Job::create([
            'title' => 'Pengajar',
            'description' => 'Mengajar di berbagai jenjang pendidikan.'
        ]);

        Job::create([
            'title' => 'Petani',
            'description' => 'Bertanggung jawab atas budidaya tanaman dan pemeliharaan tanaman.'
        ]);

        Job::create([
            'title' => 'Pedagang',
            'description' => 'Menjual barang atau jasa di pasar atau toko.'
        ]);

        Job::create([
            'title' => 'Perawat',
            'description' => 'Memberikan perawatan dan dukungan medis kepada pasien.'
        ]);

        Job::create([
            'title' => 'Pengemudi Ojek Online',
            'description' => 'Mengantar penumpang atau barang ke tujuan yang diinginkan.'
        ]);

        Job::create([
            'title' => 'Pekerja Konstruksi',
            'description' => 'Membangun dan memelihara infrastruktur atau bangunan.'
        ]);

        Job::create([
            'title' => 'Pegawai Bank',
            'description' => 'Menyediakan layanan keuangan kepada nasabah.'
        ]);

        Job::create([
            'title' => 'Pengusaha Mikro, Kecil, dan Menengah (UMKM)',
            'description' => 'Mengelola dan mengembangkan usaha kecil dan menengah.'
        ]);

        Job::create([
            'title' => 'Pekerja Pariwisata',
            'description' => 'Menyediakan layanan di sektor pariwisata, seperti pemandu wisata, hotel, dan restoran.'
        ]);
    }
}
