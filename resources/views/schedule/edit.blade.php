@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:ml-64 mt-16">
    <div class="max-w-2xl mx-auto bg-slate-900 rounded-2xl shadow-2xl border border-slate-800 p-6 text-slate-100">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-extrabold text-green-400">
                    Edit Slot Jadwal
                </h1>
                <p class="text-slate-400 text-xs mt-1">
                    Ubah hari, mata pelajaran, dan jam pelajaran.
                </p>
            </div>
            <a href="{{ route('schedule.index') }}"
                class="text-sm px-3 py-1.5 border border-green-600 text-green-300 rounded-md hover:bg-green-600 hover:text-white transition">
                Kembali
            </a>
        </div>

        @if ($errors->any())
        <div class="mb-4 text-red-400 text-sm">
            <ul class="list-disc ml-4">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('schedule.update', $schedule->id) }}"
            method="POST"
            class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Hari --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">
                    Hari
                </label>
                <select name="day"
                    class="w-full bg-slate-800 p-2 rounded border border-slate-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    @foreach($days as $d)
                    <option value="{{ $d }}"
                        {{ old('day', $schedule->day) == $d ? 'selected' : '' }}>
                        {{ $d }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Mata Pelajaran --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">
                    Mata Pelajaran
                </label>
                <input
                    type="text"
                    name="subject"
                    value="{{ old('subject', $schedule->subject) }}"
                    placeholder="Contoh: Matematika"
                    class="w-full bg-slate-800 p-2 rounded border border-slate-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Jam --}}
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">
                        Mulai
                    </label>
                    <input
                        type="time"
                        name="start"
                        value="{{ old('start', substr($schedule->start_time, 0, 5)) }}"
                        min="08:00" max="15:40"
                        class="w-full bg-slate-800 p-2 rounded border border-slate-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <p class="text-xs text-slate-500 mt-1">
                        Jam mulai (paling awal 08:00).
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">
                        Selesai
                    </label>
                    <input
                        type="time"
                        name="end"
                        value="{{ old('end', substr($schedule->end_time, 0, 5)) }}"
                        min="08:05" max="15:40"
                        class="w-full bg-slate-800 p-2 rounded border border-slate-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <p class="text-xs text-slate-500 mt-1">
                        Jam selesai (maksimal 15:40).
                    </p>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex items-center gap-3 mt-2">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
                    Simpan Perubahan
                </button>

                <a href="{{ route('schedule.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 border border-slate-700 rounded-lg text-slate-200 hover:bg-slate-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection