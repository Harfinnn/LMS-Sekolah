@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:ml-64 mt-16">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-2xl font-extrabold text-slate-800">Kelola Informasi</h1>

        <div class="flex items-center gap-3">
            <a href="{{ route('information.create') }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow"> 
                <!-- Plus icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                Tambah
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 p-3 rounded mb-4 shadow-sm">{{ session('success') }}</div>
    @endif

    {{-- Grid cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($informasi as $info)
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition p-4 flex flex-col">
            <div class="h-40 w-full mb-4 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center">
                @if($info->gambar)
                    <img src="{{ $info->gambar }}" alt="{{ $info->judul }}" class="object-cover w-full h-full" />
                @else
                    <div class="text-gray-400">Tidak ada gambar</div>
                @endif
            </div>

            <div class="flex-1">
                <h2 class="text-lg font-semibold text-slate-800 mb-1">{{ $info->judul }}</h2>
                <p class="text-sm text-slate-600 mb-3 line-clamp-3" style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">{!! nl2br(e($info->deskripsi)) !!}</p>
            </div>

            <div class="mt-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <a href="{{ route('information.edit', $info->id) }}" class="inline-flex items-center gap-2 px-3 py-1.5 border rounded-md text-sm text-blue-600 border-blue-100 hover:bg-blue-50"> 
                        <!-- Edit icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 010 2.828L8.828 14H6v-2.828l8.586-8.586a2 2 0 012.828 0z"/></svg>
                        Edit
                    </a>

                    <form action="{{ route('information.destroy', $info->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus informasi ini?');" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 px-3 py-1.5 border rounded-md text-sm text-red-600 border-red-100 hover:bg-red-50"> 
                            <!-- Trash icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H3.5A1.5 1.5 0 002 5.5V6h16v-.5A1.5 1.5 0 0016.5 4H15V3a1 1 0 00-1-1H6zm2 6a1 1 0 10-2 0v7a1 1 0 102 0V8zm6 0a1 1 0 10-2 0v7a1 1 0 102 0V8z" clip-rule="evenodd"/></svg>
                            Hapus
                        </button>
                    </form>
                </div>

                <span class="text-xs text-slate-500">{{ $info->created_at->format('d M Y') }}</span>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-yellow-50 border border-yellow-100 p-6 rounded">Belum ada informasi. <a href="{{ route('information.create') }}" class="text-green-600 underline">Tambahkan sekarang</a>.</div>
        @endforelse
    </div>

</div>
@endsection