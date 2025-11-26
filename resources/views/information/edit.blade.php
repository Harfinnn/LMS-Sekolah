@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:ml-64 mt-16">
    <div class="max-w-3xl mx-auto bg-slate-900 rounded-2xl shadow p-6 text-slate-100">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-extrabold text-green-400">Edit Informasi</h1>
            <a href="{{ route('information.index') }}" class="text-sm px-3 py-1.5 border border-green-600 text-green-300 rounded-md hover:bg-green-600 hover:text-white">Kembali</a>
        </div>

        <form action="{{ route('information.update', $information->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Judul <span class="text-green-400">*</span></label>
                <input type="text" name="judul" value="{{ old('judul', $information->judul) }}" class="w-full bg-slate-800 border border-slate-700 text-slate-100 p-3 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Masukkan judul informasi">
                @error('judul') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Deskripsi <span class="text-green-400">*</span></label>
                <textarea name="deskripsi" rows="6" class="w-full bg-slate-800 border border-slate-700 text-slate-100 p-3 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Tuliskan deskripsi singkat..." >{{ old('deskripsi', $information->deskripsi) }}</textarea>
                @error('deskripsi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                <p class="text-xs text-slate-400 mt-1">Gunakan paragraf untuk memisahkan poin penting.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Gambar <span class="text-green-400">*</span></label>

                <div class="flex flex-col md:flex-row items-start gap-4">
                    <label id="dropzone" class="flex-1 bg-slate-800 border border-dashed border-green-700 rounded-lg p-4 text-center cursor-pointer hover:bg-slate-700 transition-shadow duration-150">
                        <input type="file" name="gambar" id="gambar" class="hidden" accept="image/*">

                        <div id="placeholder" class="flex flex-col items-center justify-center gap-2 text-slate-400 {{ $information->gambar ? 'hidden' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm6 4a3 3 0 100 6 3 3 0 000-6z" />
                            </svg>
                            <div class="text-sm text-slate-400">Klik untuk memilih gambar atau seret ke sini</div>
                        </div>

                        <img id="preview" class="mx-auto rounded-lg max-h-40 {{ $information->gambar ? '' : 'hidden' }}" alt="Preview Gambar" data-original-src="{{ $information->gambar ? asset($information->gambar) : '' }}" src="{{ $information->gambar ? asset($information->gambar) : '' }}">
                    </label>

                    <div class="w-full md:w-36 text-xs text-slate-400 flex flex-col gap-3">
                        <div>
                            <p class="font-medium text-slate-200">Panduan:</p>
                            <ul class="list-disc pl-4 mt-2">
                                <li>Format: JPG / PNG</li>
                                <li>Ukuran maksimal: 2MB</li>
                                <li>Rasio: 16:9 atau 4:3 direkomendasikan</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Link (opsional)</label>
                <input type="url" name="link" value="{{ old('link', $information->link) }}" class="w-full bg-slate-800 border border-slate-700 text-slate-100 p-3 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="https://contoh.com">
            </div>

            <div class="flex items-center gap-3 mt-2">
                <button type="submit" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">Update</button>
                <a href="{{ route('information.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-slate-700 rounded-lg text-slate-200 hover:bg-slate-800">Batal</a>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script src="{{ asset('js/information-upload.js') }}"></script>
@endsection