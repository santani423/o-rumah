<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateUserIsBlockedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Update users where the email contains 'example' to set is_blocked to 1
        DB::table('users')
            ->where('email', 'LIKE', '%example%')
            ->update(['is_blocked' => 1]);

        // $this->command->info('Updated is_blocked to 1 for users with "example" in their email.');
    }
}

