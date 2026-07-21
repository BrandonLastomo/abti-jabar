@extends('layouts.app')
@section('content')
@php 
    use Carbon\Carbon;
    Carbon::setLocale('id'); 
@endphp

<main class="w-full bg-white min-h-screen">
    <!-- ===================== EDUCATION PAGE HEADER ===================== -->
    <section class="relative pt-24 pb-12 lg:pt-28 lg:pb-16 overflow-hidden bg-white" aria-label="Education page header">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-50 via-white to-red-50/30 opacity-80"></div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/5 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 -ml-32 -mb-32 w-96 h-96 rounded-full bg-blue-50/50 blur-3xl"></div>
        
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="mb-6 flex justify-center">
                <span class="inline-block px-4 py-1.5 rounded-full bg-white/60 backdrop-blur-md border border-gray-200 text-xs font-bold tracking-widest uppercase text-primary shadow-sm">
                    Edukasi
                </span>
            </div>
            <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6 tracking-tight drop-shadow-sm">
                Tugas & <span class="text-primary">Tanggung Jawab</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-600 leading-relaxed font-medium max-w-3xl mx-auto">
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
                    <div class="bg-white rounded-2xl p-6 md:p-8 mb-8">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="px-4 py-1.5 bg-primary/10 text-primary text-xs font-bold rounded-full uppercase tracking-wider">
                                {{ strtoupper($education->category) }}
                            </span>
                            <span class="text-gray-400 text-sm font-medium">
                                Diperbarui: {{ Carbon::parse($education->updated_at)->translatedFormat('d M Y') }}
                            </span>
                        </div>
                        
                        <h2 class="font-heading text-2xl md:text-3xl font-extrabold text-gray-900 mb-4 tracking-tight">
                            {{ $education->title }}
                        </h2>
                        
                        <div class="text-gray-600 leading-relaxed font-medium">
                            {!! nl2br(e($education->description)) !!}
                        </div>
                    </div>

                    <!-- Image Section -->
                    <div class="bg-white rounded-2xl p-4 md:p-6 mb-8 text-center">
                        <div class="w-full bg-indigo-50 rounded-xl overflow-hidden relative aspect-video flex items-center justify-center mb-3">
                            @if($education->image)
                                <img src="{{ asset('storage/'.$education->image) }}" alt="{{ $education->title }}" class="w-full h-full object-cover">
                            @else
                                <!-- Placeholder Icon -->
                                <svg class="w-20 h-20 text-indigo-200" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h16v16H4V4zm2 2v12h12V6H6zm2 8l3-3 2 2 3-4 2 5H8z"/></svg>
                            @endif
                        </div>
                        <span class="text-xs text-gray-500 font-medium">Gambar: {{ $education->title }}</span>
                    </div>

                    <!-- Responsibilities Section -->
                    @php $responsibilities = $education->responsibilities ?? []; @endphp
                    @if(!empty($responsibilities))
                    <div class="bg-white rounded-2xl p-6 md:p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <h3 class="font-heading text-xl font-extrabold text-gray-900 tracking-tight">Rincian Tanggung Jawab</h3>
                        </div>
                        
                        <div class="space-y-6">
                            @foreach($responsibilities as $resp)
                            <div class="flex items-start gap-4">
                                <div class="mt-1">
                                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">{{ $resp['title'] ?? '' }}</h4>
                                    <p class="text-gray-600 text-sm leading-relaxed font-medium">{{ $resp['description'] ?? '' }}</p>
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
