@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:ml-64 mt-16">
    <div class="max-w-2xl mx-auto bg-slate-900 rounded-2xl shadow p-6 text-slate-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-extrabold text-green-400">Edit Course</h1>
                <p class="text-slate-400 text-sm mt-1">
                    Ubah informasi mata pelajaran untuk kelas ini.
                </p>
            </div>
            <a href="{{ route('courses.index') }}"
                class="text-sm px-3 py-1.5 border border-green-600 text-green-300 rounded-md hover:bg-green-600 hover:text-white">
                Kembali
            </a>
        </div>

        @if ($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-900/40 border border-red-500 text-sm text-red-100">
            <div class="font-semibold mb-1">Terjadi kesalahan:</div>
            <ul class="list-disc pl-5 space-y-0.5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('courses.update', $course) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Mata Pelajaran --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Mata Pelajaran</label>
                <input type="text" name="subject"
                    value="{{ old('subject', $course->subject) }}"
                    placeholder="Contoh: Matematika, Programming"
                    class="w-full bg-slate-800 p-2 rounded border border-slate-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Kelas & Sub Kelas --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Tingkat</label>
                    <select name="grade_level"
                        class="w-full bg-slate-800 p-2 rounded border border-slate-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        @foreach(['X','XI','XII'] as $g)
                        <option value="{{ $g }}" {{ old('grade_level', $course->grade_level) == $g ? 'selected' : '' }}>
                            {{ $g }}
                        </option>
                        @endforeach
                    </select>
                    @error('grade_level') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Sub Kelas</label>
                    <select name="class_group"
                        class="w-full bg-slate-800 p-2 rounded border border-slate-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        @foreach(['A','B','C'] as $c)
                        <option value="{{ $c }}" {{ old('class_group', $course->class_group) == $c ? 'selected' : '' }}>
                            {{ $c }}
                        </option>
                        @endforeach
                    </select>
                    @error('class_group') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 mt-2">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
                    Simpan Perubahan
                </button>
                <a href="{{ route('courses.show', $course) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 border border-slate-700 rounded-lg text-slate-200 hover:bg-slate-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection