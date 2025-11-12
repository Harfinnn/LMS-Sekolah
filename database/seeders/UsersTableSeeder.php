<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'harfinaqbil07@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Guru',
                'email' => 'abilsurabil07@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
