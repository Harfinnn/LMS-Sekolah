<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseMaterialController extends Controller
{
    /**
     * Form tambah materi/bab di dalam sebuah course
     * URL: /courses/{course}/materials/create
     */
    public function create(Course $course)
    {
        return view('course-materials.create', compact('course'));
    }

    /**
     * Simpan materi/bab baru
     * URL: POST /courses/{course}/materials
     */
    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'title'             => 'required|string|max:255',          // Bab 1 / Pertemuan 1
            'order'             => 'nullable|integer',                 // urutan
            'category'          => 'required|in:video,text',           // jenis materi
            'video_url'         => 'nullable|url',                     // untuk video
            'content'           => 'nullable|string',                  // untuk teks
            'file'              => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx',
            'short_description' => 'nullable|string|max:500',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('course_materials', 'public');
        }

        $order = $data['order']
            ?? ($course->materials()->max('order') + 1);

        $course->materials()->create([
            'title'             => $data['title'],
            'order'             => $order,
            'category'          => $data['category'],
            'video_url'         => $data['category'] === 'video' ? ($data['video_url'] ?? null) : null,
            'content'           => $data['category'] === 'text' ? ($data['content'] ?? null) : null,
            'file_path'         => $filePath,
            'short_description' => $data['short_description'] ?? null,
        ]);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Materi berhasil ditambahkan.');
    }

    /**
     * Form edit materi/bab tertentu
     * URL: /materials/{material}/edit
     */
    public function edit(Course $course, CourseMaterial $material)
    {
        $course = $material->course;

        return view('course-materials.edit', compact('course', 'material'));
    }

    /**
     * Update materi/bab
     * URL: PUT /materials/{material}
     */
    public function update(Request $request, Course $course, CourseMaterial $material)
    {
        $course = $material->course;

        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'order'             => 'nullable|integer',
            'category'          => 'required|in:video,text',
            'video_url'         => 'nullable|url',
            'content'           => 'nullable|string',
            'file'              => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx',
            'short_description' => 'nullable|string|max:500',
        ]);

        $filePath = $material->file_path;

        if ($request->hasFile('file')) {
            // hapus file lama kalau ada
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('file')->store('course_materials', 'public');
        }

        $order = $data['order'] ?? $material->order;

        $material->update([
            'title'             => $data['title'],
            'order'             => $order,
            'category'          => $data['category'],
            'video_url'         => $data['category'] === 'video' ? ($data['video_url'] ?? null) : null,
            'content'           => $data['category'] === 'text' ? ($data['content'] ?? null) : null,
            'file_path'         => $filePath,
            'short_description' => $data['short_description'] ?? null,
        ]);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Materi berhasil diperbarui.');
    }

    /**
     * Hapus materi/bab
     * URL: DELETE /materials/{material}
     */
    public function destroy(Course $course, CourseMaterial $material)
    {
        $course = $material->course;

        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->route('courses.show', $course)
            ->with('success', 'Materi berhasil dihapus.');
    }
}
