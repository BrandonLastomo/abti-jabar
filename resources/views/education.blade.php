@extends('layouts.app')
@section('content')
@php 
    use Carbon\Carbon;
    Carbon::setLocale('id'); 
@endphp

<main class="w-full bg-white min-h-screen">
    <!-- Header Section with Dark Background -->
    <section class="w-full bg-[#1e2335] text-white py-20 relative overflow-hidden">
        <!-- Optional overlay pattern -->
        <div class="absolute inset-0 opacity-10">
            <!-- Example background image logic could go here -->
        </div>
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl md:text-5xl font-bold mb-4">Tugas & Tanggung Jawab</h1>
            <p class="text-gray-300 text-lg md:text-xl leading-relaxed">
                Panduan komprehensif mengenai peran khusus dalam pengembangan olahraga bola tangan di Jawa Barat. Memastikan standar profesionalisme dan keunggulan atletik tercapai di setiap level.
            </p>
        </div>
    </section>

    <!-- Navigation Bar for Categories -->
    <div class="w-full border-b border-gray-200 sticky top-0 bg-white z-20 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex overflow-x-auto py-4 gap-6 no-scrollbar" aria-label="Education Categories">
                @foreach($categories as $cat)
                    <a href="{{ route('education.index', ['category' => $cat]) }}" 
                       class="whitespace-nowrap text-sm font-bold uppercase tracking-wider transition-colors duration-200 
                       {{ $activeCategory === $cat ? 'text-red-600 border-b-2 border-red-600 pb-4 -mb-4' : 'text-gray-500 hover:text-gray-900' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </nav>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Left Side: Dynamic Education Content -->
            <div class="w-full lg:w-2/3">
                @if($education)
                    <!-- Top Content Box -->
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 md:p-8 mb-8">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="px-3 py-1 bg-red-100 text-red-600 text-xs font-bold rounded-full uppercase tracking-wider">
                                {{ strtoupper($education->category) }}
                            </span>
                            <span class="text-gray-400 text-sm">
                                Diperbarui: {{ Carbon::parse($education->updated_at)->translatedFormat('d M Y') }}
                            </span>
                        </div>
                        
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                            {{ $education->title }}
                        </h2>
                        
                        <div class="text-gray-600 leading-relaxed">
                            {!! nl2br(e($education->description)) !!}
                        </div>
                    </div>

                    <!-- Image Section -->
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-4 md:p-6 mb-8 text-center">
                        <div class="w-full bg-indigo-50 rounded-xl overflow-hidden relative aspect-video flex items-center justify-center mb-3">
                            @if($education->image)
                                <img src="{{ asset('storage/'.$education->image) }}" alt="{{ $education->title }}" class="w-full h-full object-cover">
                            @else
                                <!-- Placeholder Icon -->
                                <svg class="w-20 h-20 text-indigo-200" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h16v16H4V4zm2 2v12h12V6H6zm2 8l3-3 2 2 3-4 2 5H8z"/></svg>
                            @endif
                        </div>
                        <span class="text-xs text-gray-500">Gambar: {{ $education->title }}</span>
                    </div>

                    <!-- Responsibilities Section -->
                    @php $responsibilities = $education->responsibilities ?? []; @endphp
                    @if(!empty($responsibilities))
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 md:p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <h3 class="text-xl font-bold text-gray-900">Rincian Tanggung Jawab</h3>
                        </div>
                        
                        <div class="space-y-6">
                            @foreach($responsibilities as $resp)
                            <div class="flex items-start gap-4">
                                <div class="mt-1">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">{{ $resp['title'] ?? '' }}</h4>
                                    <p class="text-gray-600 text-sm leading-relaxed">{{ $resp['description'] ?? '' }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                @else
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-8 text-center text-gray-500">
                        Belum ada data untuk kategori {{ $activeCategory }}.
                    </div>
                @endif
            </div>
            
            <!-- Right Side: Sidebar -->
            <div class="w-full lg:w-1/3 space-y-8">
                
                <!-- Materi Terkait (News) -->
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Materi Terkait</h3>
                    <div class="space-y-6">
                        @foreach($relatedNews as $news)
                            @php 
                                $newsImages = json_decode($news->images, true) ?? []; 
                                $newsThumb = count($newsImages) > 0 ? asset('storage/'.$newsImages[0]) : 'https://placehold.co/400x250';
                            @endphp
                            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden group flex flex-col">
                                <div class="h-40 w-full overflow-hidden relative">
                                    <span class="absolute top-2 right-2 bg-white px-2 py-1 text-xs font-bold uppercase rounded-md z-10 shadow-sm">
                                        {{ $news->category ?? 'ARTIKEL' }}
                                    </span>
                                    <img src="{{ $newsThumb }}" alt="{{ $news->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                </div>
                                <div class="p-5 flex-1 flex flex-col">
                                    <h4 class="font-bold text-gray-900 mb-2 text-sm leading-snug">
                                        {{ $news->title }}
                                    </h4>
                                    <p class="text-xs text-gray-500 line-clamp-2 mb-4">
                                        {{ strip_tags($news->content) }}
                                    </p>
                                    <a href="{{ route('news.show', $news->slug) }}" class="mt-auto text-red-600 text-xs font-bold hover:underline flex items-center gap-1">
                                        Baca Selengkapnya
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
    </div>
</main>
@endsection
