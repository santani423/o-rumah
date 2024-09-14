<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdateUserPasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tentukan email yang akan diperbarui
        $email = 'admin@gmail.com'; // ganti dengan email yang sesuai
        
        // Password baru
        $newPassword = '1234567890'; // ganti dengan password yang baru

        // Update password berdasarkan email
        DB::table('users')
            ->where('email', $email)
            ->update(['password' => Hash::make($newPassword)]);

        $this->command->info('Password berhasil diperbarui untuk email: ' . $email);
    }
}
// php artisan db:seed --class=UpdateUserPasswordSeeder
