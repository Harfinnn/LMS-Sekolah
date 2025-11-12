@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:ml-64 mt-16 flex justify-center">
    <div class="w-[900px] bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Edit Guru</h1>

        @if(session('success'))
        <div role="alert" class="mb-4 px-4 py-3 rounded-lg bg-green-100 border border-green-400 text-green-800 flex items-center justify-between">
            <span class="flex items-center">
                <i class="fa-solid fa-circle-check mr-2"></i>
                {{ session('success') }}
            </span>
            <button type="button" onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        @endif

        <form action="{{ route('guru.update', $guru->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Nama (user) -->
            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', optional($guru->user)->name) }}"
                    class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Email (user) -->
            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', optional($guru->user)->email) }}"
                    class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Password (opsional) -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Password (kosongkan jika tidak ingin mengganti)</label>
                    <input type="password" name="password"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>
            </div>

            <!-- Mata Pelajaran -->
            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1">Mata Pelajaran</label>
                <input type="text" name="mata_pelajaran"
                    value="{{ old('mata_pelajaran', $guru->mata_pelajaran) }}"
                    class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                @error('mata_pelajaran') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $guru->phone) }}"
                    class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
            </div>

            <!-- Alamat lengkap -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Jika Anda menggunakan selector dinamis untuk provinsi/kabupaten/... pastikan JS akan mengisi/select sesuai nilai lama.
                     Jika tidak, kirim sebagai hidden agar nilai lama tidak hilang saat form dikirim. -->

                <!-- Provinsi -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Provinsi</label>
                    <input type="text" name="provinsi" value="{{ old('provinsi', $guru->provinsi) }}"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>

                <!-- Kabupaten -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Kabupaten / Kota</label>
                    <input type="text" name="kabupaten" value="{{ old('kabupaten', $guru->kabupaten) }}"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>

                <!-- Kecamatan -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Kecamatan</label>
                    <input type="text" name="kecamatan" value="{{ old('kecamatan', $guru->kecamatan) }}"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>

                <!-- Kelurahan -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Kelurahan / Desa</label>
                    <input type="text" name="kelurahan" value="{{ old('kelurahan', $guru->kelurahan) }}"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>

                <!-- Kampung / Dusun -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Kampung / Dusun</label>
                    <input type="text" name="kampung" value="{{ old('kampung', $guru->kampung) }}"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>

                <!-- Nama Jalan -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Nama Jalan / Alamat Lengkap</label>
                    <input type="text" name="alamat_jalan" value="{{ old('alamat_jalan', $guru->alamat_jalan) }}"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>

                <!-- RT -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">RT</label>
                    <input type="text" name="rt" value="{{ old('rt', $guru->rt) }}"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>

                <!-- RW -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">RW</label>
                    <input type="text" name="rw" value="{{ old('rw', $guru->rw) }}"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>

                <!-- Kode Pos -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Kode Pos</label>
                    <input type="text" name="kode_pos" value="{{ old('kode_pos', $guru->kode_pos) }}"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit"
                    class="w-1/2 mt-5 bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition-all shadow-md">
                    Update
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