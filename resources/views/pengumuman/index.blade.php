@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:ml-64 mt-16 flex flex-col gap-[30px]">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Kelola Gallery</h1>
        <a href="{{Route('pengumuman.create')}}" class="px-4 py-2 bg-green-600 text-white rounded">Tambah Gambar</a>
    </div>

    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach ($images as $img)
        <div class="bg-white p-3 rounded shadow">
            <img src="{{ $img['url'] }}" alt="{{ $img['alt'] }}" class="w-full h-40 object-cover rounded mb-2">
            <div class="flex gap-2">
                <form action="{{ route('pengumuman.destroy', $img->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded">Hapus</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    @if ($images->hasPages())
    <div class="p-6  flex justify-center">
        <nav class="inline-flex rounded-lg shadow-sm border border-green-200 overflow-hidden">
            {{-- Tombol Previous --}}
            @if ($images->onFirstPage())
            <span class="px-4 py-2 text-gray-400 bg-gray-100 cursor-not-allowed select-none">‹</span>
            @else
            <a href="{{ $images->previousPageUrl() }}" class="px-4 py-2 bg-white text-green-600 hover:bg-green-50 transition">‹</a>
            @endif

            {{-- Nomor halaman --}}
            @foreach ($images->getUrlRange(1, $images->lastPage()) as $page => $url)
            @if ($page == $images->currentPage())
            <span class="px-4 py-2 bg-green-600 text-white font-semibold">{{ $page }}</span>
            @else
            <a href="{{ $url }}" class="px-4 py-2 bg-white text-green-600 hover:bg-green-50">{{ $page }}</a>
            @endif
            @endforeach

            {{-- Tombol Next --}}
            @if ($images->hasMorePages())
            <a href="{{ $images->nextPageUrl() }}" class="px-4 py-2 bg-white text-green-600 hover:bg-green-50 transition">›</a>
            @else
            <span class="px-4 py-2 text-gray-400 bg-gray-100 cursor-not-allowed select-none">›</span>
            @endif
        </nav>
    </div>
    @endif


</div>
@endsection