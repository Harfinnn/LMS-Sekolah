@extends('layouts.dashboard')

@section('content')
@php
function getSubjectColor($subject) {
$colors = [
'bg-blue-600 border-blue-500',
'bg-emerald-600 border-emerald-500',
'bg-violet-600 border-violet-500',
'bg-amber-600 border-amber-500',
'bg-rose-600 border-rose-500',
'bg-cyan-600 border-cyan-500',
'bg-fuchsia-600 border-fuchsia-500',
'bg-lime-600 border-lime-500'
];
$index = (strlen($subject) + ord(substr($subject, 0, 1))) % count($colors);
return $colors[$index];
}
@endphp

<div class="p-4 sm:ml-64 mt-16">
    <div class="max-w-6xl mx-auto space-y-6">

        @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 border border-green-400 text-green-800 flex items-center justify-between">
            <span><i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        @endif

        <div class="bg-slate-900 rounded-2xl shadow-lg border border-slate-800 overflow-hidden">

            <div class="px-6 py-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-slate-800 bg-gradient-to-b from-slate-900/60 to-transparent">
                <div>
                    <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-600">
                        Jadwal Pelajaran Kelas {{ $grade ?? 'X' }} {{ $class ?? 'A' }}
                    </h1>
                    <p class="text-slate-400 text-sm mt-1">Kelola slot waktu dan mata pelajaran Anda di sini.</p>
                </div>

                <div class="flex items-center gap-3">

                    <form action="{{ route('schedule.index') }}" method="GET" class="flex items-center gap-2" id="filter-form">
                        <select name="grade"
                            class="bg-slate-800 border border-slate-600 text-slate-100 text-sm rounded-lg px-2 py-1"
                            onchange="this.form.submit()">
                            @foreach(['X','XI','XII'] as $g)
                            <option value="{{ $g }}" {{ (isset($grade) && $grade == $g) ? 'selected' : '' }}>
                                Kelas {{ $g }}
                            </option>
                            @endforeach
                        </select>

                        <select name="class"
                            class="bg-slate-800 border border-slate-600 text-slate-100 text-sm rounded-lg px-2 py-1"
                            onchange="this.form.submit()">
                            @foreach(['A','B','C'] as $c)
                            <option value="{{ $c }}" {{ (isset($class) && $class == $c) ? 'selected' : '' }}>
                                {{ $c }}
                            </option>
                            @endforeach
                        </select>
                    </form>

                    <!-- <a href="{{ route('schedule.export', ['grade' => $grade ?? 'X', 'class' => $class ?? 'A']) }}"
                        class="group relative inline-flex items-center gap-2 px-4 py-2 bg-slate-800 text-slate-100 font-semibold rounded-xl border border-slate-600 hover:border-slate-400 hover:-translate-y-0.5 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path d="M3.5 3A1.5 1.5 0 0 0 2 4.5v11A1.5 1.5 0 0 0 3.5 17h13a1.5 1.5 0 0 0 1.5-1.5v-11A1.5 1.5 0 0 0 16.5 3h-13Zm1 2h11v2h-11V5Zm0 3.5h4v2h-4v-2Zm0 3.5h4v2h-4v-2Zm5.5-3.5H15v2h-5.5v-2Zm0 3.5H15v2h-5.5v-2Z" />
                        </svg>
                        Export Excel
                    </a> -->

                    <a href="{{ route('schedule.create', ['grade' => $grade ?? 'X', 'class' => $class ?? 'A']) }}"
                        class="group relative inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 text-white font-semibold rounded-xl shadow-lg shadow-green-900/50 hover:bg-green-500 hover:-translate-y-0.5 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                        </svg>
                        Tambah Slot
                    </a>

                </div>
            </div>

            <div class="p-4">
                <div class="px-2 py-2 bg-slate-900/20 rounded-lg">
                    <h2 class="text-lg font-bold text-slate-100 mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-indigo-400">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd" />
                        </svg>
                        Ringkasan Mingguan
                    </h2>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border-collapse">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-700 bg-slate-800/50 rounded-tl-lg">Jam</th>
                                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $index => $d)
                                    <th class="px-4 py-3 text-left font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-700 bg-slate-800/50 {{ $loop->last ? 'rounded-tr-lg' : '' }}">{{ $d }}</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-800">
                                @php
                                $schedulesByDay = $schedulesByDay ?? [];
                                $times = [];
                                foreach($schedulesByDay as $daySlots){
                                foreach($daySlots as $s){
                                $key = ($s->start_time ?? '') . '|' . ($s->end_time ?? '');
                                if(trim($key) !== '|') $times[$key] = true;
                                }
                                }
                                $times = array_keys($times);
                                sort($times);
                                @endphp

                                @forelse($times as $t)
                                @php list($start,$end) = explode('|', $t); @endphp
                                <tr class="hover:bg-slate-800/30 transition-colors">
                                    <td class="px-4 py-3 align-top whitespace-nowrap text-slate-400 font-mono text-xs border-r border-slate-800 bg-slate-900/50 w-32">{{ substr($start,0,5) }} - {{ substr($end,0,5) }}</td>

                                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $d)
                                    <td class="px-2 py-2 align-top h-full">
                                        @if(!empty($schedulesByDay[$d]))
                                        @foreach($schedulesByDay[$d] as $slot)
                                        @if(($slot->start_time ?? '') == $start && ($slot->end_time ?? '') == $end)
                                        <div class="{{ getSubjectColor($slot->subject) }} text-white text-xs font-semibold rounded-md px-2 py-1.5 shadow-md border-t border-white/20 truncate" title="{{ $slot->subject }}">
                                            {{ $slot->subject }}
                                        </div>
                                        @endif
                                        @endforeach
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-500 italic">Belum ada jadwal yang diatur. Silakan tambah slot baru.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-xl font-bold text-green-400 mb-4 flex items-center gap-2">
                Detail & Manajemen Jam Pelajaran
            </h2>

            @php $hasData = false; @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @if(!empty($schedulesByDay))
                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $day)
                @if(!empty($schedulesByDay[$day]))
                @php $hasData = true; @endphp
                @foreach($schedulesByDay[$day] as $slot)
                <div class="bg-slate-800 rounded-xl border border-slate-700 hover:border-slate-500 shadow-sm hover:shadow-lg transition duration-200 group overflow-hidden flex flex-col">
                    {{-- Color Bar Top --}}
                    <div class="h-1.5 w-full {{ str_replace('border-', '', getSubjectColor($slot->subject)) }}"></div>

                    <div class="p-4 flex-1">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-500 bg-slate-900/50 px-2 py-1 rounded">{{ $day }}</span>

                            <div class="flex gap-1 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-200">
                                <a href="{{ route('schedule.edit', $slot->id) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-blue-400 hover:bg-slate-700 bg-slate-900 border border-slate-700" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                        <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                    </svg>
                                </a>
                                <form action="{{ route('schedule.destroy', $slot->id) }}" class="inline delete-form" method="POST" onsubmit="return confirm('Hapus jadwal {{ $slot->subject }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="p-1.5 rounded-lg text-slate-400 hover:text-red-400 hover:bg-slate-700 bg-slate-900 border border-slate-700 btn-delete" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                            <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 0 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <h3 class="text-lg font-bold text-slate-100 truncate mb-1" title="{{ $slot->subject }}">{{ $slot->subject }}</h3>

                        <div class="flex items-center gap-2 text-slate-400 text-sm mt-3 pt-3 border-t border-slate-700/50">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ substr($slot->start_time, 0, 5) }} - {{ substr($slot->end_time, 0, 5) }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                @endforeach
                @endif
            </div>

            @if(!$hasData)
            <div class="text-center py-12 bg-slate-800 rounded-2xl border border-slate-700 border-dashed">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-slate-600 mx-auto mb-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
                <p class="text-slate-400 text-lg">Belum ada slot jadwal.</p>
                <a href="{{ route('schedule.create') }}" class="text-green-400 hover:text-green-300 font-medium text-sm mt-1 inline-block">Mulai tambahkan sekarang &rarr;</a>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection