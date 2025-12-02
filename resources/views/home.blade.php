@extends('layouts.dashboard')

@section('content')
<section class="p-4 sm:ml-64 mt-16 flex flex-col gap-[30px]">

    <header class="flex items-center justify-between">
        <h1 class="font-extrabold text-2xl text-black">Overview</h1>
    </header>

    <x-overview />

</section>


<section class="p-8 sm:ml-64 grid grid-cols-1 md:grid-cols-2 gap-[30px]">
    <x-today-schedule />

    <x-upcoming-schedule />
</section>
@endsection