@extends('layouts.app')
@section('content')
@php use Illuminate\Support\Str; @endphp
<main class="w-full font-sans overflow-hidden text-gray-800 bg-white">
    
    <!-- ================= PAGE HEADER ================= -->
    <header class="relative pt-24 pb-16 lg:pt-32 lg:pb-24 border-b border-gray-100 overflow-hidden">
        <div class="w-full px-4 lg:px-8 text-center relative z-10">
            <p class="text-primary font-bold tracking-wider uppercase mb-4 text-sm md:text-base">Media & Update</p>
            <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                West Java <span class="text-primary">Corner</span>
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Berita terkini, highlight terbaik, dan video pendek pilihan seputar bola tangan Jawa Barat.
            </p>
        </div>
        <!-- Decorative background element -->
        <div class="absolute inset-0 bg-primary/5 rounded-b-[4rem] transform -scale-y-100 -z-10"></div>
    </header>

    <!-- ================= PODCAST TERBARU ================= -->
    <section class="py-20 bg-gray-50" id="podcastSection">
        <div class="w-full px-4 lg:px-8">
            <header class="mb-12 text-center lg:text-left">
                <h2 class="font-heading text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">Podcast Terbaru</h2>
                <p class="text-gray-600 text-lg">Dengarkan diskusi mendalam seputar dunia bola tangan Jawa Barat.</p>
            </header>
            
            <div class="relative group" id="podcastCarousel">
                <!-- Track -->
                <div class="flex overflow-x-auto snap-x snap-mandatory hide-scrollbar gap-6 pb-8" id="podcastTrack">
                    @forelse($podcasts as $podcast)
                        <div class="snap-center shrink-0 w-[85vw] md:w-[60vw] lg:w-[45vw] xl:w-[40vw]">
                            <div class="bg-black rounded-3xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:-translate-y-2 aspect-video relative">
                                <iframe 
                                    class="absolute top-0 left-0 w-full h-full rounded-3xl"
                                    src="{{ $podcast->embed_link }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    @empty
                        <div class="w-full bg-white rounded-3xl py-20 text-center border border-dashed border-gray-300">
                            <span class="text-5xl block mb-4">🎙️</span>
                            <h3 class="font-heading text-xl font-bold text-gray-900">Belum Ada Podcast</h3>
                            <p class="text-gray-500 mt-2">Podcast terbaru akan segera hadir di sini.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Controls -->
                @if($podcasts->count() > 1)
                <button class="absolute top-[40%] -translate-y-1/2 -left-4 md:-left-6 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-800 hover:text-primary hover:scale-110 transition-all z-10 hidden md:flex" id="podcastPrev">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button class="absolute top-[40%] -translate-y-1/2 -right-4 md:-right-6 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-800 hover:text-primary hover:scale-110 transition-all z-10 hidden md:flex" id="podcastNext">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                @endif
            </div>

            <div class="mt-4 text-center">
                <a href="https://www.youtube.com/@CHANNEL_KAMU/podcasts" target="_blank" rel="noopener" class="inline-flex items-center text-primary font-bold hover:text-red-700 transition-colors">
                    Lihat semua podcast di YouTube
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- ================= BERITA & SHORTS (BENTO GRID) ================= -->
    <section class="py-20 bg-white border-t border-gray-100" id="newsVideoSection">
        <div class="w-full px-4 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                <!-- Berita Terbaru (7 Cols) -->
                <div class="lg:col-span-7 flex flex-col">
                    <header class="mb-8 text-center lg:text-left">
                        <h2 class="font-heading text-3xl font-extrabold text-gray-900 mb-2">Berita Terbaru</h2>
                        <p class="text-gray-600">Pembaruan ringkas dan formal untuk menjaga Anda tetap terinformasi.</p>
                    </header>
                    
                    <div class="flex-grow space-y-6">
                        @forelse($latestNews as $item)
                            <article class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:border-primary/30 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-[10px] font-bold uppercase tracking-wider">{{ $item->category ?? 'News' }}</span>
                                    <time class="text-xs text-gray-500 font-medium">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}
                                    </time>
                                </div>
                                <a href="{{ url('/news/'.$item->slug) }}" class="block text-xl md:text-2xl font-bold text-gray-900 leading-snug group-hover:text-primary transition-colors mb-3">
                                    {{ $item->title }}
                                </a>
                                <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                                    {{ Str::limit(strip_tags($item->content), 150) }}
                                </p>
                                <a href="{{ url('/news/'.$item->slug) }}" class="inline-flex items-center text-sm font-bold text-primary group-hover:text-red-700 transition-colors">
                                    Baca Selengkapnya
                                    <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </article>
                        @empty
                            <div class="bg-gray-50 rounded-2xl p-8 text-center border border-dashed border-gray-300">
                                <span class="text-4xl block mb-3">📰</span>
                                <p class="text-gray-500 font-medium">Belum ada berita tersedia.</p>
                            </div>
                        @endforelse
                    </div>
                    
                    <div class="mt-10 flex justify-center lg:justify-start">
                        {{ $latestNews->links() }}
                    </div>
                </div>

                <!-- Shorts / Best Parts (5 Cols) -->
                <div class="lg:col-span-5 flex flex-col">
                    <header class="mb-8 text-center lg:text-left">
                        <h2 class="font-heading text-3xl font-extrabold text-gray-900 mb-2">Best Parts</h2>
                        <p class="text-gray-600">Cuplikan singkat highlight utama.</p>
                    </header>
                    
                    <div class="bg-black rounded-[2.5rem] p-4 shadow-2xl relative flex-grow min-h-[500px] max-w-sm mx-auto lg:mx-0 lg:w-full border-[6px] border-gray-800">
                        <!-- Phone Notch Decoration -->
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-6 bg-gray-800 rounded-b-xl z-20 flex justify-center items-center">
                            <div class="w-16 h-1.5 bg-black rounded-full"></div>
                        </div>
                        
                        <!-- Scrollable Shorts Container -->
                        <div class="w-full h-full max-h-[600px] bg-gray-900 rounded-[1.8rem] overflow-y-auto snap-y snap-mandatory hide-scrollbar relative">
                            @forelse($shorts as $short)
                                <div class="w-full h-full min-h-[500px] snap-start snap-always shrink-0 relative flex items-center justify-center bg-black">
                                    <iframe 
                                        class="absolute inset-0 w-full h-full"
                                        src="{{ $short->embed_link }}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            @empty
                                <div class="w-full h-full min-h-[500px] flex flex-col items-center justify-center text-gray-400">
                                    <span class="text-5xl mb-4 block">📱</span>
                                    <p class="font-medium text-center px-4">Tidak ada Shorts tersedia.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    
                    <div class="mt-8 text-center lg:text-left">
                        <a href="https://www.youtube.com/@CHANNEL_KAMU/shorts" target="_blank" rel="noopener" class="inline-flex items-center justify-center px-8 py-4 bg-gray-100 text-gray-800 font-bold rounded-full hover:bg-gray-200 transition-colors shadow-sm">
                            Buka di YouTube
                            <svg class="w-5 h-5 ml-2 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ================= BERITA LAINNYA (GRID CARDS) ================= -->
    <section class="py-20 bg-gray-50 border-t border-gray-100" id="moreNews">
        <div class="w-full px-4 lg:px-8">
            <header class="mb-12 text-center">
                <h2 class="font-heading text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">Berita Lainnya</h2>
                <p class="text-gray-600 text-lg">Kumpulan berita pilihan terbaru.</p>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse($moreNews as $item)
                    <article class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-2">
                        <div class="aspect-video bg-gray-100 relative overflow-hidden">
                            @if(isset($item->image) && $item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-300 transition-transform duration-500 group-hover:scale-110">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-[10px] font-bold uppercase tracking-wider">{{ $item->category ?? 'News' }}</span>
                                <time class="text-xs text-gray-500 font-medium">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                </time>
                            </div>
                            <a href="{{ url('/news/'.$item->slug) }}" class="block text-lg font-bold text-gray-900 leading-snug group-hover:text-primary transition-colors mb-3 line-clamp-2">
                                {{ $item->title }}
                            </a>
                            <p class="text-sm text-gray-600 leading-relaxed line-clamp-3 mb-4 flex-grow">
                                {{ Str::limit(strip_tags($item->content), 100) }}
                            </p>
                            <a href="{{ url('/news/'.$item->slug) }}" class="inline-flex items-center text-sm font-bold text-primary group-hover:text-red-700 transition-colors mt-auto">
                                Baca Selengkapnya
                                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-dashed border-gray-300">
                        <span class="text-5xl block mb-4">📰</span>
                        <p class="text-xl font-heading font-bold text-gray-900">Tidak ada berita lainnya</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

</main>

<style>
/* Hide scrollbar for Chrome, Safari and Opera */
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}
/* Hide scrollbar for IE, Edge and Firefox */
.hide-scrollbar {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Podcast Carousel Navigation
    const track = document.getElementById('podcastTrack');
    const prevBtn = document.getElementById('podcastPrev');
    const nextBtn = document.getElementById('podcastNext');

    if (track && prevBtn && nextBtn) {
        // Calculate scroll amount based on card width
        const getScrollAmount = () => {
            const card = track.firstElementChild;
            return card ? card.offsetWidth + 24 : 300; // 24 is the gap (gap-6)
        };

        prevBtn.addEventListener('click', () => {
            track.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
        });
        
        nextBtn.addEventListener('click', () => {
            track.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
        });
    }
});
</script>
@endsection