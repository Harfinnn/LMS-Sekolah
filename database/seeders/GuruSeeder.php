<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => bcrypt('password123'),
            'role' => 'guru',
        ]);

        Guru::create([
            'user_id' => $user->id,
            'mata_pelajaran' => 'Matematika',
            'phone' => '081234567890',
            'alamat' => 'Jakarta',
        ]);
    }
}
