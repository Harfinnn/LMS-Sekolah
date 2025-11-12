@php
// Buat koleksi nama file 1..10 lalu mapping jadi array partner
$partnerFiles = collect(range(1, 10))->map(function ($i) {
    return [
        'name' => 'Partner ' . $i,
        'logo' => asset("images/partners/{$i}.svg"),
        'url'  => '#',
    ];
})->values(); // ->values() untuk memastikan index berurutan

// Ambil 5 pertama untuk kanan, 5 berikutnya untuk kiri (kembalikan sebagai array)
$partnersRight = $partnerFiles->slice(0, 5)->all();
$partnersLeft  = $partnerFiles->slice(5, 5)->all();
@endphp



<section aria-labelledby="partners-heading" class="py-12 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <h2 id="partners-heading" class="text-2xl font-bold text-green-600">Our Partners</h2>
        </div>

        <div class="mt-10 space-y-8">
            <!-- Row 1: ke kanan -->
            <div class="overflow-hidden relative">
                <div class="partners-track partners-track--right will-change-transform" style="animation-duration: 25s;">
                    @foreach ($partnersRight as $p)
                    <a href="{{ $p['url'] }}" target="_blank" rel="noopener noreferrer" class="partner-item inline-flex items-center justify-center p-4 opacity-90 hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <img src="{{ $p['logo'] }}" alt="{{ $p['name'] }} logo" class="h-16 object-contain grayscale hover:grayscale-0 transition-transform duration-500 hover:scale-110" />
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Row 2: ke kiri -->
            <div class="overflow-hidden relative">
                <div class="partners-track partners-track--left will-change-transform" style="animation-duration: 25s;">
                    @foreach ($partnersLeft as $p)
                    <a href="{{ $p['url'] }}" target="_blank" rel="noopener noreferrer" class="partner-item inline-flex items-center justify-center p-4 opacity-90 hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <img src="{{ $p['logo'] }}" alt="{{ $p['name'] }} logo" class="h-16 object-contain grayscale hover:grayscale-0 transition-transform duration-500 hover:scale-110" />
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <style>
        .partners-track {
            display: flex;
            gap: 2rem;
            align-items: center;
            white-space: nowrap;
        }

        @keyframes scroll-left {
            0% {
                transform: translateX(0%);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        @keyframes scroll-right {
            0% {
                transform: translateX(-50%);
            }

            100% {
                transform: translateX(0%);
            }
        }

        .partners-track--left {
            animation: scroll-left 25s linear infinite;
        }

        .partners-track--right {
            animation: scroll-right 25s linear infinite;
        }

        .partners-track:hover {
            animation-play-state: paused;
        }

        @media (max-width: 640px) {
            .partners-track {
                animation: none !important;
                flex-wrap: wrap;
                justify-content: center;
            }
        }
    </style>
</section>