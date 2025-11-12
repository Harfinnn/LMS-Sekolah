@extends('layouts.dashboard')

@section('content')
<div class=" p-4 sm:ml-32 mt-36 flex justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 bg-gradient-to-r from-green-500 to-teal-400 text-white">
            <h1 class="text-2xl font-extrabold">Tambah Gambar Gallery</h1>
            <p class="mt-1 text-sm opacity-90">Unggah beberapa gambar sekaligus. Per-file maksimal 5MB.</p>
        </div>

        <div class="p-6">
            @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
                <div class="font-semibold mb-2">Terjadi kesalahan:</div>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Pilih gambar (boleh lebih dari 1)</label>

                    <!-- Custom file input -->
                    <label for="images" id="dropzone" class="relative flex cursor-pointer items-center justify-center w-full h-44 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-900 hover:border-gray-300 transition-colors">
                        <input id="images" name="images[]" type="file" multiple accept="image/*" class="sr-only" />
                        <div class="text-center px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-10 w-10 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V7.414A2 2 0 0016.586 6L13 2.414A2 2 0 0011.586 2H4zm7 11a3 3 0 11-6 0 3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Tarik & lepas gambar di sini, atau <span class="text-green-600 font-semibold">pilih file</span></p>
                            <p class="mt-1 text-xs text-gray-400">Format: JPG/PNG. Max per-file 5MB.</p>
                        </div>
                    </label>

                    <!-- Preview -->
                    <div id="preview" class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-3"></div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-green-600 text-white font-medium shadow hover:bg-green-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M7 10l5 5 5-5M12 15V3" />
                        </svg>
                        Upload
                    </button>

                    <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                        Batal
                    </a>

                    <button type="button" id="clearBtn" class="ml-auto inline-flex items-center gap-2 px-3 py-2 rounded-md bg-yellow-100 text-yellow-800 hover:bg-yellow-200 transition">
                        Hapus pilih
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/gallery-upload.js') }}" defer></script>
@endsection