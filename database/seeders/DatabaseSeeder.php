<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use Database\Seeders\ScheduleSeeder;
use Database\Seeders\CourseSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'harfinaqbil07@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Guru
        $gurus = [
            ['Budi Santoso', 'budi@guru.com', 'Matematika'],
            ['Siti Aminah', 'siti@guru.com', 'Bahasa Indonesia'],
            ['Dewi Pratiwi', 'dewi@guru.com', 'Fisika'],
        ];

        foreach ($gurus as $g) {
            $user = User::create([
                'name'     => $g[0],
                'email'    => $g[1],
                'password' => Hash::make('password'),
                'role'     => 'guru'
            ]);

            Guru::create([
                'user_id' => $user->id,
                'mata_pelajaran' => $g[2],
                'phone' => '08123456789',
                'provinsi' => 'Jawa Barat',
                'kabupaten' => 'Bandung',
                'kecamatan' => 'Coblong',
                'kelurahan' => 'Dago',
                'alamat_jalan' => 'Jl. Pendidikan No.1',
                'rt' => '01',
                'rw' => '02',
                'kode_pos' => '40135',
                'kampung' => 'Kampung Ilmu',
            ]);
        }

        // Siswa Dummy
        $students = [
            ['Ali Rahman', 'X', 'A', '1001'],
            ['Rina Putri', 'X', 'B', '1002'],
            ['Tono Hidayat', 'XI', 'A', '1101'],
            ['Sari Puspita', 'XI', 'B', '1102'],
            ['Doni Saputra', 'XII', 'A', '1201'],
            ['Dewi Kartika', 'XII', 'B', '1202'],
        ];

        foreach ($students as $s) {
            $user = User::create([
                'name'     => $s[0],
                'email'    => strtolower(str_replace(' ', '', $s[0])) . '@siswa.com',
                'password' => Hash::make('password'),
                'role'     => 'siswa'
            ]);

            Siswa::create([
                'user_id' => $user->id,
                'nis' => $s[3],
                'kelas' => $s[1],
                'sub_kelas' => $s[2],
                'phone' => '08123400000',
                'provinsi' => 'Jawa Barat',
                'kabupaten' => 'Bandung',
                'kecamatan' => 'Coblong',
                'kelurahan' => 'Dago',
                'alamat_jalan' => 'Jl. Belajar No.2',
                'rt' => '01',
                'rw' => '03',
                'kode_pos' => '40135',
                'kampung' => 'Kampung Masa Depan',
            ]);
        }

        // Panggil seeder tambahan
        $this->call([
            ScheduleSeeder::class,
            CourseSeeder::class,
        ]);
    }
}
