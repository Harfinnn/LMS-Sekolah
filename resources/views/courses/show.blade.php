@extends('layouts.courses')

@section('content')

<div class="p-4 sm:ml-64 mt-16">
    <div class="max-w-6xl mx-auto">

        {{-- Header course --}}
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-2xl font-extrabold text-green-400">
                    {{ $course->subject }} - Kelas {{ $course->grade_level }} {{ $course->class_group }}
                </h1>
                <p class="text-slate-400 text-sm mt-1">
                    {{ $course->title ?? 'Mata pelajaran' }}
                </p>
            </div>

            <div class="flex items-center gap-2">
                {{-- Tombol tambah materi --}}
                <a href="{{ route('courses.materials.create', $course) }}"
                    class="text-sm px-3 py-1.5 rounded-lg bg-green-600 text-white hover:bg-green-500">
                    Tambah Materi Baru
                </a>

                <a href="{{ route('courses.index') }}"
                    class="text-sm px-3 py-1.5 rounded-lg bg-green-600 text-white hover:bg-green-500">
                    Kembali ke daftar course
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-4 px-4 py-2 rounded-lg bg-green-100 border border-green-400 text-green-800 text-sm">
            {{ session('success') }}
        </div>
        @endif

        {{-- Layout utama: sidebar materi + konten --}}

        {{-- Konten materi aktif --}}
        <section class="bg-slate-900 rounded-2xl border border-slate-800 p-5 min-h-[300px]">

            @if(!$activeMaterial)
            <p class="text-slate-400 text-sm">
                Belum ada materi yang bisa ditampilkan. Silakan tambahkan materi terlebih dahulu.
            </p>
            @else
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h2 class="text-xl font-bold text-slate-100">
                        {{ $activeMaterial->title }}
                    </h2>
                    @if($activeMaterial->short_description)
                    <p class="text-slate-300 text-sm mt-1">
                        {{ $activeMaterial->short_description }}
                    </p>
                    @endif
                </div>

                <div class="flex items-center gap-2">
                    {{-- Tombol Edit --}}
                    <a href="{{ route('courses.materials.edit', [$course, $activeMaterial]) }}"
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-green-600 text-white text-xs hover:bg-green-500">
                        Edit
                    </a>

                    {{-- Tombol Hapus --}}
                    <form action="{{ route('courses.materials.destroy', [$course, $activeMaterial]) }}"
                        class="inline delete-form"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus materi ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-red-600 text-white text-xs hover:bg-red-500 btn-delete">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

            {{-- Tampilkan konten sesuai kategori --}}
            @if($activeMaterial->category === 'video')
            @if($activeMaterial->video_url)
            @php
            $url = $activeMaterial->video_url;
            $embedUrl = $url;
            if (str_contains($url, 'youtube.com/watch')) {
            parse_str(parse_url($url, PHP_URL_QUERY), $params);
            if (!empty($params['v'])) {
            $embedUrl = 'https://www.youtube.com/embed/' . $params['v'];
            }
            } elseif (str_contains($url, 'youtu.be/')) {
            $code = trim(parse_url($url, PHP_URL_PATH), '/');
            $embedUrl = 'https://www.youtube.com/embed/' . $code;
            }
            @endphp

            <div class="aspect-video w-full bg-black rounded-lg overflow-hidden">
                <iframe class="w-full h-full"
                    src="{{ $embedUrl }}"
                    title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen></iframe>
            </div>

            <p class="text-xs text-slate-400 mt-2">
                Jika video tidak tampil, klik link ini:
                <a href="{{ $activeMaterial->video_url }}" target="_blank"
                    class="text-green-400 hover:text-green-300">
                    {{ $activeMaterial->video_url }}
                </a>
            </p>
            @else
            <p class="text-slate-400 text-sm">
                Belum ada link video untuk materi ini.
            </p>
            @endif

            @else
            {{-- kategori text --}}
            @if($activeMaterial->content)
            <div class="text-slate-200 text-sm whitespace-pre-line">
                {{ $activeMaterial->content }}
            </div>
            @else
            <p class="text-slate-400 text-sm">
                Belum ada teks materi yang diisi.
            </p>
            @endif

            @if($activeMaterial->file_path)
            <div class="mt-3">
                <a href="{{ Storage::disk('public')->url($activeMaterial->file_path) }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 text-green-400 hover:text-green-300 text-sm">
                    <i class="fa-solid fa-file"></i>
                    Buka file pendukung (PDF/PPT)
                </a>
            </div>
            @endif
            @endif
            @endif

        </section>

    </div>
</div>
@endsection