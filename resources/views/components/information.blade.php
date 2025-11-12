<div id="informasi" class="container mx-auto px-10 py-12">
    <h2 class="text-3xl font-bold mb-8 text-green-600">
        Informasi Terbaru
    </h2>

    <div class="swiper swiperInformation">
        <div class="swiper-wrapper">
            @foreach ($informasi as $info)
            <div class="swiper-slide">
                <div class="bg-white rounded-lg shadow-sm dark:bg-gray-800 h-[450px] overflow-hidden flex flex-col">
                    <img class="rounded-t-lg w-full h-48 object-cover" src="{{ $info['gambar'] }}">

                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div class="overflow-hidden">
                            <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $info['judul'] }}
                            </h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400 text-sm text-limit mt-5">
                                {{ $info['deskripsi'] }}
                            </p>
                        </div>

                        <a href="#"
                            class="self-start inline-block mt-6 px-6 py-2 bg-green-600 text-white font-medium rounded-lg shadow-md 
                                hover:bg-green-700 transition duration-300">
                            Read more
                        </a>
                    </div>
                </div>
            </div>

            @endforeach
        </div>

        <!-- Navigasi & Pagination -->
        <div class="mt-20">
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>