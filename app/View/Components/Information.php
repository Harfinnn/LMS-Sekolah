<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Information extends Component
{
    /**
     * Create a new component instance.
     */

    public $informasi;

    public function __construct()
    {
        $this->informasi = [
            [
                'judul' => 'Peluncuran Fitur Baru E-Learning',
                'deskripsi' => 'Kami menambahkan fitur forum diskusi dan materi interaktif untuk mendukung pembelajaran daring.',
                'gambar' => 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-3.jpg',
                'link' => '#',
            ],
            [
                'judul' => 'Jadwal Ujian Semester',
                'deskripsi' => 'Ujian semester ganjil akan dilaksanakan mulai 15 Desember. Pastikan semua tugas telah dikumpulkan.',
                'gambar' => 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-7.jpg',
                'link' => '#',
            ],
            [
                'judul' => 'Pelatihan Guru Digital Learning',
                'deskripsi' => 'Guru mengikuti pelatihan pembuatan konten pembelajaran digital untuk meningkatkan kualitas pembelajaran.',
                'gambar' => 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-9.jpg',
                'link' => '#',
            ],
            [
                'judul' => 'Kegiatan Sosialisasi Kurikulum Merdeka',
                'deskripsi' => 'Sekolah mengadakan sosialisasi Kurikulum Merdeka untuk guru dan siswa guna mendukung pembelajaran yang lebih fleksibel dan berorientasi pada proyek.',
                'gambar' => 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-5.jpg',
                'link' => '#',
            ],
            [
                'judul' => 'Lomba Inovasi Teknologi Sekolah',
                'deskripsi' => 'Siswa menampilkan proyek teknologi inovatif dalam ajang kompetisi tingkat nasional dan berhasil meraih juara 2.',
                'gambar' => 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-10.jpg',
                'link' => '#',
            ],
            [
                'judul' => 'Kegiatan Bakti Sosial Siswa',
                'deskripsi' => 'Siswa berpartisipasi dalam kegiatan bakti sosial di lingkungan sekitar sekolah sebagai bentuk kepedulian sosial.',
                'gambar' => 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-11.jpg',
                'link' => '#',
            ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.information');
    }
}
