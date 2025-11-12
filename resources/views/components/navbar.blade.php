<nav class="dark:bg-gray-900 shadow-md py-4">
    <div class="container mx-auto flex justify-between items-center px-10">
        <h1 class="text-2xl font-bold text-green-600">E-Learning</h1>

        <button id="menu-btn" class="block md:hidden text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <div id="menu" class="hidden md:flex space-x-8 font-bold">
            <a href="/login" class="text-white hover:text-green-600">Login</a>
            <a href="#media" class="text-white hover:text-green-600">Media</a>
            <a href="#informasi" class="text-white hover:text-green-600">Informasi</a>
            <a href="#lokasi" class="text-white hover:text-green-600">Lokasi</a>
        </div>
    </div>

    <div id="mobile-menu" class="md:hidden hidden flex-col font-bold space-y-2 mt-3 px-10">
        <a href="/login" class="block text-white hover:text-green-600">Login</a>
        <a href="#media" class="block text-white hover:text-green-600">Media</a>
        <a href="#informasi" class="block text-white hover:text-green-600">Informasi</a>
        <a href="#lokasi" class="text-white hover:text-green-600">Lokasi</a>
    </div>
</nav>
