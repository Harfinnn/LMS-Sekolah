<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('user')->get();
        return view('siswa.index', compact('siswa'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'nis' => 'required|string|max:50|unique:siswa,nis',
            'kelas' => ['required', Rule::in(['X', 'XI', 'XII'])],
            'sub_kelas' => ['required', Rule::in(['A', 'B', 'C'])],
            'phone' => 'nullable|string|max:20',
            'provinsi' => 'nullable|string',
            'kabupaten' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kelurahan' => 'nullable|string',
            'alamat_jalan' => 'nullable|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'kode_pos' => 'nullable|string|max:10',
            'kampung' => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();
        try {
            // Buat user baru untuk siswa
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'role' => 'siswa',
            ]);

            // Buat data siswa
            Siswa::create([
                'user_id' => $user->id,
                'nis' => $request->input('nis'),
                'kelas' => $request->input('kelas'),
                'sub_kelas' => $request->input('sub_kelas'),
                'phone' => $request->input('phone'),
                'provinsi' => $request->input('provinsi'),
                'kabupaten' => $request->input('kabupaten'),
                'kecamatan' => $request->input('kecamatan'),
                'kelurahan' => $request->input('kelurahan'),
                'alamat_jalan' => $request->input('alamat_jalan'),
                'rt' => $request->input('rt'),
                'rw' => $request->input('rw'),
                'kode_pos' => $request->input('kode_pos'),
                'kampung' => $request->input('kampung'),
            ]);

            DB::commit();

            return redirect()->route('siswa.index')->with('success', 'Data siswa dan akun login berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data siswa.']);
        }
    }

    public function edit(Siswa $siswa)
    {
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        // validasi: gunakan Rule::unique untuk email/nis dengan ignore pada record yang sama
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($siswa->user_id),
            ],
            'password' => 'nullable|string|min:6|confirmed',
            'nis' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('siswa', 'nis')->ignore($siswa->id),
            ],
            'kelas' => ['sometimes', Rule::in(['X', 'XI', 'XII'])],
            'sub_kelas' => ['sometimes', Rule::in(['A', 'B', 'C'])],
            'phone' => 'nullable|string|max:20',
            'provinsi' => 'nullable|string',
            'kabupaten' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kelurahan' => 'nullable|string',
            'alamat_jalan' => 'nullable|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'kode_pos' => 'nullable|string|max:10',
            'kampung' => 'nullable|string|max:100',
        ]);

        // fields siswa yang boleh diupdate
        $siswaFields = [
            'nis',
            'kelas',
            'sub_kelas',
            'phone',
            'provinsi',
            'kabupaten',
            'kecamatan',
            'kelurahan',
            'alamat_jalan',
            'rt',
            'rw',
            'kode_pos',
            'kampung'
        ];

        DB::beginTransaction();
        try {
            // Update user jika form mengirim perubahan (name/email/password)
            $user = $siswa->user;
            if ($user) {
                $userData = [];
                if ($request->has('name')) {
                    $userData['name'] = $request->input('name');
                }
                if ($request->has('email')) {
                    $userData['email'] = $request->input('email');
                }
                if ($request->filled('password')) {
                    $userData['password'] = bcrypt($request->input('password'));
                }
                if (!empty($userData)) {
                    $user->update($userData);
                }
            }

            // Update data siswa: hanya field yang dikirim oleh form (menghindari overwrite null)
            $updateData = [];
            foreach ($siswaFields as $field) {
                if ($request->has($field)) {
                    $updateData[$field] = $request->input($field);
                }
            }

            if (!empty($updateData)) {
                $siswa->update($updateData);
            }

            DB::commit();

            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data siswa.']);
        }
    }

    public function destroy(Siswa $siswa)
    {
        DB::beginTransaction();
        try {
            $user = $siswa->user;
            $siswa->delete();

            // hapus user terkait (opsional — hapus baris ini kalau tidak ingin menghapus akun)
            if ($user) {
                $user->delete();
            }

            DB::commit();
            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus data siswa.']);
        }
    }
}
