@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:ml-64 mt-16 flex flex-col gap-[30px]">
    <h1 class="text-2xl font-bold mb-4">Tambah Informasi</h1>

    <form action="{{ route('information.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label>Judul</label>
            <input type="text" name="judul" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="w-full border p-2 rounded" rows="4" required></textarea>
        </div>

        <div>
            <label>Gambar</label>
            <input type="file" name="gambar" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label>Link (opsional)</label>
            <input type="url" name="link" class="w-full border p-2 rounded">
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg">Simpan</button>
    </form>
</div>
@endsection