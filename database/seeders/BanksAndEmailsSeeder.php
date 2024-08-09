<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BanksAndEmailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert 3 sample banks
        $banks = [
            [
                'bank' => 'Permata',
                'code' => 'umum_permata',
                'type' => 'umum',
                'alias_name' => 'Permata',
                'address' => 'Jl. Sudirman No. 1',
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'office_type' => 'Head Office',
                'email' => 'info@banka.com',
                'phone' => '021-12345678',
                'image' => 'banka.jpg',
                'details' => 'Bank A adalah bank retail terkemuka.',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bank' => 'Muamalat',
                'code' => 'umum_muamalat',
                'type' => 'umum',
                'alias_name' => 'Muamalat',
                'address' => 'Jl. Gatot Subroto No. 2',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
                'office_type' => 'Branch Office',
                'email' => 'contact@bankb.com',
                'phone' => '022-87654321',
                'image' => 'bankb.jpg',
                'details' => 'Bank B menyediakan layanan korporat.',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bank' => 'Bank Maju',
                'code' => 'BPR_bank_maju',
                'type' => 'BPR',
                'alias_name' => 'Bank Majiu',
                'address' => 'Jl. MH Thamrin No. 3',
                'city' => 'Surabaya',
                'province' => 'Jawa Timur',
                'office_type' => 'Branch Office',
                'email' => 'support@bankc.com',
                'phone' => '031-12398765',
                'image' => 'bankc.jpg',
                'details' => 'Bank C adalah bank investasi global.',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert banks into the banks table
        foreach ($banks as $bank) {
            $bankId = DB::table('banks')->insertGetId($bank);

            // Insert sample emails for each bank
            $emails = [
                [
                    'bank_id' => $bankId,
                    'email' => 'kpr@' . strtolower(str_replace(' ', '', $bank['bank'])) . '.com',
                    'email_type' => 'kpr',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'bank_id' => $bankId,
                    'email' => 'lelang@' . strtolower(str_replace(' ', '', $bank['bank'])) . '.com',
                    'email_type' => 'lelang',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'bank_id' => $bankId,
                    'email' => 'lainnya@' . strtolower(str_replace(' ', '', $bank['bank'])) . '.com',
                    'email_type' => 'lainnya',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            // Insert emails into the email_banks table
            DB::table('email_banks')->insert($emails);
        }
    }
}
