@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:ml-64 mt-16 flex flex-col gap-[30px]">
    <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-bold">Kelola Informasi</h1>
        <a href="{{ route('information.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg">Tambah</a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full border">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-2">Judul</th>
                <th class="p-2">Deskripsi</th>
                <th class="p-2">Gambar</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($informasi as $info)
            <tr class="border-t">
                <td class="p-2">{{ $info->judul }}</td>
                <td class="p-2 text-sm">{{ Str::limit($info->deskripsi, 50) }}</td>
                <td class="p-2"><img src="{{ $info->gambar }}" class="w-24 rounded"></td>
                <td class="p-2">
                    <a href="{{ route('information.edit', $info->id) }}" class="text-blue-600">Edit</a> |
                    <form action="{{ route('information.destroy', $info->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button class="text-red-600" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection