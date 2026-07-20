@extends('layouts.app')
@section('content')

<main class="w-full bg-gray-50 font-sans overflow-hidden text-gray-800">

    <!-- ===================== EVENT PAGE HEADER ===================== -->
    <section class="relative pt-24 pb-16 lg:pt-32 lg:pb-24 overflow-hidden" id="eventHeader" aria-label="Event page header">
        <div class="absolute inset-0 bg-gradient-to-br from-red-50 via-white to-blue-50 opacity-80"></div>
        <!-- decorative blob -->
        <div class="absolute top-0 right-0 -mr-32 -mt-32 w-96 h-96 rounded-full bg-primary/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-32 -mb-32 w-80 h-80 rounded-full bg-blue-500/10 blur-3xl"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 text-center flex flex-col items-center">
            <div class="inline-block px-5 py-2 mb-6 rounded-full bg-white/50 backdrop-blur-md border border-gray-200 text-sm font-semibold tracking-widest uppercase shadow-sm text-primary">
                ABTI Jawa Barat
            </div>
            <h1 class="font-heading text-4xl md:text-6xl lg:text-7xl font-extrabold text-gray-900 leading-tight mb-6 tracking-tight drop-shadow-sm">
                Event dan <br class="md:hidden"/> Kejuaraan
            </h1>
            <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Informasi resmi dan terkini mengenai berbagai event dan kejuaraan olahraga bola tangan di wilayah Jawa Barat.
            </p>
        </div>
    </section>

    <!-- ===================== EVENTS SECTION ===================== -->
    <section class="relative z-20 max-w-7xl mx-auto px-6 lg:px-8 pb-24 -mt-10" id="events">
        
        <!-- Filters & Search -->
        <div class="bg-white/70 backdrop-blur-xl border border-white rounded-[2rem] p-6 shadow-xl shadow-gray-200/50 mb-12 flex flex-col md:flex-row justify-between items-center gap-6" id="eventsTools">
            
            <div class="relative w-full md:w-96">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" id="eventSearch" class="w-full pl-12 pr-4 py-3 rounded-full border border-gray-200 bg-white shadow-sm focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none text-gray-700" placeholder="Search event..." aria-label="Search event" />
            </div>
            
            <div class="flex flex-wrap justify-center gap-3" role="group" aria-label="Category filters">
                <!-- Using [&.is-active] to style the active state dynamically set by script.js -->
                <button class="chip px-6 py-2.5 rounded-full font-bold text-sm transition-all duration-300 shadow-sm border border-transparent bg-white text-gray-600 hover:bg-gray-50 [&.is-active]:bg-primary [&.is-active]:text-white [&.is-active]:shadow-md is-active" type="button" data-filter="ALL">All</button>
                <button class="chip px-6 py-2.5 rounded-full font-bold text-sm transition-all duration-300 shadow-sm border border-transparent bg-white text-gray-600 hover:bg-gray-50 [&.is-active]:bg-primary [&.is-active]:text-white [&.is-active]:shadow-md" type="button" data-filter="INDOOR">Indoor</button>
                <button class="chip px-6 py-2.5 rounded-full font-bold text-sm transition-all duration-300 shadow-sm border border-transparent bg-white text-gray-600 hover:bg-gray-50 [&.is-active]:bg-primary [&.is-active]:text-white [&.is-active]:shadow-md" type="button" data-filter="BEACH">Beach</button>
                <button class="chip px-6 py-2.5 rounded-full font-bold text-sm transition-all duration-300 shadow-sm border border-transparent bg-white text-gray-600 hover:bg-gray-50 [&.is-active]:bg-primary [&.is-active]:text-white [&.is-active]:shadow-md" type="button" data-filter="WHEELCHAIR">Wheelchair</button>
            </div>
            
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="ballEventsGrid">
            @foreach($events as $event)
                <div class="event-card group bg-white rounded-[2rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:-translate-y-2 flex flex-col"
                     data-id="{{ $event->id }}"
                     data-name="{{ $event->name }}"
                     data-category="{{ strtoupper($event->category) }}"
                     data-location="{{ $event->loc }}"
                     data-athletes="{{ $event->athletes }}"
                     data-coaches="{{ $event->coaches }}"
                     data-teams="{{ $event->teams }}"
                     data-management="{{ $event->management }}"
                     data-audience="{{ $event->audience_offline }}"
                     data-website="{{ $event->website }}"
                     data-admin="{{ $event->administrator }}"
                     data-logo="{{ $event->logo ? asset('storage/'.$event->logo) : '' }}"
                     data-cover="{{ $event->cover ? asset('storage/'.$event->cover) : '' }}">

                    <!-- Card Media -->
                    <div class="relative w-full aspect-[4/3] overflow-hidden">
                        <img src="{{ $event->cover ? asset('storage/'.$event->cover) : 'https://placehold.co/600x450' }}"
                             alt="{{ $event->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-300"></div>
                        
                        <!-- Overlay Category -->
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md border border-white/30 text-white text-xs font-bold rounded-full uppercase tracking-wider shadow-lg">
                                {{ strtoupper($event->category) }}
                            </span>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 md:p-8 flex flex-col flex-grow relative bg-white">
                        <!-- Floating Logo -->
                        <div class="absolute -top-12 right-6 w-20 h-20 bg-white rounded-2xl p-2 shadow-xl border border-gray-100 group-hover:-translate-y-2 transition-transform duration-500">
                            <img class="w-full h-full object-contain"
                                 src="{{ $event->logo ? asset('storage/'.$event->logo) : 'https://placehold.co/80' }}"
                                 alt="">
                        </div>

                        <div class="pr-20 mb-4">
                            <h3 class="text-2xl font-heading font-bold text-gray-900 leading-tight group-hover:text-primary transition-colors line-clamp-2">
                                {{ $event->name }}
                            </h3>
                        </div>

                        <div class="flex items-center gap-2 text-gray-500 mb-8 mt-auto">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-sm font-medium line-clamp-1">{{ $event->loc }}</span>
                        </div>

                        <button class="open-modal w-full py-3 bg-gray-50 text-gray-900 font-bold rounded-xl hover:bg-primary hover:text-white transition-colors duration-300 shadow-sm text-sm tracking-wider uppercase">
                            Detail Event
                        </button>
                    </div>

                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-16 flex justify-center items-center gap-6" id="eventsPager" aria-label="Pagination">
            <button class="pager-btn px-6 py-3 rounded-full bg-white border border-gray-200 text-gray-700 font-bold hover:bg-gray-50 hover:text-primary transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed" id="prevBtn" type="button" aria-label="Previous page">
                <span aria-hidden="true" class="mr-2">&larr;</span> Prev
            </button>
            <div class="pager-info text-gray-500 font-medium" aria-live="polite">
                <span id="pagerCount">0</span>
            </div>
            <button class="pager-btn px-6 py-3 rounded-full bg-white border border-gray-200 text-gray-700 font-bold hover:bg-gray-50 hover:text-primary transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed" id="nextBtn" type="button" aria-label="Next page">
                Next <span aria-hidden="true" class="ml-2">&rarr;</span>
            </button>
        </div>

    </section>

    <!-- ===================== EVENT MODAL ===================== -->
    <div class="fixed inset-0 z-[100] flex items-center justify-center hidden bg-black/40 backdrop-blur-sm transition-opacity duration-300 opacity-0" id="eventModal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <!-- Overlay background -->
        <div class="absolute inset-0" data-ev-close></div>
        
        <!-- Modal Panel -->
        <div class="relative bg-white/90 backdrop-blur-xl rounded-[2rem] shadow-2xl w-full max-w-4xl mx-4 p-8 md:p-10 overflow-y-auto max-h-[90vh] transform scale-95 transition-all duration-300 border border-white/50" role="document">
            
            <button class="absolute top-6 right-6 w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center text-gray-500 hover:text-gray-800 transition-colors" type="button" data-ev-close aria-label="Close">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="flex flex-col md:flex-row md:items-center gap-6 mb-8">
                <div class="w-24 h-24 rounded-2xl bg-white shadow-lg border border-gray-100 flex items-center justify-center p-3 flex-shrink-0">
                    <img class="max-w-full max-h-full object-contain" id="modalLogo" alt="" />
                </div>
                <div>
                    <div id="modalBadges" class="mb-3"></div>
                    <h3 class="text-3xl md:text-4xl font-heading font-extrabold text-gray-900 leading-tight" id="modalTitle">Nama Event</h3>
                </div>
            </div>
            
            <hr class="border-gray-200/50 my-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12" id="modalBody">
                <!-- populated by js -->
            </div>
            
            <div class="mt-10 pt-8 border-t border-gray-200/50 flex flex-wrap gap-4" id="modalFooter">
                <!-- populated by js -->
            </div>
        </div>
    </div>
</main>

<style>
/* Make sure the transition classes work for the modal */
#eventModal:not(.hidden) {
    display: flex;
}
</style>

<script>
document.querySelectorAll('.open-modal').forEach(btn => {
    btn.addEventListener('click', function() {
        const card = this.closest('.event-card');

        document.getElementById('modalTitle').innerText = card.dataset.name;
        document.getElementById('modalLogo').src = card.dataset.logo;

        document.getElementById('modalBadges').innerHTML =
            `<span class="inline-block px-4 py-1.5 bg-primary/10 text-primary text-xs font-bold rounded-full uppercase tracking-wider border border-primary/20">${card.dataset.category}</span>`;

        const makeItem = (iconPath, label, value, isLink = false) => {
            if (!value || value === '0' || value === '-') return '';
            const valHtml = isLink 
                ? `<a href="${value}" target="_blank" class="text-primary hover:text-danger font-bold hover:underline transition-colors">${value}</a>`
                : `<div class="text-gray-900 font-bold text-lg">${value}</div>`;
                
            return `
            <div class="flex items-start gap-4 p-4 rounded-2xl bg-gray-50/50 border border-gray-100 hover:bg-white hover:shadow-md transition-all duration-300">
                <div class="text-primary mt-1 w-6 h-6 flex-shrink-0 bg-primary/10 rounded-full p-1">
                    <svg fill="currentColor" viewBox="0 0 24 24" class="w-full h-full"><path d="${iconPath}"/></svg>
                </div>
                <div>
                    <div class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">${label}</div>
                    ${valHtml}
                </div>
            </div>
            `;
        };

        const locIcon = "M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z";
        const athletesIcon = "M13.5 5.5c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zM9.8 8.9L7 23h2.1l1.8-8 2.1 2v6h2v-7.5l-2.1-2 .6-3C14.8 12 16.8 13 19 13v-2c-1.9 0-3.5-1-4.3-2.4l-1-1.6c-.4-.6-1-1-1.7-1-.3 0-.5.1-.8.1L6 8.3V13h2V9.6l1.8-.7";
        const coachesIcon = "M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z";
        const teamIcon = "M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z";
        const mgmtIcon = "M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z";
        const watchIcon = "M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z";
        const webIcon = "M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm6.93 6h-2.95c-.32-1.25-.78-2.45-1.38-3.56 1.84.63 3.37 1.91 4.33 3.56zM12 4.04c.83 1.2 1.48 2.53 1.91 3.96h-3.82c.43-1.43 1.08-2.76 1.91-3.96zM4.26 14C4.1 13.36 4 12.69 4 12s.1-1.36.26-2h3.38c-.08.66-.14 1.32-.14 2 0 .68.06 1.34.14 2H4.26zm.82 2h2.95c.32 1.25.78 2.45 1.38 3.56-1.84-.63-3.37-1.9-4.33-3.56zm2.95-8H5.08c.96-1.66 2.49-2.93 4.33-3.56C8.81 5.55 8.35 6.75 8.03 8zM12 19.96c-.83-1.2-1.48-2.53-1.91-3.96h3.82c-.43 1.43-1.08 2.76-1.91 3.96zM14.34 14H9.66c-.09-.66-.16-1.32-.16-2 0-.68.07-1.35.16-2h4.68c.09.65.16 1.32.16 2 0 .68-.07 1.34-.16 2zm.25 5.56c.6-1.11 1.06-2.31 1.38-3.56h2.95c-.96 1.65-2.49 2.93-4.33 3.56zM16.36 14c.08-.66.14-1.32.14-2 0-.68-.06-1.34-.14-2h3.38c.16.64.26 1.31.26 2s-.1 1.36-.26 2h-3.38z";
        const adminIcon = "M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z";
        const shareIcon = "M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z";
        
        const mockSocialMedia = "@abtijabar_official";
        const mockTechDelegates = "8 Technical Delegates";

        document.getElementById('modalBody').innerHTML = `
            ${makeItem(locIcon, 'LOKASI', card.dataset.location)}
            ${makeItem(athletesIcon, 'JUMLAH ATLET', card.dataset.athletes ? card.dataset.athletes + ' Atlet Terdaftar' : '')}
            ${makeItem(coachesIcon, 'JUMLAH PELATIH', card.dataset.coaches ? card.dataset.coaches + ' Pelatih Berlisensi' : '')}
            ${makeItem(teamIcon, 'JUMLAH TIM', card.dataset.teams ? card.dataset.teams + ' Tim Kabupaten/Kota' : '')}
            ${makeItem(mgmtIcon, 'TIM MANAJEMEN', card.dataset.management ? card.dataset.management + ' Orang Staff' : '')}
            ${makeItem(watchIcon, 'PENONTON OFFLINE', card.dataset.audience ? card.dataset.audience + ' Orang (Rata-rata)' : '')}
            ${makeItem(webIcon, 'WEBSITE', card.dataset.website, true)}
            ${makeItem(adminIcon, 'ADMINISTRATOR', card.dataset.admin)}
            ${makeItem(shareIcon, 'SOCIAL MEDIA', mockSocialMedia, true)}
            ${makeItem(coachesIcon, 'OFFICIALS', mockTechDelegates)}
        `;

        document.getElementById('modalFooter').innerHTML = card.dataset.website 
            ? `<a href="${card.dataset.website}" target="_blank" class="flex items-center gap-2 px-8 py-4 bg-primary text-white font-bold rounded-full shadow-lg hover:bg-danger hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                Kunjungi Website
               </a>`
            : '';

        const modal = document.getElementById('eventModal');
        modal.classList.remove('hidden');
        
        // requestAnimationFrame for smoother transition triggers
        requestAnimationFrame(() => {
            modal.classList.remove('opacity-0');
            const panel = modal.querySelector('.relative');
            panel.classList.remove('scale-95', 'opacity-0');
            panel.classList.add('scale-100', 'opacity-100');
        });
    });
});

document.querySelectorAll('[data-ev-close]').forEach(el => {
    el.addEventListener('click', function(){
        const modal = document.getElementById('eventModal');
        const panel = modal.querySelector('.relative');
        
        modal.classList.add('opacity-0');
        panel.classList.add('scale-95', 'opacity-0');
        panel.classList.remove('scale-100', 'opacity-100');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300); // match duration-300
    });
});
</script>
@endsection