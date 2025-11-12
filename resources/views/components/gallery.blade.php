<div id="media" class="container mx-auto px-10 py-12">
    <h2 class="text-3xl font-bold mb-8 text-green-600">Media E-Learning</h2>

    <!-- GRID untuk layar besar -->
    <div id="galleryGrid" class="hidden md:grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach (array_slice(array_reverse($images), 0, 12) as $index => $image)
        @php
        $url = is_array($image) ? ($image['url'] ?? '') : (is_string($image) ? $image : '');
        $alt = is_array($image) ? ($image['alt'] ?? 'Gallery image') : 'Gallery image';
        @endphp

        <div class="gallery-item overflow-hidden rounded-lg relative group">
            <img
                src="{{ $url }}"
                alt="{{ $alt }}"
                class="w-full h-40 sm:h-48 md:h-52 lg:h-56 object-cover rounded-lg group-hover:scale-105 transition-transform duration-300 shadow-md cursor-pointer"
                data-modal-target="imageModal{{ $index }}"
                data-modal-toggle="imageModal{{ $index }}">
        </div>

        <!-- Modal -->
        <div id="imageModal{{ $index }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)]">
            <div class="relative p-4 w-full max-w-3xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                    <div class="flex items-center justify-between p-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Preview Gambar</h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="imageModal{{ $index }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 12 12M13 1 1 13" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-5 flex justify-center">
                        <img src="{{ $url }}" alt="{{ $alt }}" class="max-h-[80vh] rounded-lg">
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- SWIPER untuk layar kecil (tampilkan semua gambar) -->
    <div class="md:hidden">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach (array_slice(array_reverse($images), 0, 12) as $index => $image)
                @php $url = is_array($image) ? ($image['url'] ?? '') : (is_string($image) ? $image : ''); @endphp
                <div class="swiper-slide flex justify-center">
                    <img
                        src="{{ $url }}"
                        alt="Gallery image"
                        class="w-full h-48 object-cover rounded-lg shadow-md pointer-events-none select-none">
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>