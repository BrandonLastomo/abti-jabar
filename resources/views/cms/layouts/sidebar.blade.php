<aside class="side !p-0 bg-white border-r border-gray-100 flex flex-col h-screen font-heading">
    <div class="p-6 border-b border-gray-100 flex-shrink-0">
        <div class="flex items-center gap-3">
            <img src="{{ asset('img/mainlogo.avif') }}" alt="ABTI Logo" class="w-10 h-10 object-contain drop-shadow-sm">
            <div>
                <div class="font-heading font-extrabold text-gray-900 leading-tight tracking-tight">ABTI JABAR</div>
                <div class="text-xs text-gray-500 font-medium">Superadmin Portal</div>
            </div>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto p-4 space-y-1">
        
        <!-- Dashboard -->
        <a href="{{ Auth::user()->hasRole('superadmin') ? route('cms.dashboard') : route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('cms.dashboard') || request()->routeIs('admin.dashboard') ? 'bg-primary text-white font-bold shadow-[0_4px_12px_rgba(220,38,38,0.2)] hover:-translate-y-0.5' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>
        @role('superadmin')
        <div class="pt-5 pb-2">
            <p class="px-3 text-xs font-extrabold uppercase tracking-widest text-gray-400">Verification</p>
        </div>

        <a href="{{ route('admin.documents.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.documents.index') ? 'bg-primary text-white font-bold shadow-[0_4px_12px_rgba(220,38,38,0.2)] hover:-translate-y-0.5' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            General Documents
        </a>

        <a href="{{ route('admin.mutations.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.mutations.index') ? 'bg-primary text-white font-bold shadow-[0_4px_12px_rgba(220,38,38,0.2)] hover:-translate-y-0.5' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            Transfer / Mutations
        </a>
        @endrole

        @role('superadmin')
        <div class="pt-5 pb-2">
            <p class="px-3 text-xs font-extrabold uppercase tracking-widest text-gray-400">Public Pages</p>
        </div>

        <!-- Beranda -->
        @php $isBeranda = in_array($page ?? '', ['hero', 'kegiatan', 'sponsor']); @endphp
        <div x-data="{ open: {{ $isBeranda ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ $isBeranda ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Beranda
                </div>
                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="pl-11 pr-3 py-1.5 space-y-1">
                <a href="{{ route('hero.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-colors {{ ($page ?? '') === 'hero' ? 'text-primary font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">Hero</a>
                <a href="{{ route('kegiatan.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-colors {{ ($page ?? '') === 'kegiatan' ? 'text-primary font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">Kegiatan</a>
                <a href="{{ route('sponsor.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-colors {{ ($page ?? '') === 'sponsor' ? 'text-primary font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">Sponsor</a>
            </div>
        </div>

        <!-- Tentang Kami -->
        @php $isTentangKami = in_array($page ?? '', ['about', 'anggota', 'program-kerja']); @endphp
        <div x-data="{ open: {{ $isTentangKami ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ $isTentangKami ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Tentang Kami
                </div>
                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="pl-11 pr-3 py-1.5 space-y-1">
                <a href="{{ route('about.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-colors {{ ($page ?? '') === 'about' ? 'text-primary font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">About Info</a>
                <a href="{{ route('anggota.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-colors {{ ($page ?? '') === 'anggota' ? 'text-primary font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">Anggota</a>
                <a href="{{ route('program-kerja.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-colors {{ ($page ?? '') === 'program-kerja' ? 'text-primary font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">Program Kerja</a>
            </div>
        </div>

        <!-- West Java Corner -->
        @php $isWJC = in_array($page ?? '', ['news-content', 'west-java-videos']); @endphp
        <div x-data="{ open: {{ $isWJC ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ $isWJC ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    West Java Corner
                </div>
                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="pl-11 pr-3 py-1.5 space-y-1">
                <a href="{{ route('news-content.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-colors {{ ($page ?? '') === 'news-content' ? 'text-primary font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">News Content</a>
                <a href="{{ route('west-java-videos.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-colors {{ ($page ?? '') === 'west-java-videos' ? 'text-primary font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">Videos</a>
            </div>
        </div>

        <!-- Event & Education -->
        @php $isEventEdu = in_array($page ?? '', ['event', 'education']); @endphp
        <div x-data="{ open: {{ $isEventEdu ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ $isEventEdu ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Event & Edu
                </div>
                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="pl-11 pr-3 py-1.5 space-y-1">
                <a href="{{ route('events.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-colors {{ ($page ?? '') === 'event' ? 'text-primary font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">Event</a>
                <a href="{{ route('education.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-colors {{ ($page ?? '') === 'education' ? 'text-primary font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">Education</a>
            </div>
        </div>

        <!-- Data & Media -->
        @php $isDataMedia = in_array($page ?? '', ['profile', 'gallery', 'archive']); @endphp
        <div x-data="{ open: {{ $isDataMedia ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ $isDataMedia ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                    Data & Media
                </div>
                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="pl-11 pr-3 py-1.5 space-y-1">
                <a href="{{ route('club.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-colors {{ ($page ?? '') === 'profile' ? 'text-primary font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">Profile (Clubs)</a>
                <a href="{{ route('galleries.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-colors {{ ($page ?? '') === 'gallery' ? 'text-primary font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">Gallery</a>
                <a href="{{ route('archive.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-colors {{ ($page ?? '') === 'archive' ? 'text-primary font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">Archives</a>
            </div>
        </div>
        
        <!-- Global Components -->
        @php $isGlobal = in_array($page ?? '', ['footer']); @endphp
        <div x-data="{ open: {{ $isGlobal ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ $isGlobal ? 'text-primary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                    Components
                </div>
                <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="pl-11 pr-3 py-1.5 space-y-1">
                <a href="{{ route('footer.index') }}" class="block px-3 py-2 text-sm rounded-lg transition-colors {{ ($page ?? '') === 'footer' ? 'text-primary font-bold bg-red-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">Footer</a>
            </div>
        </div>
        @endrole

    </div>

    <!-- System Group (Bottom) -->
    <div class="p-4 border-t border-gray-100 bg-gray-50/50 space-y-1 flex-shrink-0">
        @role('superadmin')
        <div class="px-3 pb-2 pt-1">
            <p class="text-xs font-extrabold uppercase tracking-widest text-gray-400">System</p>
        </div>
        
        <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ ($page ?? '') === 'users' ? 'bg-primary text-white font-bold shadow-[0_4px_12px_rgba(220,38,38,0.2)] hover:-translate-y-0.5' : 'text-gray-600 hover:bg-white hover:shadow-sm hover:text-gray-900 font-medium' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Users Management
        </a>

        <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ ($page ?? '') === 'settings' ? 'bg-primary text-white font-bold shadow-[0_4px_12px_rgba(220,38,38,0.2)] hover:-translate-y-0.5' : 'text-gray-600 hover:bg-white hover:shadow-sm hover:text-gray-900 font-medium' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Web Config
        </a>
        @endrole

        <!-- Logout button -->
        <div class="pt-4 mt-4 border-t border-gray-200/50">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl transition-colors text-red-500 hover:bg-red-50 font-bold text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Sign Out
                </button>
            </form>
        </div>
    </div>
</aside>