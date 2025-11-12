@extends('layouts.app')

@section('content')
<div class="container mx-auto flex flex-col md:flex-row justify-between items-center px-10 mt-20">
    <div class="md:w-1/2 text-center md:text-left mb-10 md:mb-0">
        <h2 class="text-6xl font-bold mb-4 text-green-600">
            <span id="typed-text"
                data-strings='["Selamat Datang di Platform E-Learning", "Belajar Bersama Kami!", "Tingkatkan Potensi Belajarmu!"]'>
            </span>
        </h2>
        <p id="subtitle" class="text-lg text-gray-600 mt-2 opacity-0 transition-opacity duration-1000">
            Belajar kapan saja dan di mana saja dengan mudah.
        </p>
    </div>

    <div class="md:w-1/2 flex justify-center md:justify-end">
        <img src="{{ asset('images/Online-learning.png') }}"
            alt="E-Learning Illustration"
            class="w-80 md:w-96 h-auto rounded-xl">
    </div>
</div>

@endsection