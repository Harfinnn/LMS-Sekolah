<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Matikan foreign key checks sementara (hanya untuk seeding di dev)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        CourseMaterial::truncate();
        Course::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Bank topik per mata pelajaran biar kelihatan dinamis
        $topicBank = [
            'Matematika' => [
                'Bilangan Bulat',
                'Persamaan Linear',
                'Statistika Dasar',
                'Fungsi dan Grafik',
            ],
            'Bahasa Indonesia' => [
                'Teks Narasi',
                'Teks Eksposisi',
                'Teks Argumentasi',
                'Menyusun Paragraf Efektif',
            ],
            'Bahasa Inggris' => [
                'Introduction & Greetings',
                'Simple Present Tense',
                'Descriptive Text',
                'Dialog Sehari-hari',
            ],
            'Fisika' => [
                'Besaran dan Satuan',
                'Gerak Lurus',
                'Hukum Newton',
                'Usaha dan Energi',
            ],
            'Kimia' => [
                'Struktur Atom',
                'Tabel Periodik',
                'Ikatan Kimia',
                'Reaksi Kimia',
            ],
            'Biologi' => [
                'Sel dan Jaringan',
                'Sistem Organ',
                'Keanekaragaman Hayati',
                'Ekosistem',
            ],
            'Sejarah' => [
                'Kerajaan Nusantara',
                'Pergerakan Nasional',
                'Proklamasi Kemerdekaan',
                'Orde Baru',
            ],
            'Geografi' => [
                'Peta dan Skala',
                'Litosfer',
                'Atmosfer',
                'Demografi Penduduk',
            ],
            'Ekonomi' => [
                'Kebutuhan dan Kelangkaan',
                'Pasar dan Harga',
                'Kegiatan Produksi',
                'Lembaga Keuangan',
            ],
            'Sosiologi' => [
                'Interaksi Sosial',
                'Lembaga Sosial',
                'Stratifikasi Sosial',
                'Perubahan Sosial',
            ],
            'Seni Budaya' => [
                'Seni Musik',
                'Seni Tari',
                'Seni Rupa',
                'Apresiasi Karya Seni',
            ],
            'PJOK' => [
                'Kebugaran Jasmani',
                'Permainan Bola Besar',
                'Atletik',
                'Gaya Hidup Sehat',
            ],
            'Pendidikan Agama' => [
                'Akhlak Terpuji',
                'Ibadah Sehari-hari',
                'Sejarah Nabi',
                'Al-Quran dan Hadis',
            ],
            'Informatika' => [
                'Pengenalan Komputer',
                'Algoritma Dasar',
                'Pemrograman Dasar',
                'Jaringan Komputer',
            ],
            'BK' => [
                'Perencanaan Karir',
                'Manajemen Waktu',
                'Motivasi Belajar',
                'Pengembangan Diri',
            ],
        ];

        // Ambil kombinasi unik dari jadwal
        $groups = Schedule::select('subject', 'grade_level', 'class_group')
            ->groupBy('subject', 'grade_level', 'class_group')
            ->orderBy('grade_level')
            ->orderBy('class_group')
            ->get();

        static $courseCounter = 0;

        foreach ($groups as $g) {

            // Lewati subject istirahat
            if (stripos($g->subject, 'istirahat') === 0) {
                continue;
            }

            $subjectName = $g->subject;

            // Ambil list topik untuk mapel ini, atau default kalau tidak ada
            $topics = $topicBank[$subjectName] ?? [
                'Pendahuluan',
                'Pembahasan Materi',
                'Latihan Soal',
                'Evaluasi Pembelajaran',
            ];

            $courseCounter++;

            // Pilih 3 topik secara bergilir
            $topic1 = $topics[$courseCounter % count($topics)];
            $topic2 = $topics[($courseCounter + 1) % count($topics)];
            $topic3 = $topics[($courseCounter + 2) % count($topics)];

            // Buat Course
            $course = Course::create([
                'subject'     => $subjectName,
                'grade_level' => $g->grade_level,
                'class_group' => $g->class_group,
                'title'       => $subjectName . ' - ' . $g->grade_level . $g->class_group,
                'description' => "Materi pelajaran {$subjectName} untuk kelas {$g->grade_level} {$g->class_group}.",
            ]);

            // Materi 1: Teks pengenalan
            CourseMaterial::create([
                'course_id' => $course->id,
                'title'     => "Pengenalan: {$topic1}",
                'category'  => 'text',
                'content'   => "Pada materi ini, siswa akan diperkenalkan dengan topik {$topic1} dalam mata pelajaran {$subjectName} untuk kelas {$g->grade_level} {$g->class_group}.",
                'video_url' => null,
                'file_path' => null,
                'short_description' => "Pengenalan topik {$topic1}",
                'order' => 1,
            ]);

            // Materi 2: Video
            CourseMaterial::create([
                'course_id' => $course->id,
                'title'     => "Video Pembelajaran: {$topic2}",
                'category'  => 'video',
                'content'   => null,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'file_path' => null,
                'short_description' => "Video penjelasan materi {$topic2}",
                'order' => 2,
            ]);

            // Materi 3: Ringkasan + file
            CourseMaterial::create([
                'course_id' => $course->id,
                'title'     => "Ringkasan & Latihan: {$topic3}",
                'category'  => 'text',
                'content'   => "Ringkasan konsep penting dan latihan soal terkait topik {$topic3} untuk memperdalam pemahaman siswa.",
                'video_url' => null,
                'file_path' => '/storage/files/sample.pdf',
                'short_description' => "Ringkasan dan latihan {$topic3}",
                'order' => 3,
            ]);
        }
    }
}
