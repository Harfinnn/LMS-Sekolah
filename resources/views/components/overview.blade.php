<div class="flex flex-col xl:flex-row gap-6 w-full max-w-7xl mx-auto p-4">

    <section class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full xl:w-2/3">

        <article class="group flex items-center p-6 gap-5 bg-slate-900 border border-slate-800 rounded-3xl hover:border-green-500/30 transition-all duration-300">
            <div class="flex items-center justify-center w-16 h-16 rounded-2xl bg-green-500/10 group-hover:bg-green-500/20 transition-colors">
                <img src="/icons/profile-2user-green.svg" class="w-8 h-8 opacity-90" alt="Students" />
            </div>
            <div>
                <p class="text-4xl font-bold text-white tracking-tight group-hover:text-green-400 transition-colors">120</p>
                <p class="text-slate-400 text-sm font-medium mt-1">Total Students</p>
            </div>
        </article>

        <article class="group flex items-center p-6 gap-5 bg-slate-900 border border-slate-800 rounded-3xl hover:border-green-500/30 transition-all duration-300">
            <div class="flex items-center justify-center w-16 h-16 rounded-2xl bg-green-500/10 group-hover:bg-green-500/20 transition-colors">
                <img src="/icons/note-favorite-green.svg" class="w-8 h-8 opacity-90" alt="Courses" />
            </div>
            <div>
                <p class="text-4xl font-bold text-white tracking-tight group-hover:text-green-400 transition-colors">8</p>
                <p class="text-slate-400 text-sm font-medium mt-1">Total Courses</p>
            </div>
        </article>

        <article class="group flex items-center p-6 gap-5 bg-slate-900 border border-slate-800 rounded-3xl hover:border-green-500/30 transition-all duration-300">
            <div class="flex items-center justify-center w-16 h-16 rounded-2xl bg-green-500/10 group-hover:bg-green-500/20 transition-colors">
                <img src="/icons/video-play-green.svg" class="w-8 h-8 opacity-90" alt="Video" />
            </div>
            <div>
                <p class="text-4xl font-bold text-white tracking-tight group-hover:text-green-400 transition-colors">34</p>
                <p class="text-slate-400 text-sm font-medium mt-1">Video Content</p>
            </div>
        </article>

        <article class="group flex items-center p-6 gap-5 bg-slate-900 border border-slate-800 rounded-3xl hover:border-green-500/30 transition-all duration-300">
            <div class="flex items-center justify-center w-16 h-16 rounded-2xl bg-green-500/10 group-hover:bg-green-500/20 transition-colors">
                <img src="/icons/note-green.svg" class="w-8 h-8 opacity-90" alt="Text" />
            </div>
            <div>
                <p class="text-4xl font-bold text-white tracking-tight group-hover:text-green-400 transition-colors">15</p>
                <p class="text-slate-400 text-sm font-medium mt-1">Text Content</p>
            </div>
        </article>
    </section>

    <aside class="flex flex-col flex-1 bg-slate-900 border border-slate-800 rounded-3xl p-6 justify-between items-center min-h-[300px]">

        <div class="w-full flex justify-between items-center mb-4">
            <h3 class="text-white font-semibold text-lg">Performance</h3>
            <button class="text-slate-500 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="1" />
                    <circle cx="19" cy="12" r="1" />
                    <circle cx="5" cy="12" r="1" />
                </svg>
            </button>
        </div>

        <div class="relative flex items-center justify-center w-[200px] h-[200px]">
            <div class="absolute inset-0 rounded-full bg-green-500/5 blur-xl"></div>

            <div class="absolute rounded-full w-full h-full"
                style="background: conic-gradient(#4ADE80 0% 75%, #334155 75% 100%);">
            </div>

            <div class="flex flex-col justify-center items-center w-[160px] h-[160px] rounded-full bg-slate-900 z-10 border border-slate-800">
                <span class="text-3xl font-bold text-white">75%</span>
                <span class="text-xs text-slate-400 uppercase tracking-wider font-medium mt-1">Completed</span>
            </div>
        </div>

        <div class="flex w-full justify-between gap-4 mt-6 pt-6 border-t border-slate-800">
            <div class="flex flex-col gap-1">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#4ADE80] shadow-[0_0_8px_rgba(74,222,128,0.5)]"></span>
                    <span class="text-xs text-slate-400 font-medium">Done</span>
                </div>
                <p class="text-white font-semibold pl-4.5">75%</p>
            </div>

            <div class="flex flex-col gap-1">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-slate-600"></span>
                    <span class="text-xs text-slate-400 font-medium">Pending</span>
                </div>
                <p class="text-white font-semibold pl-4.5">25%</p>
            </div>
        </div>
    </aside>
</div>