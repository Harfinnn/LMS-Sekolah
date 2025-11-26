<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ScheduleController extends Controller
{

    public function index()
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        $schedules = Schedule::orderByRaw("FIELD(day,'Senin','Selasa','Rabu','Kamis','Jumat')")
            ->orderBy('start_time')
            ->get();

        $schedulesByDay = [];
        foreach ($schedules as $s) {
            $schedulesByDay[$s->day][] = $s;
        }

        return view('schedule.index', compact('schedulesByDay'));
    }

    public function create()
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        $schedules = Schedule::orderBy('start_time')->get();
        $schedulesByDay = $schedules->groupBy('day')->map(function ($col) {
            return $col->map(function ($item) {
                return [
                    'id' => $item->id,
                    'subject' => $item->subject,
                    'start_time' => $item->start_time,
                    'end_time' => $item->end_time,
                ];
            })->values()->all();
        })->toArray();

        return view('schedule.create', compact('days', 'schedulesByDay'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'day'     => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'subject' => 'required|string|max:255',
            'start'   => 'required|date_format:H:i',
            'end'     => 'required|date_format:H:i|after:start',
        ]);

        try {
            $schoolStart = Carbon::createFromFormat('H:i', '08:00');
            $schoolEnd   = Carbon::createFromFormat('H:i', '15:40');

            $start = Carbon::createFromFormat('H:i', $data['start']);
            $end   = Carbon::createFromFormat('H:i', $data['end']);

            if ($start->lt($schoolStart) || $end->gt($schoolEnd)) {
                return back()->withInput()->withErrors(['start' => 'Jam harus berada dalam rentang 08:00 - 15:40.']);
            }

            $existing = Schedule::where('day', $data['day'])->get();

            foreach ($existing as $e) {
                $eStart = Carbon::hasFormat($e->start_time, 'H:i:s')
                    ? Carbon::createFromFormat('H:i:s', $e->start_time)
                    : Carbon::parse($e->start_time);

                $eEnd = Carbon::hasFormat($e->end_time, 'H:i:s')
                    ? Carbon::createFromFormat('H:i:s', $e->end_time)
                    : Carbon::parse($e->end_time);

                if ($start->lt($eEnd) && $end->gt($eStart)) {
                    return back()->withInput()->withErrors([
                        'start' => "Waktu bertabrakan dengan \"{$e->subject}\" ({$e->start_time} - {$e->end_time})."
                    ]);
                }
            }

            Schedule::create([
                'day'        => $data['day'],
                'subject'    => $data['subject'],
                'start_time' => $data['start'],
                'end_time'   => $data['end'],
            ]);

            return redirect()->route('schedule.index')->with('success', 'Slot berhasil ditambahkan.');
        } catch (\Exception $ex) {
            \Log::error('Schedule::store exception: ' . $ex->getMessage(), ['exception' => $ex]);
            return back()->withInput()->withErrors(['server' => 'Terjadi kesalahan di server. Cek log untuk detail.']);
        }
    }

    public function edit(Schedule $schedule)
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        return view('schedule.edit', compact('schedule', 'days'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $data = $request->validate([
            'day'     => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'subject' => 'required|string|max:255',
            'start'   => 'required|date_format:H:i',
            'end'     => 'required|date_format:H:i|after:start',
        ]);

        $schedule->update([
            'day'        => $data['day'],
            'subject'    => $data['subject'],
            'start_time' => $data['start'],
            'end_time'   => $data['end'],
        ]);

        return redirect()->route('schedule.index')->with('success', 'Slot berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedule.index')->with('success', 'Slot berhasil dihapus.');
    }
}
