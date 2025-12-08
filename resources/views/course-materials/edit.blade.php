@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:ml-64 mt-16">
    <div class="max-w-2xl mx-auto bg-slate-900 rounded-2xl shadow p-6 text-slate-100">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-extrabold text-green-400">Edit Materi / Bab</h1>
                <p class="text-slate-400 text-sm mt-1">
                    Course: {{ $course->subject }} — Kelas {{ $course->grade_level }} {{ $course->class_group }}
                </p>
            </div>
            <a href="{{ route('courses.show', $course) }}"
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

        <form action="{{ route('courses.materials.update', ['course' => $course->id, 'material' => $material->id]) }}"
            method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Judul Bab / Pertemuan --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">
                    Judul Materi / Bab
                </label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $material->title) }}"
                    class="w-full bg-slate-800 p-2 rounded border border-slate-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- {{-- Urutan --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">
                    Urutan
                </label>
                <input
                    type="number"
                    name="order"
                    value="{{ old('order', $material->order) }}"
                    min="1"
                    class="w-full bg-slate-800 p-2 rounded border border-slate-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div> -->

            {{-- Kategori --}}
            @php
            $categoryValue = old('category', $material->category);
            @endphp
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">
                    Kategori Materi
                </label>
                <select name="category" id="category-select"
                    class="w-full bg-slate-800 p-2 rounded border border-slate-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="video" {{ $categoryValue === 'video' ? 'selected' : '' }}>Video (YouTube, dll)</option>
                    <option value="text" {{ $categoryValue === 'text'  ? 'selected' : '' }}>Teks / Dokumen</option>
                </select>
                @error('category') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Jika kategori video --}}
            <div id="video-fields" class="hidden">
                <label class="block text-sm font-medium text-slate-300 mb-1">
                    Link Video (YouTube, dll)
                </label>
                <input
                    type="url"
                    name="video_url"
                    value="{{ old('video_url', $material->video_url) }}"
                    placeholder="https://www.youtube.com/watch?v=..."
                    class="w-full bg-slate-800 p-2 rounded border border-slate-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('video_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Jika kategori text --}}
            <div id="text-fields" class="hidden space-y-3">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">
                        Isi Materi (Teks)
                    </label>
                    <textarea
                        name="content"
                        rows="5"
                        class="w-full bg-slate-800 p-2 rounded border border-slate-700 focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('content', $material->content) }}</textarea>
                    @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">
                        File Pendukung (PDF / PPT, opsional)
                    </label>
                    @if($material->file_path)
                    <p class="text-xs text-slate-300 mb-1">
                        File saat ini:
                        <a href="{{ Storage::disk('public')->url($material->file_path) }}"
                            target="_blank" class="text-green-400 hover:text-green-300 underline">
                            Lihat file
                        </a>
                    </p>
                    @endif
                    <input type="file" name="file"
                        class="w-full text-sm text-slate-200">
                    @error('file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Deskripsi singkat --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">
                    Deskripsi Singkat (opsional)
                </label>
                <textarea
                    name="short_description"
                    rows="3"
                    class="w-full bg-slate-800 p-2 rounded border border-slate-700 focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('short_description', $material->short_description) }}</textarea>
                @error('short_description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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