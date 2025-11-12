<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">

    {{-- ALERT DI LUAR FORM --}}
    @if(session('success'))
    <div id="alert-success" class="fixed top-5 left-1/2 transform -translate-x-1/2 w-full max-w-md flex items-center p-4 text-sm text-green-800 rounded-lg bg-green-50 shadow-lg z-50 transition-all duration-500" role="alert">
        <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>
        <div>
            <span class="font-medium">Success!</span> {{ session('success') }}
        </div>
    </div>
    @endif

    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg">

        {{-- Jika ada token reset (halaman ubah password) --}}
        @if(isset($token))
        <h2 class="text-2xl font-bold text-center text-green-600 mb-6">Reset Password</h2>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            {{-- Email --}}
            <div class="relative z-0">
                <input type="email" name="email" id="email" value="{{ request('email') }}"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2
                    @error('email') border-red-600 focus:border-red-600 @else border-green-600 focus:border-green-600 @enderror
                    appearance-none focus:outline-none focus:ring-0 peer"
                    placeholder=" " readonly />
                <label for="email"
                    class="absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                    @error('email') text-red-600 @else text-green-600 @enderror
                    peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6 peer-focus:scale-75">
                    Email
                </label>
                @error('email')
                <p class="mt-2 text-xs text-red-600"><span class="font-medium">Oh, snapp!</span> {{ $message }}</p>
                @enderror
            </div>

            {{-- Password Baru --}}
            <div class="relative z-0">
                <input type="password" name="password" id="password"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2
                    @error('password') border-red-600 focus:border-red-600 @else border-green-600 focus:border-green-600 @enderror
                    appearance-none focus:outline-none focus:ring-0 peer"
                    placeholder=" " />
                <label for="password"
                    class="absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                    @error('password') text-red-600 @else text-green-600 @enderror
                    peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6 peer-focus:scale-75">
                    Password Baru
                </label>
                @error('password')
                <p class="mt-2 text-xs text-red-600"><span class="font-medium">Oh, snapp!</span> {{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="relative z-0">
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-green-600 focus:border-green-600 appearance-none focus:outline-none focus:ring-0 peer"
                    placeholder=" " />
                <label for="password_confirmation"
                    class="absolute text-sm text-green-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                    peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6 peer-focus:scale-75">
                    Konfirmasi Password
                </label>
            </div>

            <button type="submit"
                class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition duration-300">
                Reset Password
            </button>
        </form>

        {{-- Jika belum ada token (halaman lupa password) --}}
        @else
        <h2 class="text-2xl font-bold text-center text-green-600 mb-6">Lupa Password</h2>
        <p class="text-gray-600 text-sm text-center mb-6">
            Masukkan alamat email Anda, kami akan mengirim link untuk mengatur ulang password.
        </p>

        <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
            @csrf

            <div class="relative z-0">
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2
                    @error('email') border-red-600 focus:border-red-600 @else border-green-600 focus:border-green-600 @enderror
                    appearance-none focus:outline-none focus:ring-0 peer"
                    placeholder=" " />
                <label for="email"
                    class="absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                    @error('email') text-red-600 @else text-green-600 @enderror
                    peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6 peer-focus:scale-75">
                    Email
                </label>
                @error('email')
                <p class="mt-2 text-xs text-red-600"><span class="font-medium">Oh, snapp!</span> {{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition duration-300">
                Kirim Link Reset
            </button>
        </form>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm text-green-600 hover:underline">
                Kembali ke Login
            </a>
        </div>
    </div>
</body>
