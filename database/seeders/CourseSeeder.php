<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Course::insert([
            [
                'subject'          => 'Programming',
                'title'            => 'Pertemuan 1 : Introduction HTML',
                'grade_level'      => 'X',
                'class_group'      => 'A',
                'category'         => 'video',
                'video_url'        => 'https://www.youtube.com/watch?v=pQN-pnXPaVg',
                'short_description'=> 'Pengenalan dasar HTML dan struktur dokumen web pertama.',
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'subject'          => 'Matematika',
                'title'            => 'Pertemuan 2 : Persamaan Linear',
                'grade_level'      => 'XI',
                'class_group'      => 'B',
                'category'         => 'text',
                // karena kategori text, biarkan video_url null
                'video_url'        => null,
                'short_description'=> 'Belajar menyelesaikan persamaan linear satu variabel.',
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'subject'          => 'Bahasa Inggris',
                'title'            => 'Pertemuan 3 : Introduction Myself',
                'grade_level'      => 'XII',
                'class_group'      => 'C',
                'category'         => 'video',
                'video_url'        => 'https://www.youtube.com/watch?v=HAnw168huqA',
                'short_description'=> 'Cara memperkenalkan diri dalam bahasa Inggris dengan struktur yang benar.',
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
        ]);
    }
}
