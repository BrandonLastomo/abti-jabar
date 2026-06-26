@extends('layouts.app')
@section('content')
@php 
    use Carbon\Carbon;
    Carbon::setLocale('id'); 
@endphp

<main class="w-full bg-white min-h-screen pb-16">
    <!-- Header Section -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-8 text-center">
        <!-- Category Pill -->
        <div class="inline-block px-4 py-1 bg-red-600 text-white text-xs font-bold rounded-full mb-4 uppercase tracking-wider">
            {{ $news->category ?? 'BERITA' }}
        </div>
        
        <!-- Title -->
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
            {{ $news->title }}
        </h1>
        
        <!-- Date -->
        <p class="text-gray-500 text-sm mb-6">
            {{ Carbon::parse($news->created_at)->translatedFormat('l, d F Y') }}
        </p>
        
        <!-- Social Share -->
        <div class="flex items-center justify-center gap-3 text-sm text-gray-500">
            <span>Bagikan:</span>
            <!-- Fake Share Links for UI -->
            <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 transition">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path></svg>
            </a>
            <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 transition">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path></svg>
            </a>
            <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
            </a>
        </div>
    </section>

    <!-- Carousel Section -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <div class="relative w-full rounded-2xl overflow-hidden bg-gray-100 group" style="aspect-ratio: 16/9;">
            @php 
                $images = json_decode($news->images, true) ?? []; 
            @endphp
            
            @if(count($images) > 0)
                <div id="carousel-inner" class="flex transition-transform duration-500 ease-in-out h-full w-full">
                    @foreach($images as $img)
                        <div class="min-w-full h-full flex-shrink-0">
                            <img src="{{ asset('storage/'.$img) }}" alt="News Image" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>

                @if(count($images) > 1)
                <!-- Controls -->
                <button id="prevBtn" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 rounded-full flex items-center justify-center text-gray-800 shadow-md hover:bg-white transition opacity-0 group-hover:opacity-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button id="nextBtn" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 rounded-full flex items-center justify-center text-gray-800 shadow-md hover:bg-white transition opacity-0 group-hover:opacity-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
                @endif
            @else
                <!-- Placeholder -->
                <div class="w-full h-full flex items-center justify-center">
                    <span class="text-gray-400">No Image Available</span>
                </div>
            @endif
        </div>
    </section>

    <!-- Content Section -->
    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 mb-16 text-gray-700 leading-relaxed text-lg prose prose-red max-w-none">
        {!! nl2br(e($news->content)) !!}
        
        @if($news->cta_text && $news->youtube_url)
            <div class="mt-8 text-center border-l-4 border-red-600 pl-4 py-2 bg-gray-50 italic text-gray-800">
                "{{ $news->cta_text }}" - <a href="{{ $news->youtube_url }}" target="_blank" class="text-red-600 hover:underline font-bold">Tonton di YouTube</a>
            </div>
        @endif
        
        <div class="mt-8 flex flex-wrap gap-2">
            <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">#{{ str_replace(' ', '', $news->category) }}</span>
            <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">#ABTIJabar</span>
        </div>
    </section>

    <!-- Other News Section -->
    <div class="w-full h-px bg-gray-100 mb-12"></div>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-xl font-bold text-gray-900 uppercase">Berita Lainnya</h3>
            <a href="#" class="text-red-600 text-sm font-bold hover:underline flex items-center gap-1 uppercase">
                Lihat Berita Lainnya
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($otherNews as $item)
                @php 
                    $itemImages = json_decode($item->images, true) ?? []; 
                    $itemThumb = count($itemImages) > 0 ? asset('storage/'.$itemImages[0]) : 'https://via.placeholder.com/400x250';
                @endphp
                <a href="{{ route('news.show', $item) }}" class="group bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col h-full">
                    <div class="w-full h-48 overflow-hidden bg-gray-100 relative">
                        <img src="{{ $itemThumb }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center gap-2 mb-3 text-xs">
                            <span class="font-bold text-red-600 uppercase">{{ $item->category ?? 'BERITA' }}</span>
                            <span class="text-gray-300">•</span>
                            <span class="text-gray-500 uppercase">{{ Carbon::parse($item->created_at)->translatedFormat('l, d F Y') }}</span>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 group-hover:text-red-600 transition line-clamp-3">
                            {{ $item->title }}
                        </h4>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
</main>

@if(isset($images) && count($images) > 1)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inner = document.getElementById('carousel-inner');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentIndex = 0;
        const total = {{ count($images) }};
        
        function updateCarousel() {
            inner.style.transform = `translateX(-${currentIndex * 100}%)`;
        }
        
        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % total;
            updateCarousel();
        });
        
        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + total) % total;
            updateCarousel();
        });
    });
</script>
@endif

@endsection
