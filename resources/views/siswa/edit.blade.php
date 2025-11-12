@extends('layouts.dashboard')

@section('content')
<div class="p-4 sm:ml-64 mt-16 flex justify-center">
    <div class="w-[900px] bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Edit Siswa</h1>

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

        <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Nama Siswa (user.name) -->
            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1">Nama Siswa</label>
                <input type="text" name="name"
                    class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                    value="{{ old('name', optional($siswa->user)->name) }}">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Email (user.email) -->
            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1">Email</label>
                <input type="email" name="email"
                    class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                    value="{{ old('email', optional($siswa->user)->email) }}">
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

            <!-- NIS -->
            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1">NIS</label>
                <input type="text" name="nis"
                    class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                    value="{{ old('nis', $siswa->nis) }}">
                @error('nis') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Kelas & Sub Kelas -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Kelas</label>
                    <select name="kelas" required
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                        <option value="">Pilih Kelas</option>
                        <option value="X" {{ old('kelas', $siswa->kelas) == 'X' ? 'selected' : '' }}>X</option>
                        <option value="XI" {{ old('kelas', $siswa->kelas) == 'XI' ? 'selected' : '' }}>XI</option>
                        <option value="XII" {{ old('kelas', $siswa->kelas) == 'XII' ? 'selected' : '' }}>XII</option>
                    </select>
                    @error('kelas') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Sub Kelas</label>
                    <select name="sub_kelas" required
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                        <option value="">Pilih Sub Kelas</option>
                        <option value="A" {{ old('sub_kelas', $siswa->sub_kelas) == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('sub_kelas', $siswa->sub_kelas) == 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ old('sub_kelas', $siswa->sub_kelas) == 'C' ? 'selected' : '' }}>C</option>
                    </select>
                    @error('sub_kelas') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1">Phone</label>
                <input type="text" name="phone"
                    class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                    value="{{ old('phone', $siswa->phone) }}">
            </div>

            <!-- Alamat: Provinsi, Kabupaten, Kecamatan, Kelurahan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Provinsi -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Provinsi</label>
                    <select name="provinsi" id="provinsi"
                        data-selected="{{ old('provinsi', $siswa->provinsi ?? '') }}"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                        <option value="">Pilih Provinsi</option>
                        @if(!empty($siswa->provinsi))
                        <option value="{{ $siswa->provinsi }}" selected>{{ $siswa->provinsi }}</option>
                        @endif
                    </select>
                </div>

                <!-- Kabupaten / Kota -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Kabupaten / Kota</label>
                    <select name="kabupaten" id="kabupaten"
                        data-selected="{{ old('kabupaten', $siswa->kabupaten ?? '') }}"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                        <option value="">Pilih Kabupaten</option>
                        @if(!empty($siswa->kabupaten))
                        <option value="{{ $siswa->kabupaten }}" selected>{{ $siswa->kabupaten }}</option>
                        @endif
                    </select>
                </div>

                <!-- Kecamatan -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Kecamatan</label>
                    <select name="kecamatan" id="kecamatan"
                        data-selected="{{ old('kecamatan', $siswa->kecamatan ?? '') }}"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                        <option value="">Pilih Kecamatan</option>
                        @if(!empty($siswa->kecamatan))
                        <option value="{{ $siswa->kecamatan }}" selected>{{ $siswa->kecamatan }}</option>
                        @endif
                    </select>
                </div>

                <!-- Kelurahan / Desa -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Kelurahan / Desa</label>
                    <select name="kelurahan" id="kelurahan"
                        data-selected="{{ old('kelurahan', $siswa->kelurahan ?? '') }}"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                        <option value="">Pilih Kelurahan</option>
                        @if(!empty($siswa->kelurahan))
                        <option value="{{ $siswa->kelurahan }}" selected>{{ $siswa->kelurahan }}</option>
                        @endif
                    </select>
                </div>

                <!-- Kampung / Dusun -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Kampung / Dusun</label>
                    <input type="text" name="kampung"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                        value="{{ old('kampung', $siswa->kampung) }}">
                </div>

                <!-- Nama Jalan / Alamat Lengkap -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Nama Jalan / Alamat Lengkap</label>
                    <input type="text" name="alamat_jalan"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                        value="{{ old('alamat_jalan', $siswa->alamat_jalan) }}">
                </div>

                <!-- RT -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">RT</label>
                    <input type="text" name="rt"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                        value="{{ old('rt', $siswa->rt) }}">
                </div>

                <!-- RW -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">RW</label>
                    <input type="text" name="rw"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                        value="{{ old('rw', $siswa->rw) }}">
                </div>

                <!-- Kode Pos -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Kode Pos</label>
                    <input type="text" name="kode_pos"
                        class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                        value="{{ old('kode_pos', $siswa->kode_pos) }}">
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit"
                    class="w-1/2 mt-5 bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition-all shadow-md">
                    Update
                </button>
                <a href="{{ route('siswa.index') }}"
                    class="w-1/2 mt-5 text-center bg-gray-400 text-white font-semibold py-3 rounded-lg hover:bg-gray-500 transition-all shadow-md">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection