<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'user_type' => 'admin',
                'fname' => 'InspireSports',
                'lname' => 'Academy',
                'username' => 'ISA',
                'email' => 'inspiresportsa@gmail.com',
                'password' => Hash::make("ISAPhilippines"),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_type' => 'user',
                'fname' => 'Anthony',
                'lname' => 'Jennings',
                'username' => 'AnthonyJennings',
                'email' => 'user@com',
                'password' => Hash::make("Password"),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
