{{-- resources/views/components/sidebar-courses.blade.php --}}
@props([
'materials' => collect(),
'activeMaterial' => null,
'course' => null,
])

<aside
    id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 sm:pt-20 transition-transform
           -translate-x-full sm:translate-x-0 bg-gray-900 border-r border-gray-700 p-4"
    aria-label="Sidebar">

    <div class="h-full overflow-y-auto">

        {{-- Judul kecil di atas list (optional) --}}
        <div class="hidden sm:block mb-2">
            <h2 class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                Daftar Materi / Bab
            </h2>
        </div>

        @if($materials->isEmpty())
        <p class="text-xs text-gray-500 italic sm:mt-2 mt-4">
            Belum ada materi di course ini.
        </p>
        @else
        <ul class="space-y-4 sm:pt-2 pt-6">
            @foreach($materials as $material)
            @php
            $isActive = $activeMaterial && $activeMaterial->id === $material->id;
            @endphp
            <li>
                <a href="{{ route('courses.show', $course) }}?material={{ $material->id }}"
                    class="block p-2 rounded-lg transition duration-150 ease-in-out
                                   {{ $isActive
                                       ? 'bg-green-600 text-white shadow-lg'
                                       : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">

                    <div class="font-semibold truncate">
                        {{ $material->title }}
                    </div>

                    @if($material->short_description)
                    <div class="text-[11px] mt-0.5 opacity-75 truncate
                                            {{ $isActive ? 'text-indigo-200' : 'text-gray-400' }}">
                        {{ $material->short_description }}
                    </div>
                    @endif
                </a>
            </li>
            @endforeach
        </ul>
        @endif
    </div>
</aside>