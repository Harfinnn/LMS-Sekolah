@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:ml-64 mt-16 flex justify-center">
    <div class="w-[900px] bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Tambah Guru</h1>

        {{-- ALERT SUCCESS --}}
        @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 border border-green-400 text-green-800 flex items-center justify-between">
            <span><i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        @endif

        <form action="{{ route('guru.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1">Nama Guru</label>
                <input type="text" name="name" placeholder="Masukkan nama"
                    class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                    value="{{ old('name') }}">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1">Email</label>
                <input type="email" name="email" placeholder="Masukkan email"
                    class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                    value="{{ old('email') }}">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Password</label>
                    <input type="password" name="password"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Konfirmasi</label>
                    <input type="password" name="password_confirmation"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1">Mata Pelajaran</label>
                <input type="text" name="mata_pelajaran" placeholder="Contoh: Matematika"
                    class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                    value="{{ old('mata_pelajaran') }}">
                @error('mata_pelajaran') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1">Phone</label>
                <input type="text" name="phone"
                    class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                    value="{{ old('phone') }}">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Provinsi</label>
                    <select name="provinsi" id="provinsi"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                        <option value="">Pilih Provinsi</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Kabupaten / Kota</label>
                    <select name="kabupaten" id="kabupaten"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                        <option value="">Pilih Kabupaten</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Kecamatan</label>
                    <select name="kecamatan" id="kecamatan"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                        <option value="">Pilih Kecamatan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Kelurahan / Desa</label>
                    <select name="kelurahan" id="kelurahan"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                        <option value="">Pilih Kelurahan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Kampung / Dusun</label>
                    <input type="text" name="kampung"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                        value="{{ old('kampung') }}">
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Nama Jalan / Alamat Lengkap</label>
                    <input type="text" name="alamat_jalan" placeholder="Contoh: Jl. Merdeka No.10"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                        value="{{ old('alamat_jalan') }}">
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">RT</label>
                    <input type="text" name="rt" placeholder="Contoh: 01"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                        value="{{ old('rt') }}">
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">RW</label>
                    <input type="text" name="rw" placeholder="Contoh: 05"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                        value="{{ old('rw') }}">
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Kode Pos</label>
                    <input type="text" name="kode_pos"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                        value="{{ old('kode_pos') }}">
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="w-1/2 mt-5 bg-green-500 text-white font-semibold py-3 rounded-lg hover:bg-green-600 transition-all shadow-md">
                    Simpan
                </button>
                <a href="{{ route('guru.index') }}"
                    class="w-1/2 mt-5 text-center bg-gray-400 text-white font-semibold py-3 rounded-lg hover:bg-gray-500 transition-all shadow-md">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>
@endsection