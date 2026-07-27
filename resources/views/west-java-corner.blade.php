@extends('layouts.app')
@section('content')
@php use Illuminate\Support\Str; @endphp
<main class="w-full font-sans overflow-hidden text-black bg-[#f4f4f4]">
    
    <!-- ================= HERO SECTION (HAUS STYLE) ================= -->
    <section class="min-h-[calc(100vh-80px)] flex flex-col justify-center bg-[#E5E7EB] px-6 lg:px-12 pt-20 pb-12 relative border-b-4 border-black">
        <div class="max-w-screen-2xl mx-auto w-full flex flex-col h-full justify-center">
            <h1 class="font-heading font-black uppercase tracking-tighter text-black leading-[0.85] mb-8" style="font-size: min(15vw, 22vh);">
                <span class="block hover:text-red-600 transition-colors duration-300">West</span>
                <span class="block hover:text-red-600 transition-colors duration-300 ml-[10vw]">Java</span>
                <span class="block hover:text-red-600 transition-colors duration-300">Corner</span>
            </h1>
            <div class="flex justify-end w-full">
                <p class="text-lg md:text-2xl font-bold uppercase max-w-xl text-right border-l-4 border-black pl-6 py-2">
                    High-impact digital updates &<br>high-output local news
                </p>
            </div>
        </div>
    </section>

    <!-- ================= PODCAST (HORIZONTAL CAROUSEL) ================= -->
    <section class="py-24 bg-white border-b-4 border-black" id="podcastSection">
        <div class="px-6 lg:px-12 mb-16 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            <h2 class="text-5xl md:text-8xl font-heading font-black uppercase tracking-tighter leading-none">
                Featured<br>Podcasts
            </h2>
            <a href="https://www.youtube.com/@CHANNEL_KAMU/podcasts" target="_blank" rel="noopener" class="text-2xl font-black uppercase tracking-tight underline hover:text-red-600 transition-colors">
                View All on YouTube
            </a>
        </div>
        
        <div class="flex overflow-x-auto snap-x snap-mandatory hide-scrollbar gap-8 px-6 lg:px-12 pb-12" style="scroll-padding-left: max(1.5rem, 5vw);">
            @forelse($podcasts as $podcast)
                <div class="snap-start shrink-0 w-[85vw] md:w-[60vw] lg:w-[45vw] aspect-[16/9] bg-[#E5E7EB] relative group border-4 border-black transition-transform duration-500 hover:-translate-y-2 hover:shadow-[16px_16px_0px_0px_#dc2626]">
                    <iframe class="w-full h-full" src="{{ $podcast->embed_link }}" frameborder="0" allowfullscreen></iframe>
                </div>
            @empty
                <div class="w-full py-32 text-center border-4 border-dashed border-black bg-[#E5E7EB]">
                    <h3 class="text-4xl font-black uppercase tracking-tighter">No Podcasts Available</h3>
                </div>
            @endforelse
        </div>
    </section>

    <!-- ================= BERITA & SHORTS (BENTO BRUTALISM) ================= -->
    <section class="py-24 bg-white" id="newsVideoSection">
        <div class="px-6 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 border-4 border-black bg-black">
                
                <!-- Shorts Sidebar -->
                <div class="lg:col-span-4 border-b-4 lg:border-b-0 lg:border-r-4 border-black flex flex-col bg-[#f4f4f4]">
                    <div class="p-8 border-b-4 border-black bg-white">
                        <h2 class="text-4xl md:text-5xl font-heading font-black uppercase tracking-tighter leading-none">Best Parts</h2>
                    </div>
                    <div class="flex-grow overflow-y-auto h-[600px] lg:h-[75vh] hide-scrollbar snap-y snap-mandatory bg-[#111] p-6 space-y-10">
                        @forelse($shorts as $short)
                            <div class="w-full snap-center shrink-0 flex justify-center items-center">
                                <div class="relative w-full max-w-[260px] aspect-[9/16] bg-black rounded-[2rem] shadow-2xl overflow-hidden border-[8px] border-gray-900 group">
                                    <iframe class="absolute inset-0 w-full h-full transition-transform duration-700 group-hover:scale-105" src="{{ $short->embed_link }}" frameborder="0" allowfullscreen></iframe>
                                    <div class="absolute inset-0 ring-1 ring-inset ring-white/10 rounded-3xl pointer-events-none"></div>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center text-white h-full flex items-center justify-center">
                                <h3 class="text-2xl font-black uppercase tracking-tighter text-gray-500">No Shorts</h3>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Berita Terbaru -->
                <div class="lg:col-span-8 flex flex-col bg-white">
                    <div class="p-8 border-b-4 border-black bg-red-600 text-white">
                        <h2 class="text-4xl md:text-6xl font-heading font-black uppercase tracking-tighter leading-none">Berita Terbaru</h2>
                    </div>
                    
                    <div class="flex flex-col">
                        @forelse($latestNews as $item)
                            <article class="p-8 md:p-12 border-b-4 border-black hover:bg-black hover:text-white transition-colors duration-300 group flex flex-col md:flex-row gap-8 md:items-start">
                                <div class="md:w-1/4 shrink-0">
                                    <span class="font-mono text-lg font-bold uppercase tracking-widest">{{ \Carbon\Carbon::parse($item->created_at)->format('d.m.y') }}</span>
                                    <div class="mt-4 text-sm font-bold border-2 border-current px-3 py-1 inline-block uppercase tracking-widest">{{ $item->category ?? 'NEWS' }}</div>
                                </div>
                                <div class="md:w-3/4">
                                    <h3 class="text-3xl md:text-5xl font-heading font-black uppercase tracking-tighter leading-none mb-6 group-hover:text-red-500 transition-colors">
                                        <a href="{{ url('/news/'.$item->slug) }}" class="block">{{ $item->title }}</a>
                                    </h3>
                                    <p class="text-xl leading-relaxed line-clamp-3 opacity-80 group-hover:opacity-100 font-medium">
                                        {{ Str::limit(strip_tags($item->content), 180) }}
                                    </p>
                                    <div class="mt-8">
                                        <a href="{{ url('/news/'.$item->slug) }}" class="inline-flex items-center text-lg font-black uppercase tracking-tighter hover:text-red-500 transition-colors group-hover:underline">
                                            Read More
                                            <svg class="w-6 h-6 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="p-16 text-center">
                                <h3 class="text-4xl font-black uppercase tracking-tighter">Belum ada berita</h3>
                            </div>
                        @endforelse
                    </div>
                    
                    <div class="p-8 bg-[#E5E7EB] font-bold text-lg border-b-4 border-black">
                        {{ $latestNews->links() }}
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ================= BERITA LAINNYA ================= -->
    <section class="py-32 bg-white border-t-4 border-black" id="moreNews">
        <div class="px-6 lg:px-12 mb-20 flex flex-col items-center">
            <h2 class="text-6xl md:text-[8rem] font-heading font-black uppercase tracking-tighter leading-none text-center">
                More<br>News
            </h2>
            <div class="w-full max-w-4xl h-4 bg-black mt-12"></div>
        </div>

        <div class="px-6 lg:px-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-24">
            @forelse($moreNews as $item)
                <article class="group cursor-pointer flex flex-col h-full">
                    <div class="aspect-[4/3] bg-black border-4 border-black overflow-hidden mb-8 relative transition-transform duration-500 group-hover:-translate-y-4 group-hover:shadow-[16px_16px_0px_0px_#dc2626]">
                        @if(isset($item->image) && $item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover filter grayscale group-hover:grayscale-0 transition-all duration-700 transform group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100 text-black">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex justify-between items-start mb-4 border-t-4 border-black pt-4">
                        <span class="font-mono text-sm font-bold uppercase tracking-widest">{{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</span>
                    </div>
                    <h3 class="text-3xl font-heading font-black uppercase tracking-tighter leading-none group-hover:text-red-600 transition-colors mb-4 flex-grow">
                        <a href="{{ url('/news/'.$item->slug) }}" class="block">{{ $item->title }}</a>
                    </h3>
                    <div class="pt-4 mt-auto">
                        <span class="inline-block px-3 py-1 bg-black text-white text-xs font-bold uppercase tracking-widest">{{ $item->category ?? 'News' }}</span>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-20 text-center border-4 border-dashed border-black bg-[#E5E7EB]">
                    <p class="text-3xl font-black uppercase tracking-tighter">Tidak ada berita lainnya</p>
                </div>
            @endforelse
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
@endsection