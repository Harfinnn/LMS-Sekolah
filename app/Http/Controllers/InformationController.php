<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InformationImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformationController extends Controller
{
    public function index()
    {
        $informasi = InformationImage::latest()->get();
        return view('information.index', compact('informasi'));
    }

    public function create()
    {
        return view('information.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'link' => 'nullable|url',
        ]);

        $path = $request->file('gambar')->store('information', 'public');

        InformationImage::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'gambar' => '/storage/' . $path,
            'link' => $validated['link'] ?? '#',
        ]);

        return redirect()->route('information.index')->with('success', 'Informasi berhasil ditambahkan.');
    }

    public function edit(InformationImage $information)
    {
        return view('information.edit', compact('information'));
    }

    public function update(Request $request, InformationImage $information)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'link' => 'nullable|url',
        ]);

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $information->gambar));
            $path = $request->file('gambar')->store('information', 'public');
            $validated['gambar'] = '/storage/' . $path;
        }

        $information->update($validated);

        return redirect()->route('information.index')->with('success', 'Informasi berhasil diperbarui.');
    }

    public function destroy(InformationImage $information)
    {
        Storage::disk('public')->delete(str_replace('/storage/', '', $information->gambar));
        $information->delete();

        return redirect()->route('information.index')->with('success', 'Informasi berhasil dihapus.');
    }
}
