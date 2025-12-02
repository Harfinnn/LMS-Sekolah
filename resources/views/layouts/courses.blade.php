<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'E-Learning Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}" />
    <meta name="theme-color" content="#ffffff" />

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        crossorigin="anonymous" />

    @stack('head')
</head>

<body class="min-h-screen flex flex-col bg-gray-50">

    <x-navbar-courses />

    <x-sidebar-courses
        :materials="$materials ?? collect()"
        :active-material="$activeMaterial ?? null"
        :course="$course ?? null" />


    <main class="flex-grow">
        @yield('content')
    </main>

</body>

</html>