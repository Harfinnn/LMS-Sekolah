<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $grades  = ['X', 'XI', 'XII'];
        $classes = ['A', 'B', 'C'];
        $days    = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        // Slot 45 menit, Senin–Kamis (08:00–15:30)
        $regularSlots = [
            ['08:00', '08:45'], // 0
            ['08:45', '09:30'], // 1
            ['09:30', '10:15'], // 2 -> Istirahat 1 (± 09:40–10:00)
            ['10:15', '11:00'], // 3
            ['11:00', '11:45'], // 4
            ['11:45', '12:30'], // 5 -> Istirahat 2 (± 12:00–12:30)
            ['12:30', '13:15'], // 6
            ['13:15', '14:00'], // 7
            ['14:00', '14:45'], // 8
            ['14:45', '15:30'], // 9
        ];

        // Jumat (dibatasi sampai sekitar 11.15, kita pakai 11.00)
        $fridaySlots = [
            ['08:00', '08:45'], // 0
            ['08:45', '09:30'], // 1 -> Istirahat (± 09:00–09:30)
            ['09:30', '10:15'], // 2
            ['10:15', '11:00'], // 3
        ];

        // daftar mapel
        $subjects = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Fisika',
            'Kimia',
            'Biologi',
            'Sejarah',
            'Geografi',
            'Ekonomi',
            'Sosiologi',
            'Seni Budaya',
            'PJOK',
            'Pendidikan Agama',
            'Informatika',
            'BK',
        ];

        $subjectCounter = 0;

        foreach ($grades as $grade) {
            foreach ($classes as $class) {
                foreach ($days as $day) {

                    if ($day === 'Jumat') {
                        $slots = $fridaySlots;
                    } else {
                        $slots = $regularSlots;
                    }

                    foreach ($slots as $index => $slot) {
                        [$start, $end] = $slot;

                        // tentukan subject
                        if ($day === 'Jumat') {
                            // Jumat: slot index 1 = istirahat
                            if ($index === 1) {
                                $subject = 'Istirahat';
                            } else {
                                $subject = $subjects[$subjectCounter % count($subjects)];
                                $subjectCounter++;
                            }
                        } else {
                            // Senin–Kamis:
                            // index 2 & 5 = istirahat
                            if ($index === 2) {
                                $subject = 'Istirahat 1';
                            } elseif ($index === 5) {
                                $subject = 'Istirahat 2';
                            } else {
                                $subject = $subjects[$subjectCounter % count($subjects)];
                                $subjectCounter++;
                            }
                        }

                        Schedule::create([
                            'day'         => $day,
                            'subject'     => $subject,
                            'start_time'  => $start,
                            'end_time'    => $end,
                            'grade_level' => $grade,
                            'class_group' => $class,
                        ]);
                    }
                }
            }
        }
    }
}
