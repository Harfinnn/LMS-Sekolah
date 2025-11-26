<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        $images = GalleryImage::orderBy('created_at', 'desc')->paginate(12);

        return view('gallery.index', compact('images'));
    }

    public function create()
    {
        return view('gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|max:5120',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('gallery', $filename, 'public');

                GalleryImage::create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('gallery.index')->with('success', 'Gambar berhasil diunggah.');
    }

    public function destroy(GalleryImage $gallery)
    {
        $path = $gallery->path;

        if ($path) {
            if (Str::startsWith($path, 'http')) {
                $parsed = parse_url($path, PHP_URL_PATH) ?: '';
                $pos = strpos($parsed, '/storage/');
                if ($pos !== false) {
                    $path = substr($parsed, $pos + strlen('/storage/'));
                } else {
                    $path = ltrim($parsed, '/');
                }
            } elseif (Str::startsWith($path, 'storage/')) {
                $path = substr($path, strlen('storage/'));
            }

            try {
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            } catch (\Exception $e) {
            }
        }

        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Gambar dihapus.');
    }
}
