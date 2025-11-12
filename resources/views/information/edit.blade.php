@extends('layouts.dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Informasi</h1>

<form action="{{ route('information.update', $information->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label>Judul</label>
        <input type="text" name="judul" class="w-full border p-2 rounded" value="{{ $information->judul }}" required>
    </div>

    <div>
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="w-full border p-2 rounded" rows="4" required>{{ $information->deskripsi }}</textarea>
    </div>

    <div>
        <label>Gambar Saat Ini</label><br>
        <img src="{{ $information->gambar }}" class="w-32 rounded mb-2">
        <input type="file" name="gambar" class="w-full border p-2 rounded">
    </div>

    <div>
        <label>Link (opsional)</label>
        <input type="url" name="link" class="w-full border p-2 rounded" value="{{ $information->link }}">
    </div>

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg">Update</button>
</form>
@endsection