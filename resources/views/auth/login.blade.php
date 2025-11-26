<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold text-center text-green-600 mb-6">Masuk ke Akun Anda</h2>

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <div class="relative z-0">
                <input type="email" name="email" id="email" value="{{ old('email') }}" 
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2
                    @error('email') border-red-600 focus:border-red-600 @else border-green-600 focus:border-green-600 @enderror
                    appearance-none focus:outline-none focus:ring-0 peer"
                    placeholder=" " />
                <label for="email"
                    class="absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0
                    peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
                    @error('email') text-red-600 dark:text-red-500 @else text-green-600 dark:text-green-500 @enderror
                    peer-focus:-translate-y-6 peer-focus:scale-75">
                    Email
                </label>
                @error('email')
                <p class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">Oh, snapp!</span> {{ $message }}</p>
                @enderror
            </div>

            <div class="relative z-0">
                <input type="password" name="password" id="password" 
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2
                    @error('password') border-red-600 focus:border-red-600 @else border-green-600 focus:border-green-600 @enderror
                    appearance-none focus:outline-none focus:ring-0 peer"
                    placeholder=" " />
                <label for="password"
                    class="absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0
                    peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
                    @error('password') text-red-600 dark:text-red-500 @else text-green-600 dark:text-green-500 @enderror
                    peer-focus:-translate-y-6 peer-focus:scale-75">
                    Password
                </label>
                @error('password')
                <p class="mt-2 text-xs text-red-600 dark:text-red-400"><span class="font-medium">Oh, snapp!</span> {{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center text-sm">
                <a href="{{ route('password.request') }}" class="text-green-600 hover:underline">Lupa password?</a>
            </div>

            <button type="submit"
                class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition duration-300">
                Masuk
            </button>

            <div class="text-center mt-4">
                <a href="/" class="text-sm text-green-600 hover:underline">
                    Kembali ke Home
                </a>
            </div>
        </form>
    </div>
</body>