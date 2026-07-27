@extends('layouts.app')
@section('content')
<main class="w-full bg-gray-50 font-sans overflow-hidden text-gray-800">

    <!-- ===================== GALLERY PAGE HEADER ===================== -->
    <section class="relative pt-24 pb-12 lg:pt-32 lg:pb-16 overflow-hidden bg-white" id="galleryHeader" aria-label="Gallery page header">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-red-50 opacity-80"></div>
        <div class="absolute top-0 right-0 -mr-32 -mt-32 w-96 h-96 rounded-full bg-primary/5 blur-3xl"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 pt-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-16 items-start">
                <div class="md:col-span-5">
                    <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight tracking-tight">
                        Galeri Kegiatan <br/><span class="text-primary">& Dokumentasi</span>
                    </h1>
                </div>
                <div class="md:col-span-7 md:pt-4">
                    <p class="text-base md:text-lg text-gray-600 leading-relaxed max-w-2xl font-medium">
                        Ikuti perjalanan ABTI Jawa Barat melalui rangkaian dokumentasi event, kompetisi, dan pembinaan atlet. Kami merekam setiap momen berharga untuk merangkai jejak langkah pahlawan olahraga bola tangan, menyatukan semangat, dan menginspirasi generasi juara berikutnya.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== MAIN GALLERY AREA ===================== -->
    <section class="relative z-20 w-full pb-24" data-ihf-gallery>
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 mt-12">
            <!-- Glassmorphism Container Wrapper -->
            <div class="bg-white/70 backdrop-blur-xl border border-white rounded-[2.5rem] md:rounded-[3rem] p-6 md:p-12 shadow-xl shadow-gray-200/50">
                
                @if ($galleries->isEmpty())
                    <div class="w-full max-w-2xl mx-auto bg-white/70 backdrop-blur-xl border border-white rounded-[2.5rem] p-16 text-center shadow-2xl shadow-gray-200/50">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Galeri</h3>
                        <p class="text-gray-500">Dokumentasi kegiatan dan event ABTI Jawa Barat akan ditampilkan di sini.</p>
                    </div>
                @else
                    
                    <header class="ihf-head"></header>
                    
                    <div class="relative w-full flex items-center group/cardbar ihf-cardbar" aria-label="Event list">
                    @if ($galleries->isNotEmpty())
                        <button class="absolute left-0 z-30 w-12 h-12 flex items-center justify-center bg-white/80 backdrop-blur-md rounded-full shadow-lg border border-gray-100 text-gray-800 hover:bg-white hover:text-primary transition-all duration-300 -ml-4 md:ml-4 ihf-navbtn" type="button" data-card-prev aria-label="Previous events">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                    @endif
                    
                    <div class="ihf-cardtrack w-full flex gap-6 overflow-x-auto snap-x snap-mandatory py-8 px-4 md:px-12 custom-scrollbar scroll-smooth" data-card-track>
                        @foreach($galleries as $gallery)
                            <article class="ihf-card relative flex-shrink-0 w-80 md:w-96 snap-center group cursor-pointer"
                                tabindex="0"
                                data-event-id="gallery-{{ $gallery->id }}"
                                data-event-title="{{ $gallery->title }}"
                                data-event-date="{{ $gallery->season }}"
                                data-event-cover="{{ $gallery->photos->first() ? asset('storage/'.$gallery->photos->first()->photo) : asset('images/placeholder.jpg') }}"
                                data-event-images='@json(
                                    $gallery->photos->map(function($photo){
                                        return asset("storage/".$photo->photo);
                                    })
                                )'
                            >
                                <div class="w-full aspect-[4/5] rounded-[2.5rem] overflow-hidden relative ihf-cardimg shadow-xl shadow-gray-200/50 transition-transform duration-500 group-hover:-translate-y-2 group-hover:shadow-2xl">
                                    <img
                                        src="{{ $gallery->photos->first() ? asset('storage/'.$gallery->photos->first()->photo) : asset('images/placeholder.jpg') }}"
                                        alt="{{ $gallery->title }}"
                                        loading="lazy"
                                        decoding="async"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    
                                    <!-- Overlay gradient -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/20 to-transparent opacity-80 transition-opacity duration-300 group-hover:opacity-90"></div>
                                    
                                    <!-- Metadata inside image -->
                                    <div class="absolute bottom-0 left-0 w-full p-8 text-left ihf-cardmeta">
                                        <div class="inline-block px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-white text-xs font-bold uppercase tracking-wider mb-3 border border-white/30 shadow-sm ihf-cardsub">
                                            {{ $gallery->season }}
                                        </div>
                                        <h3 class="text-white font-bold text-2xl leading-tight ihf-cardtitle drop-shadow-md">
                                            {{ $gallery->title }}
                                        </h3>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    @if ($galleries->isNotEmpty())
                        <button class="absolute right-0 z-30 w-12 h-12 flex items-center justify-center bg-white/80 backdrop-blur-md rounded-full shadow-lg border border-gray-100 text-gray-800 hover:bg-white hover:text-primary transition-all duration-300 -mr-4 md:mr-4 ihf-navbtn" type="button" data-card-next aria-label="Next events">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    @endif
                </div>
            @endif

            </div> <!-- Closes Glassmorphism Container -->
        </div> <!-- Closes max-w container -->

        @if ($galleries->isNotEmpty())
        <!-- ===== IMMERSIVE GALLERY MODAL ===== -->
        <div class="ihfGalleryIHF fixed inset-0 z-[9999] w-screen h-screen flex flex-col bg-black/90 backdrop-blur-3xl transition-opacity duration-500 opacity-0 pointer-events-none [&:not([hidden])]:opacity-100 [&:not([hidden])]:pointer-events-auto" data-gallery hidden>
            
            <!-- Modal Header -->
            <div class="ihfGalleryIHF__head w-full flex items-center justify-between px-6 pb-6 pt-28 bg-gradient-to-b from-black/80 to-transparent flex-shrink-0">
                <div>
                    <h2 class="ihfGalleryIHF__title text-white text-2xl md:text-3xl font-heading font-extrabold drop-shadow-lg" data-gallery-title>GALERI EVENT</h2>
                    <div class="ihfGalleryIHF__meta flex items-center gap-3 mt-2 text-sm text-gray-300">
                        <span class="ihfGalleryIHF__date font-medium" data-gallery-date>—</span>
                        <span class="ihfGalleryIHF__dot w-1.5 h-1.5 rounded-full bg-primary"></span>
                        <span class="ihfGalleryIHF__pill px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-bold uppercase tracking-widest text-white">Photos</span>
                    </div>
                </div>
                <button class="ihfGalleryIHF__ghost w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 flex items-center justify-center text-white transition-colors" type="button" data-gallery-close aria-label="Close">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="ihfGalleryIHF__divider hidden"></div>

            <!-- Modal Viewer -->
            <div class="ihfGalleryIHF__viewer flex-1 min-h-0 flex flex-col overflow-hidden relative">
                
                <!-- Main Image -->
                <div class="ihfGalleryIHF__main flex-1 min-h-0 relative flex items-center justify-center p-4 md:p-12">
                    <figure class="ihfGalleryIHF__frame relative w-full h-full flex items-center justify-center" aria-live="polite">
                        <img class="ihfGalleryIHF__img max-w-full max-h-full object-contain drop-shadow-2xl rounded-xl transition-all duration-300" data-stage-img alt="" loading="lazy" decoding="async" />
                        <div class="ihfGalleryIHF__load absolute inset-0 flex items-center justify-center text-white/50 font-bold tracking-widest uppercase text-sm" data-stage-load>
                            Loading…
                        </div>
                    </figure>
                </div>
                
                <!-- Thumbnail Bar & Navigation -->
                <div class="ihfGalleryIHF__thumbbar flex-shrink-0 w-full bg-gradient-to-t from-black/80 to-transparent p-6 md:p-8 flex items-center justify-center gap-6">
                    <button class="ihfGalleryIHF__panel ihfGalleryIHF__panel--prev w-12 h-12 flex-shrink-0 rounded-full bg-white/10 hover:bg-white text-white hover:text-black backdrop-blur-md border border-white/20 flex items-center justify-center transition-all duration-300" type="button" data-stage-prev aria-label="Previous photo">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    
                    <div class="ihfGalleryIHF__thumbtrack flex gap-3 overflow-x-auto px-4 py-2 custom-scrollbar snap-x" data-thumbs>
                        <!-- JS injects thumbs here, we will style them via CSS overrides -->
                    </div>
                    
                    <button class="ihfGalleryIHF__panel ihfGalleryIHF__panel--next w-12 h-12 flex-shrink-0 rounded-full bg-white/10 hover:bg-white text-white hover:text-black backdrop-blur-md border border-white/20 flex items-center justify-center transition-all duration-300" type="button" data-stage-next aria-label="Next photo">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>

            </div>
        </div>
        @endif
    </section>
</main>

<style>
/* 
========================================================================
CSS OVERRIDES FOR IHF GALLERY JS
These styles ensure that dynamically injected elements by script.js 
match the new premium Glassmorphism aesthetic perfectly!
========================================================================
*/
.custom-scrollbar::-webkit-scrollbar { height: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.4); }
.ihf-cardtrack::-webkit-scrollbar { display: none; }

/* The JS thumbs inside the modal */
.ihf-thumb {
    width: 80px;
    height: 80px;
    border-radius: 1rem;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid transparent;
    opacity: 0.5;
    transition: all 0.3s ease;
    flex-shrink: 0;
    scroll-snap-align: center;
}
.ihf-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.ihf-thumb:hover {
    opacity: 0.8;
    transform: translateY(-2px);
}
.ihf-thumb.is-active {
    opacity: 1;
    border-color: #ef4444; /* Primary red glow */
    box-shadow: 0 0 20px rgba(239, 68, 68, 0.4);
    transform: scale(1.05);
}

/* Ensure focus states on gallery cards don't create ugly outlines */
.ihf-card:focus { outline: none; }
</style>
@endsection