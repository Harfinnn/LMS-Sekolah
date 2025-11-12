@props([
'address' => 'Jl. Raya Padalarang No.451, Kertajaya, Kec. Padalarang, Kabupaten Bandung Barat, Jawa Barat 40553',
'lat' => -6.8484689,
'lng' => 107.4926033,
'placeName' => 'SMK Negeri 4 Padalarang'
])

<section id="lokasi" aria-labelledby="location-heading" class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">

            <div class="space-y-6">
                <h2 id="location-heading" class="text-3xl font-extrabold text-green-600">Temukan Kami</h2>
                <p class="text-lg text-gray-600">
                    Kunjungi <strong>SMK Negeri 4 Padalarang</strong>. Klik tombol di bawah untuk membuka lokasi di Google Maps.
                </p>

                <div class="rounded-lg bg-white shadow p-6">
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $address }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama Tempat</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $placeName }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Kode Plus</dt>
                            <dd class="mt-1 text-sm text-gray-900">5F2V+J2 Kertajaya, Kabupaten Bandung Barat, Jawa Barat</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jam Operasional</dt>
                            <dd class="mt-1 text-sm text-gray-900">Senin — Jumat, 07:00 — 16:00</dd>
                        </div>
                    </dl>
                    <div class="mt-6 flex gap-3">
                        <!-- Tombol: Buka di Google Maps -->
                        <a
                            href="https://www.google.com/maps/search/?api=1&query={{ $lat }},{{ $lng }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <i class="fa-solid fa-map-location-dot mr-2"></i> Buka di Google Maps
                        </a>

                        <!-- Tombol: Dapatkan Arah di Google Maps -->
                        <a
                            href="https://www.google.com/maps/dir/?api=1&destination={{ $lat }},{{ $lng }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center px-4 py-2 border border-green-600 text-sm font-medium rounded-md text-green-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <i class="fa-solid fa-route mr-2"></i> Dapatkan Arah
                        </a>
                    </div>
                </div>
            </div>

            <!-- Map Column -->
            <div class="relative w-full h-80 rounded-lg overflow-hidden shadow">
                <div
                    id="map-location-{{ md5($address.$lat.$lng) }}"
                    data-lat="{{ $lat }}"
                    data-lng="{{ $lng }}"
                    data-place="{{ $placeName }}"
                    data-address="{{ $address }}"
                    class="w-full h-full"
                    role="img"
                    aria-label="Peta lokasi {{ $placeName }}"></div>

                <noscript>
                    <div class="absolute inset-0 flex items-center justify-center bg-gray-100 text-gray-600 p-4">
                        <p>Map tidak tersedia — aktifkan JavaScript atau klik “Buka di OSM”.</p>
                    </div>
                </noscript>
            </div>

        </div>
    </div>
</section>