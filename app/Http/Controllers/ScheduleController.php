<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Exports\ScheduleExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        // Filter kelas yang dipilih (default X A)
        $grade = $request->input('grade', 'X');
        $class = $request->input('class', 'A');

        $slots = Schedule::where('grade_level', $grade)
            ->where('class_group', $class)
            ->orderByRaw("FIELD(day,'Senin','Selasa','Rabu','Kamis','Jumat')")
            ->orderBy('start_time')
            ->get();

        $schedulesByDay = [];
        foreach ($slots as $slot) {
            $schedulesByDay[$slot->day][] = $slot;
        }

        // kalau mau pakai $days di blade, tinggal kirim juga
        return view('schedule.index', compact('schedulesByDay', 'grade', 'class'));
    }

    public function create()
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        // data untuk JS "existing-slots" (semua jadwal, bebas kelas)
        $schedules = Schedule::orderBy('start_time')->get();
        $schedulesByDay = $schedules->groupBy('day')->map(function ($col) {
            return $col->map(function ($item) {
                return [
                    'id'         => $item->id,
                    'subject'    => $item->subject,
                    'start_time' => $item->start_time,
                    'end_time'   => $item->end_time,
                    'grade_level' => $item->grade_level,
                    'class_group' => $item->class_group,
                ];
            })->values()->all();
        })->toArray();

        return view('schedule.create', compact('days', 'schedulesByDay'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'day'         => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'subject'     => 'required|string|max:255',
            'start'       => 'required|date_format:H:i',
            'end'         => 'required|date_format:H:i|after:start',
            'grade_level' => 'required|in:X,XI,XII',
            'class_group' => 'required|in:A,B,C',
        ]);

        try {
            $schoolStart = Carbon::createFromFormat('H:i', '08:00');
            $schoolEnd   = Carbon::createFromFormat('H:i', '15:40');

            $start = Carbon::createFromFormat('H:i', $data['start']);
            $end   = Carbon::createFromFormat('H:i', $data['end']);

            if ($start->lt($schoolStart) || $end->gt($schoolEnd)) {
                return back()->withInput()->withErrors([
                    'start' => 'Jam harus berada dalam rentang 08:00 - 15:40.',
                ]);
            }

            // ⚠️ Cek tabrakan HANYA pada hari & kelas yang sama
            $existing = Schedule::where('day', $data['day'])
                ->where('grade_level', $data['grade_level'])
                ->where('class_group', $data['class_group'])
                ->get();

            foreach ($existing as $e) {
                $eStart = Carbon::hasFormat($e->start_time, 'H:i:s')
                    ? Carbon::createFromFormat('H:i:s', $e->start_time)
                    : Carbon::parse($e->start_time);

                $eEnd = Carbon::hasFormat($e->end_time, 'H:i:s')
                    ? Carbon::createFromFormat('H:i:s', $e->end_time)
                    : Carbon::parse($e->end_time);

                if ($start->lt($eEnd) && $end->gt($eStart)) {
                    return back()->withInput()->withErrors([
                        'start' => "Waktu bertabrakan dengan \"{$e->subject}\" ({$e->start_time} - {$e->end_time}) di kelas yang sama.",
                    ]);
                }
            }

            Schedule::create([
                'day'         => $data['day'],
                'subject'     => $data['subject'],
                'start_time'  => $data['start'],
                'end_time'    => $data['end'],
                'grade_level' => $data['grade_level'],
                'class_group' => $data['class_group'],
            ]);

            return redirect()->route('schedule.index')
                ->with('success', 'Slot berhasil ditambahkan.');
        } catch (\Exception $ex) {
            Log::error('Schedule::store exception: ' . $ex->getMessage(), ['exception' => $ex]);
            return back()->withInput()->withErrors([
                'server' => 'Terjadi kesalahan di server. Cek log untuk detail.',
            ]);
        }
    }

    public function edit(Schedule $schedule)
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        return view('schedule.edit', compact('schedule', 'days'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        // 1. VALIDASI HANYA FIELD YANG MEMANG DI-EDIT
        $data = $request->validate([
            'day'     => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'subject' => 'required|string|max:255',
            'start'   => 'required|date_format:H:i',
            'end'     => 'required|date_format:H:i|after:start',
        ]);

        // 2. CEK RANGE JAM (BIAR KONSISTEN DENGAN store())
        $schoolStart = Carbon::createFromFormat('H:i', '08:00');
        $schoolEnd   = Carbon::createFromFormat('H:i', '15:40');

        $start = Carbon::createFromFormat('H:i', $data['start']);
        $end   = Carbon::createFromFormat('H:i', $data['end']);

        if ($start->lt($schoolStart) || $end->gt($schoolEnd)) {
            return back()->withInput()->withErrors([
                'start' => 'Jam harus berada dalam rentang 08:00 - 15:40.',
            ]);
        }

        // 3. GUNAKAN grade_level & class_group DARI JADWAL YANG SEDANG DI-EDIT
        $gradeLevel = $schedule->grade_level;
        $classGroup = $schedule->class_group;

        // 4. CEK TABRAKAN, TAPI DI KELAS & HARI YANG SAMA, DAN SKIP ID YANG SEDANG DI-EDIT
        $existing = Schedule::where('day', $data['day'])
            ->where('grade_level', $gradeLevel)
            ->where('class_group', $classGroup)
            ->where('id', '!=', $schedule->id)
            ->get();

        foreach ($existing as $e) {
            $eStart = Carbon::hasFormat($e->start_time, 'H:i:s')
                ? Carbon::createFromFormat('H:i:s', $e->start_time)
                : Carbon::parse($e->start_time);

            $eEnd = Carbon::hasFormat($e->end_time, 'H:i:s')
                ? Carbon::createFromFormat('H:i:s', $e->end_time)
                : Carbon::parse($e->end_time);

            if ($start->lt($eEnd) && $end->gt($eStart)) {
                return back()->withInput()->withErrors([
                    'start' => "Waktu bertabrakan dengan \"{$e->subject}\" ({$e->start_time} - {$e->end_time}) di kelas yang sama.",
                ]);
            }
        }

        // 5. UPDATE FIELD YANG BOLEH DIUBAH
        $schedule->update([
            'day'        => $data['day'],
            'subject'    => $data['subject'],
            'start_time' => $data['start'],
            'end_time'   => $data['end'],
            // grade_level & class_group TIDAK DIUBAH
        ]);

        return redirect()->route('schedule.index')
            ->with('success', 'Slot berhasil diperbarui.');
    }


    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedule.index')->with('success', 'Slot berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $grade = $request->input('grade', 'X');
        $class = $request->input('class', 'A');

        $fileName = "jadwal-kelas-{$grade}{$class}.xlsx";

        return Excel::download(new ScheduleExport($grade, $class), $fileName);
    }
}
