@extends('layouts.dashboard')

@section('content')
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

        {{-- Header + tombol tambah course --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-green-400">Mata Pelajaran</h1>
                <p class="text-slate-400 text-sm mt-1">
                    Setiap course merepresentasikan satu mata pelajaran untuk satu kelas, misalnya "Matematika Kelas X A".
                </p>
            </div>

            <a href="{{ route('courses.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-xl shadow hover:bg-green-500">
                <i class="fa-solid fa-plus"></i>
                Tambah Course
            </a>
        </div>

        @if($courses->isEmpty())
        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-8 text-center text-slate-400">
            Belum ada course yang dibuat.
        </div>
        @else

        {{-- Grid daftar course --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($courses as $course)
            <div class="bg-slate-800 rounded-xl border border-slate-700 hover:border-slate-500 shadow-sm hover:shadow-lg transition duration-200 flex flex-col">

                {{-- Area yang bisa di-klik untuk lihat detail course --}}
                <a href="{{ route('courses.show', $course) }}" class="flex-1 p-4 block">
                    <div class="text-xs text-slate-400 mb-1">
                        Kelas {{ $course->grade_level }} {{ $course->class_group }}
                    </div>

                    <h2 class="text-sm font-bold text-slate-100 mb-1 line-clamp-2">
                        {{ $course->subject }}
                    </h2>

                    @if(!empty($course->description))
                    <p class="text-xs text-slate-300 line-clamp-3">
                        {{ $course->description }}
                    </p>
                    @else
                    <p class="text-xs text-slate-400">
                        Mata pelajaran {{ $course->subject }} kelas {{ $course->grade_level }} {{ $course->class_group }}.
                    </p>
                    @endif
                </a>

                {{-- Footer card: tanggal + tombol Edit/Hapus --}}
                <div class="px-4 py-2 border-t border-slate-700 flex items-center justify-between text-xs">
                    <span class="text-slate-500">
                        Dibuat: {{ $course->created_at->format('d M Y') }}
                    </span>

                    <div class="flex gap-2">
                        {{-- Edit --}}
                        <a href="{{ route('courses.edit', $course) }}"
                            class="px-2 py-1 rounded bg-blue-500/20 text-blue-400 border border-blue-500/40 hover:bg-blue-500 hover:text-white hover:border-blue-500 transition text-[11px]">
                            Edit
                        </a>

                        {{-- Hapus --}}
                        <form action="{{ route('courses.destroy', $course) }}" method="POST"
                            class="inline delete-form"
                            onsubmit="return confirm('Yakin hapus course ini? Semua materi di dalamnya akan ikut terhapus!')">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                class="px-2 py-1 rounded bg-red-500/20 text-red-400 border border-red-500/40 hover:bg-red-500 hover:text-white hover:border-red-500 transition text-[11px] btn-delete">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        @endif

    </div>
</div>
@endsection