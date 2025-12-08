<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    /**
     * Tampilkan daftar course (misal: Matematika X A, Programming XI B, dst)
     */
    public function index(Request $request)
    {
        $grade   = $request->input('grade');
        $class   = $request->input('class');
        $subject = $request->input('subject');

        $query = Course::query();

        if ($grade) {
            $query->where('grade_level', $grade);
        }

        if ($class) {
            $query->where('class_group', $class);
        }

        if ($subject) {
            $query->where('subject', 'like', '%' . $subject . '%');
        }

        $courses = $query->orderBy('subject')
            ->orderBy('grade_level')
            ->orderBy('class_group')
            ->get();

        return view('courses.index', compact('courses', 'grade', 'class', 'subject'));
    }

    /**
     * Form buat course baru (container mapel per kelas)
     * Contoh: Course = "Matematika Kelas X A"
     */
    public function create(Request $request)
    {
        $grade   = $request->input('grade');
        $class   = $request->input('class');
        $subject = $request->input('subject');

        return view('courses.create', compact('grade', 'class', 'subject'));
    }

    /**
     * Simpan course baru
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'subject'     => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('courses')->where(function ($query) use ($request) {
                        return $query->where('grade_level', $request->grade_level)
                            ->where('class_group', $request->class_group);
                    }),
                ],
                'grade_level' => ['required', Rule::in(['X', 'XI', 'XII'])],
                'class_group' => ['required', Rule::in(['A', 'B', 'C'])],
            ],
            [
                'subject.unique' => 'Course dengan kombinasi mapel, tingkat, dan sub kelas ini sudah ada.',
            ]
        );

        Course::create($data);

        return redirect()->route('courses.index')->with('success', 'Course berhasil dibuat');
    }


    /**
     * Tampilkan detail course + sidebar daftar materi di dalamnya
     */
    public function show(Request $request, Course $course)
    {
        // muat relasi materials (daftar bab/materi)
        $course->load('materials');

        $materials = $course->materials;

        // materi aktif (default: pertama)
        $activeMaterial = $materials->first();

        if ($request->filled('material')) {
            $activeMaterial = $materials->firstWhere('id', $request->material) ?? $activeMaterial;
        }

        return view('courses.show', compact('course', 'materials', 'activeMaterial'));
    }

    /**
     * Form edit course (kalau mau ubah nama mapel / kelas)
     */
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    /**
     * Update data course
     */
    public function update(Request $request, Course $course)
    {
        $data = $request->validate(
            [
                'subject'     => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('courses')
                        ->ignore($course->id) // abaikan record dirinya sendiri
                        ->where(function ($query) use ($request) {
                            return $query->where('grade_level', $request->grade_level)
                                ->where('class_group', $request->class_group);
                        }),
                ],
                'grade_level' => ['required', Rule::in(['X', 'XI', 'XII'])],
                'class_group' => ['required', Rule::in(['A', 'B', 'C'])],
            ],
            [
                'subject.unique' => 'Mata Pelajaran pada kelas ini sudah ada',
            ]
        );

        $course->update($data);

        return redirect()->route('courses.index')
            ->with('success', 'Mata Pelajaran berhasil diperbarui.');
    }

    /**
     * Hapus course (otomatis menghapus semua materials lewat onDelete('cascade'))
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course dan semua materi di dalamnya berhasil dihapus.');
    }
}
