@extends('layouts.dashboard')

@section('content')
<!-- ===== DASHBOARD OVERVIEW SECTION ===== -->
<section class="p-4 sm:ml-64 mt-16 flex flex-col gap-[30px]">

    <!-- === Header Overview === -->
    <header class="flex items-center justify-between">
        <h1 class="font-extrabold text-2xl text-black">Overview</h1>
    </header>

    <!-- === Main Overview Content === -->
    <x-overview />

</section>


<!-- ===== SCHEDULE SECTION ===== -->
<section class="p-2 sm:ml-64 grid grid-cols-1 md:grid-cols-2 gap-[30px]">
    <!-- === Today's Schedule === -->
    <x-today-schedule />

    <!-- === Upcoming Schedule === -->
    <x-upcoming-schedule />
</section>
@endsection