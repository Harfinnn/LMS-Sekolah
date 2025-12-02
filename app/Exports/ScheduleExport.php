<?php

namespace App\Exports;

use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ScheduleExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $grade;
    protected $class;

    public function __construct($grade, $class)
    {
        $this->grade = $grade;
        $this->class = $class;
    }

    public function collection()
    {
        return Schedule::where('grade_level', $this->grade)
            ->where('class_group', $this->class)
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tingkat',
            'Kelas',
            'Hari',
            'Jam Mulai',
            'Jam Selesai',
            'Mata Pelajaran',
        ];
    }

    public function map($schedule): array
    {
        return [
            $schedule->grade_level,
            $schedule->class_group,
            $schedule->day,
            substr($schedule->start_time, 0, 5),
            substr($schedule->end_time, 0, 5),
            $schedule->subject,
        ];
    }
}
