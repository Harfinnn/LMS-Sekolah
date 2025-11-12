@php
   $role = optional(Auth::user())->role;
@endphp

<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
   <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
         <div class="flex items-center justify-start rtl:justify-end">
            <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
               <span class="sr-only">Open sidebar</span>
               <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
               </svg>
            </button>
            <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap text-green-600 px-2">E-Learning</span>
         </div>
      </div>
   </div>
</nav>

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
   <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
      <ul class="space-y-2 font-medium">
         <li>
            <a href="{{ route('home') }}" class="flex items-center p-4 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <i class="fa fa-home w-5 h-5 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white"></i>
               <span class="ms-3">Dashboard</span>
            </a>
         </li>

         @if($role !== 'guru' && $role !== 'siswa')
         <li>
            <a href="{{ route('siswa.index') }}" class="flex items-center p-4 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <i class="fa fa-user-graduate w-5 h-5 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white"></i>
               <span class="ms-3">Data Siswa</span>
            </a>
         </li>

         <li>
            <a href="{{ route('guru.index') }}" class="flex items-center p-4 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <i class="fa fa-chalkboard-teacher w-5 h-5 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white"></i>
               <span class="ms-3">Data Guru</span>
            </a>
         </li>
         @endif

         <li>
            <a href="#" class="flex items-center p-4 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <i class="fa fa-book-open w-5 h-5 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white"></i>
               <span class="ms-3">Kursus</span>
            </a>
         </li>
         <li>
            <a href="#" class="flex items-center p-4 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <i class="fa fa-calendar-alt w-5 h-5 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white"></i>
               <span class="ms-3">Jadwal & Absensi</span>
            </a>
         </li>
         <li>
            <a href="{{ route('gallery.index') }}" class="flex items-center p-4 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <i class="fa fa-bullhorn w-5 h-5 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white"></i>
               <span class="ms-3">Pengumuman</span>
            </a>
         </li>
         <li>
            <a href="#" class="flex items-center p-4 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <i class="fa fa-cog w-5 h-5 text-gray-500 group-hover:text-gray-900 dark:group-hover:text-white"></i>
               <span class="ms-3">Pengaturan</span>
            </a>
         </li>
         <li>
            <form action="{{ route('logout') }}" method="POST">
               @csrf
               <button type="submit" class="flex items-center p-4 text-red-600 rounded-lg hover:bg-red-100 dark:hover:bg-red-700 group w-full text-left">
                  <i class="fa fa-sign-out-alt w-5 h-5"></i>
                  <span class="ms-3">Logout</span>
               </button>
            </form>
         </li>
      </ul>
   </div>
</aside>