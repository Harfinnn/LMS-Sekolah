@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:ml-64 mt-16">
    <div class="max-w-6xl mx-auto space-y-6">
        <h1 class="text-3xl font-extrabold text-green-400">Data Siswa</h1>

        @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 border border-green-400 text-green-800 flex items-center justify-between">
            <span><i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        @endif

        <div class="mb-4 flex justify-end">
            <a href="{{ route('siswa.create') }}"
                class="px-4 py-2 bg-gray-800 text-[#4ADE80] rounded-lg shadow hover:bg-gray-600 transition">
                Tambah Siswa
            </a>
        </div>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            No
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Nama
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Kelas
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Sub Kelas
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($siswa as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $item->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $item->user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $item->kelas ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $item->sub_kelas ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <a href="{{ route('siswa.edit', $item->id) }}" class="text-yellow-500 hover:text-yellow-700 mx-2">Edit</a>
                            <form action="{{ route('siswa.destroy', $item->id) }}" method="POST" class="inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-red-500 hover:text-red-700 mx-2 btn-delete" data-id="{{ $item->id }}">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 dark:text-gray-400 p-4">Belum ada data siswa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection