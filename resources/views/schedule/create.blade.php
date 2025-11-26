@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:ml-64 mt-16">
    <div class="max-w-2xl mx-auto bg-slate-900 rounded-2xl shadow p-6 text-slate-100">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-extrabold text-green-400">Tambah Slot Jadwal</h1>
            <a href="{{ route('schedule.index') }}" class="text-sm px-3 py-1.5 border border-green-600 text-green-300 rounded-md hover:bg-green-600 hover:text-white">Kembali</a>
        </div>

        <form action="{{ route('schedule.store') }}" method="POST" class="space-y-4" id="create-schedule-form">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Hari</label>
                <select name="day" id="day-select" class="w-full bg-slate-800 p-2 rounded border border-slate-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    @foreach($days as $d)
                        <option value="{{ $d }}" {{ old('day') == $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Mata Pelajaran</label>
                <input
                    type="text"
                    name="subject"
                    value="{{ old('subject') }}"
                    placeholder="Contoh: Matematika"
                    class="w-full bg-slate-800 p-2 rounded border border-slate-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Mulai</label>
                    <input
                        type="time"
                        name="start"
                        id="start-time"
                        value="{{ old('start') }}"
                        min="08:00" max="15:40"
                        class="w-full bg-slate-800 p-2 rounded border border-slate-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Selesai</label>
                    <input
                        type="time"
                        name="end"
                        id="end-time"
                        value="{{ old('end') }}"
                        min="08:05" max="15:40"
                        class="w-full bg-slate-800 p-2 rounded border border-slate-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
            </div>

            <div id="existing-slots" class="text-sm text-slate-300 mt-2">
            </div>

            <div class="flex items-center gap-3 mt-2">
                <button type="submit" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">Simpan</button>
                <a href="{{ route('schedule.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-slate-700 rounded-lg text-slate-200 hover:bg-slate-800">Batal</a>
            </div>
        </form>
    </div>
</div>

<script id="schedules-data" type="application/json">
    {!! json_encode($schedulesByDay ?? [], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>
@endsection
