<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Added this line to access the User model
use App\Models\AdBalance; // Added this line to access the User model

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'username' => 'admin',
                'phone' => '081234567890',
                'wa_phone' => '081234567891',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('1234567890'), // Changed this line
                'timezone' => 'UTC',
                'type' => 'administrator',
                'is_active' => 1,
                'is_blocked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($users as $user) {
            User::create($user); // Use the User model to insert data
        }
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'username' => $faker->userName,
                'phone' => $faker->unique()->phoneNumber,
                'wa_phone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Default password
                'remember_token' => Str::random(10),
                'timezone' => 'UTC',
                'image' => $faker->imageUrl,
                'bio' => $faker->sentence,
                'address' => $faker->address,
                'type' => 'agen',
                'is_active' => 1,
                'is_blocked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $poin = new AdBalance();
            $poin->user_id = $user->id;
            $poin->balance = rand(100, 500);
            $poin->save();
        }
        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'username' => $faker->userName,
                'phone' => $faker->unique()->phoneNumber,
                'wa_phone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Default password
                'remember_token' => Str::random(10),
                'timezone' => 'UTC',
                'image' => $faker->imageUrl,
                'bio' => $faker->sentence,
                'address' => $faker->address,
                'type' => 'food',
                'is_active' => 1,
                'is_blocked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $poin = new AdBalance();
            $poin->user_id = $user->id;
            $poin->balance = rand(100, 500);
            $poin->save();
        }
        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'username' => $faker->userName,
                'phone' => $faker->unique()->phoneNumber,
                'wa_phone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Default password
                'remember_token' => Str::random(10),
                'timezone' => 'UTC',
                'image' => $faker->imageUrl,
                'bio' => $faker->sentence,
                'address' => $faker->address,
                'type' => 'notaris',
                'is_active' => 1,
                'is_blocked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $poin = new AdBalance();
            $poin->user_id = $user->id;
            $poin->balance = rand(100, 500);
            $poin->save();
        }
        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'username' => $faker->userName,
                'phone' => $faker->unique()->phoneNumber,
                'wa_phone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Default password
                'remember_token' => Str::random(10),
                'timezone' => 'UTC',
                'image' => $faker->imageUrl,
                'bio' => $faker->sentence,
                'address' => $faker->address,
                'type' => 'lbh',
                'is_active' => 1,
                'is_blocked' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $poin = new AdBalance();
            $poin->user_id = $user->id;
            $poin->balance = rand(100, 500);
            $poin->save();
        }
    }
}

// php artisan db:seed --class=userSeeder
