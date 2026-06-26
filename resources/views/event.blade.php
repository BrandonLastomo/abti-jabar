@extends('layouts.app')
@section('content')



<main class="page">
    <!-- ===================== EVENT PAGE HEADER (ABTI JABAR) ===================== -->
    <section class="page-header" id="eventHeader" aria-label="Event page header">
        <div class="page-header__inner">
            <h1 class="page-header__title">
                <span class="page-header__title-black">Event dan Kejuaraan</span>
                <span class="page-header__title-red">ABTI Jawa Barat</span>
            </h1>
            <p class="page-header__subtitle">
                Informasi resmi dan terkini mengenai berbagai event dan kejuaraan olahraga bola tangan di wilayah
                Jawa Barat.
            </p>
        </div>
    </section>
    <section class="events" id="events">
        <div class="events__container">
            <div class="events__tools anim-in" id="eventsTools">
                <div class="events__search">
                    <span class="events__searchIcon" aria-hidden="true"></span>
                    <input type="text" id="eventSearch" class="events__searchInput" placeholder="Search event..."
                        aria-label="Search event" />
                </div>
                <div class="events__filters" role="group" aria-label="Category filters">
                    <button class="chip is-active" type="button" data-filter="ALL">All</button>
                    <button class="chip" type="button" data-filter="INDOOR">Indoor</button>
                    <button class="chip" type="button" data-filter="BEACH">Beach</button>
                    <button class="chip" type="button" data-filter="WHEELCHAIR">Wheelchair</button>
                </div>
            </div>
            <div class="events__grid" id="ballEventsGrid">

@foreach($events as $event)
    <div class="event-card"
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
         data-cover="{{ $event->cover ? asset('storage/'.$event->cover) : '' }}"
    >

        <div class="event-card__media">
            <img src="{{ $event->cover ? asset('storage/'.$event->cover) : 'https://via.placeholder.com/600x350' }}"
                 alt="{{ $event->name }}">
        </div>

        <div class="event-card__body">
            <div class="event-card__head">
                <div class="event-card__logoWrap">
                <img class="event-card__logo"
                     src="{{ $event->logo ? asset('storage/'.$event->logo) : 'https://via.placeholder.com/80' }}"
                     alt="">
                </div>
                <div class="event-card__titleWrap">
                  <h3>{{ $event->name }}</h3>
                </div>
            </div>

            <div class="event-card__metaRow">
                <div class="event-card__loc">
                  <span class="icon icon--pin" aria-hidden="true"></span>
                  <span class="event-card__locText">{{ $event->loc }}</span>
                </div>
                <span class="pill">{{ strtoupper($event->category) }}</span>
            </div>

            <button class="btn-primary open-modal">
                Detail Event
            </button>
        </div>

    </div>
@endforeach

</div>
            <div class="events__pager anim-in" id="eventsPager" aria-label="Pagination">
                <button class="pager-btn" id="prevBtn" type="button" aria-label="Previous page">
                    <span aria-hidden="true">‹</span> Prev
                </button>
                <div class="pager-info" aria-live="polite">
                    <span id="pagerCount">0</span>
                </div>
                <button class="pager-btn" id="nextBtn" type="button" aria-label="Next page">
                    Next <span aria-hidden="true">›</span>
                </button>
            </div>
        </div>
        <div class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/40 backdrop-blur-sm transition-opacity duration-300" id="eventModal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
            <div class="absolute inset-0" data-ev-close></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-4xl mx-4 p-6 md:p-8 overflow-y-auto max-h-[90vh] transform scale-95 opacity-0 transition-all duration-300" role="document">
                <button class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 transition" type="button" data-ev-close aria-label="Close">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <div class="flex items-center gap-4 md:gap-6 mb-6">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-xl border border-red-100 flex items-center justify-center p-2 flex-shrink-0">
                        <img class="max-w-full max-h-full object-contain" id="modalLogo" alt="" />
                    </div>
                    <div>
                        <h3 class="text-xl md:text-3xl font-bold text-gray-900 mb-2 leading-tight" id="modalTitle">Nama Event</h3>
                        <div id="modalBadges"></div>
                    </div>
                </div>
                
                <hr class="border-gray-100 my-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8" id="modalBody">
                    <!-- populated by js -->
                </div>
                
                <div class="mt-8 flex flex-wrap gap-4" id="modalFooter">
                    <!-- populated by js -->
                </div>
            </div>
        </div>
    </section>
</main>
<script>
document.querySelectorAll('.open-modal').forEach(btn => {
    btn.addEventListener('click', function() {
        const card = this.closest('.event-card');

        document.getElementById('modalTitle').innerText = card.dataset.name;
        document.getElementById('modalLogo').src = card.dataset.logo;

        document.getElementById('modalBadges').innerHTML =
            `<span class="inline-block px-3 py-1 bg-red-50 text-red-600 text-xs font-bold rounded-full uppercase tracking-wide">${card.dataset.category}</span>`;

        const makeItem = (iconPath, label, value, isLink = false) => {
            if (!value || value === '0' || value === '-') return '';
            const valHtml = isLink 
                ? `<a href="${value}" target="_blank" class="text-red-600 hover:underline">${value}</a>`
                : `<div class="text-gray-900 font-medium">${value}</div>`;
                
            return `
            <div class="flex items-start gap-3">
                <div class="text-gray-400 mt-0.5 w-5 h-5 flex-shrink-0">
                    <svg fill="currentColor" viewBox="0 0 24 24" class="w-full h-full"><path d="${iconPath}"/></svg>
                </div>
                <div>
                    <div class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">${label}</div>
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
        
        // Mock data for things not in dataset to match the design.
        const mockSocialMedia = "@abtijabar_official";
        const mockTechDelegates = "8 Technical Delegates";

        document.getElementById('modalBody').innerHTML = `
            ${makeItem(locIcon, 'LOKASI', card.dataset.location)}
            ${makeItem(athletesIcon, 'JUMLAH ATLET', card.dataset.athletes ? card.dataset.athletes + ' Atlet Terdaftar' : '')}
            ${makeItem(coachesIcon, 'JUMLAH PELATIH', card.dataset.coaches ? card.dataset.coaches + ' Pelatih Berlisensi' : '')}
            ${makeItem(teamIcon, 'JUMLAH TIM', card.dataset.teams ? card.dataset.teams + ' Tim Kabupaten/Kota' : '')}
            ${makeItem(mgmtIcon, 'TIM MANAJEMEN', card.dataset.management ? card.dataset.management + ' Orang Staff' : '')}
            ${makeItem(watchIcon, 'PENONTON OFFLINE PER HARI', card.dataset.audience ? card.dataset.audience + ' Orang (Rata-rata)' : '')}
            ${makeItem(webIcon, 'WEBSITE', card.dataset.website, true)}
            ${makeItem(adminIcon, 'ADMINISTRATOR', card.dataset.admin)}
            ${makeItem(shareIcon, 'SOCIAL MEDIA', mockSocialMedia, true)}
            ${makeItem(coachesIcon, 'OFFICIALS TECHNICAL DELEGATES', mockTechDelegates)}
        `;

        document.getElementById('modalFooter').innerHTML = card.dataset.website 
            ? `<a href="${card.dataset.website}" target="_blank" class="flex items-center gap-2 px-6 py-3 bg-red-600 text-white font-bold rounded shadow-md hover:bg-red-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                Kunjungi Website
               </a>
               <a href="#" class="px-6 py-3 border border-red-200 text-red-600 font-bold rounded shadow-sm hover:bg-red-50 transition">Download Panduan</a>`
            : '';

        const modal = document.getElementById('eventModal');
        modal.classList.remove('hidden');
        // Small delay to allow display:block to apply before animating opacity/transform
        setTimeout(() => {
            const panel = modal.querySelector('.relative.bg-white');
            panel.classList.remove('scale-95', 'opacity-0');
            panel.classList.add('scale-100', 'opacity-100');
        }, 10);
    });
});

document.querySelectorAll('[data-ev-close]').forEach(el => {
    el.addEventListener('click', function(){
        const modal = document.getElementById('eventModal');
        const panel = modal.querySelector('.relative.bg-white');
        panel.classList.add('scale-95', 'opacity-0');
        panel.classList.remove('scale-100', 'opacity-100');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300); // match duration-300
    });
});
</script>
@endsection