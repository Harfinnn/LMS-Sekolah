<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::with('user')->get();
        return view('guru.index', compact('guru'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'mata_pelajaran' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'provinsi' => 'required|string',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'alamat_jalan' => 'required|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'kode_pos' => 'nullable|string|max:10',
            'kampung' => 'nullable|string|max:50',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'role' => 'guru',
            ]);

            Guru::create([
                'user_id' => $user->id,
                'mata_pelajaran' => $request->input('mata_pelajaran'),
                'phone' => $request->input('phone'),
                'provinsi' => $request->input('provinsi'),
                'kabupaten' => $request->input('kabupaten'),
                'kecamatan' => $request->input('kecamatan'),
                'kelurahan' => $request->input('kelurahan'),
                'alamat_jalan' => $request->input('alamat_jalan'),
                'kampung' => $request->input('kampung'),
                'rt' => $request->input('rt'),
                'rw' => $request->input('rw'),
                'kode_pos' => $request->input('kode_pos'),
            ]);

            DB::commit();

            return redirect()->route('guru.index')->with('success', 'Data guru dan akun login berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data guru.']);
        }
    }

    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($guru->user_id),
            ],
            'password' => 'nullable|string|min:6|confirmed',
            'mata_pelajaran' => 'sometimes|required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'provinsi' => 'sometimes|required|string',
            'kabupaten' => 'sometimes|required|string',
            'kecamatan' => 'sometimes|required|string',
            'kelurahan' => 'sometimes|required|string',
            'alamat_jalan' => 'sometimes|required|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'kode_pos' => 'nullable|string|max:10',
            'kampung' => 'nullable|string|max:50',
        ]);

        $guruFields = [
            'mata_pelajaran',
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
            $user = $guru->user;
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

            $updateData = [];
            foreach ($guruFields as $field) {
                if ($request->has($field)) {
                    $updateData[$field] = $request->input($field);
                }
            }

            if (!empty($updateData)) {
                $guru->update($updateData);
            }

            DB::commit();

            return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data guru.']);
        }
    }

    public function destroy(Guru $guru)
    {
        DB::beginTransaction();
        try {
            $user = $guru->user;
            $guru->delete();

            if ($user) {
                $user->delete();
            }

            DB::commit();
            return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus data guru.']);
        }
    }
}
