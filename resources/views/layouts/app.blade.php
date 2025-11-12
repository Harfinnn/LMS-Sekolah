<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..."
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
</head>

<body class="flex flex-col min-h-screen bg-gray-50">

    <x-navbar />

    <main class="flex-grow">
        @yield('content')
    </main>

    <x-gallery />

    <x-information />

    <x-partners />

    <x-location />

    <x-footer />
</body>

</html>