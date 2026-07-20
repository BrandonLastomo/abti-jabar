@extends('layouts.app')

@section('content')
@php use Illuminate\Support\Str; @endphp
<main class="w-full bg-background font-sans overflow-hidden text-gray-800">

  <!-- HERO SECTION -->
  <section id="beranda" class="relative w-full min-h-[90vh] flex items-center justify-center overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 w-full h-full">
      <picture class="w-full h-full">
        <source media="(max-width: 768px)" srcset="{{ isset($hero) && $hero->image_mobile ? asset('storage/'.$hero->image_mobile) : asset('img/sechero.png') }}">
        <img src="{{ isset($hero) && $hero->image_desktop ? asset('storage/'.$hero->image_desktop) : asset('img/mainhero.png') }}" alt="ABTI JAWA BARAT" class="w-full h-full object-cover object-center" />
      </picture>
      <!-- Gradient Overlay for Contrast -->
      <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/30"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 text-center text-on-primary flex flex-col items-center mt-16">
      @if(isset($hero) && $hero->kicker)
        <div class="inline-block px-5 py-2 mb-8 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-sm font-semibold tracking-widest uppercase shadow-lg">
          <span class="w-2 h-2 rounded-full bg-success inline-block mr-2 animate-pulse"></span>
          {{ $hero->kicker }}
        </div>
      @endif
      
      <h1 class="text-5xl md:text-7xl lg:text-8xl font-heading font-extrabold leading-[1.1] tracking-tight mb-6 drop-shadow-lg">
        @if(isset($hero) && $hero->big)
            {!! nl2br(e($hero->big)) !!}
        @else
            Train Smarter. <br/> Play Stronger. <br/> Win More.
        @endif
      </h1>
      
      @if(isset($hero) && $hero->desc)
        <p class="text-lg md:text-xl text-gray-200 mt-6 max-w-2xl leading-relaxed drop-shadow-md">
            {{ $hero->desc }}
        </p>
      @endif
      
      <div class="flex flex-wrap justify-center gap-4 mt-10">
        <a href="{{ route('west-java-corner') }}" class="px-8 py-4 bg-primary text-on-primary font-bold rounded-full shadow-xl hover:bg-danger hover:scale-105 hover:-translate-y-1 transition-all duration-300">
          West Java Corner
        </a>
        <a href="{{ route('about-us') }}" class="px-8 py-4 bg-white/10 backdrop-blur-md border border-white/30 text-on-primary font-bold rounded-full shadow-lg hover:bg-white/20 transition-all duration-300">
          Tentang Kami
        </a>
      </div>
    </div>
    
    <!-- Scroll Down Indicator -->
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-white/70 animate-bounce">
      <span class="text-xs tracking-widest uppercase font-semibold">Scroll Down</span>
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
    </div>
  </section>

  <!-- LIVESTREAM SECTION -->
  @if($activeLive)
  <section id="livestream" class="max-w-7xl mx-auto px-6 lg:px-8 py-16 -mt-10 relative z-20">
    <div class="bg-gray-900 rounded-[2rem] overflow-hidden shadow-2xl border border-gray-800">
      <div class="p-4 bg-primary text-white flex items-center gap-3">
        <span class="w-3 h-3 bg-white rounded-full animate-pulse"></span>
        <span class="font-bold tracking-wider text-sm">LIVE NOW</span>
      </div>
      <div class="p-8 md:p-10 space-y-4">
        <h2 class="text-3xl md:text-4xl font-heading font-bold text-white">{{ $activeLive->title }}</h2>
        <p class="text-gray-400">Saksikan pertandingan secara langsung</p>
        
        <div class="relative w-full aspect-video bg-black rounded-2xl overflow-hidden mt-6 shadow-lg">
          <iframe
            id="livestreamIframe"
            class="absolute top-0 left-0 w-full h-full"
            src="{{ $activeLive->embed_url }}"
            title="{{ $activeLive->title }}"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen>
          </iframe>
        </div>
      </div>
    </div>
  </section>
  @endif

  <!-- HIGHLIGHTS / BEST PARTS (Card Layout) -->
  <section id="highlights" class="max-w-7xl mx-auto px-6 lg:px-8 py-24">
    <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
        <div>
            <h2 class="text-4xl md:text-5xl font-heading font-bold text-gray-900 tracking-tight">Experience the Best <br/>in Handball</h2>
        </div>
        <div class="max-w-md text-gray-500 text-lg">
            Our facilities and events feature state-of-the-art training zones and spaces for tournaments or casual games.
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
      @if($highlights->count() > 0)
        @php
            $mainHighlight = $highlights->first();
            preg_match('/(?:youtu\.be\/|youtube\.com\/watch\?v=)([^&]+)/', $mainHighlight->link, $matchesMain);
            $mainVideoId = $matchesMain[1] ?? null;
        @endphp
        
        <!-- Main Video Card -->
        <div class="md:col-span-8 group relative rounded-[2rem] overflow-hidden shadow-2xl bg-black h-[400px] md:h-[500px]">
          @if($mainVideoId)
          <a href="{{ $mainHighlight->link }}" target="_blank" class="block w-full h-full">
            <img src="https://img.youtube.com/vi/{{ $mainVideoId }}/maxresdefault.jpg" alt="{{ $mainHighlight->title }}" class="w-full h-full object-cover opacity-70 group-hover:opacity-90 group-hover:scale-105 transition-all duration-700">
            <div class="absolute inset-0 flex items-center justify-center">
              <div class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center shadow-2xl group-hover:bg-primary transition-all duration-300">
                <div class="w-0 h-0 border-t-[12px] border-t-transparent border-l-[20px] border-l-white border-b-[12px] border-b-transparent ml-2"></div>
              </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full p-8 bg-gradient-to-t from-black/90 to-transparent">
                <div class="inline-block px-3 py-1 mb-3 rounded-full bg-primary text-xs font-bold text-white uppercase tracking-wider">Premium Action</div>
                <h3 class="text-3xl font-heading font-bold text-white leading-tight drop-shadow-md">{{ $mainHighlight->title }}</h3>
            </div>
          </a>
          @endif
        </div>

        <!-- Secondary Videos Grid -->
        <div class="md:col-span-4 grid grid-cols-1 gap-6">
          @foreach($highlights->skip(1)->take(2) as $highlight)
              @php
                  preg_match('/(?:youtu\.be\/|youtube\.com\/watch\?v=)([^&]+)/', $highlight->link, $matches);
                  $videoId = $matches[1] ?? null;
              @endphp
              @if($videoId)
              <a href="{{ $highlight->link }}" target="_blank" class="block relative rounded-[2rem] overflow-hidden shadow-xl bg-black h-full min-h-[200px] group">
                  <img src="https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg" alt="{{ $highlight->title }}" class="w-full h-full object-cover opacity-60 group-hover:opacity-90 group-hover:scale-110 transition-all duration-700">
                  <div class="absolute inset-0 flex items-center justify-center">
                      <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center group-hover:bg-primary transition-all duration-300">
                         <div class="w-0 h-0 border-t-[8px] border-t-transparent border-l-[12px] border-l-white border-b-[8px] border-b-transparent ml-1"></div>
                      </div>
                  </div>
                  <div class="absolute bottom-0 left-0 w-full p-6 bg-gradient-to-t from-black/90 to-transparent">
                      <h4 class="text-lg font-heading font-bold text-white leading-tight">{{ $highlight->title }}</h4>
                  </div>
              </a>
              @endif
          @endforeach
        </div>
      @else
        <div class="md:col-span-12 text-center py-20 bg-gray-100 rounded-[2rem]">
            <h4 class="text-2xl font-heading text-gray-500">No Highlights Available</h4>
        </div>
      @endif
    </div>
  </section>

  <!-- DATA KEANGGOTAAN (Features Grid) -->
  <section class="max-w-7xl mx-auto px-6 lg:px-8 py-20 bg-white rounded-[3rem] shadow-sm mb-20 border border-gray-100">
    <div class="text-center mb-16">
        <h2 class="text-4xl md:text-5xl font-heading font-bold text-gray-900 tracking-tight">Empowering Sports Through<br/>Innovation and Convenience</h2>
        <p class="mt-6 text-gray-500 max-w-2xl mx-auto text-lg">We are more than just a platform — we are a community built for athletes, trainers, event organizers, and sports enthusiasts.</p>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      @php
          $stats = [
              ['val' => '156+', 'label' => 'School Clubs', 'color' => 'text-primary'],
              ['val' => '240+', 'label' => 'Certified Trainers', 'color' => 'text-gray-900'],
              ['val' => '112+', 'label' => 'Active Referees', 'color' => 'text-gray-900'],
              ['val' => '97%', 'label' => 'Satisfaction Rate', 'color' => 'text-success'],
          ];
      @endphp
      @foreach($stats as $stat)
      <div class="p-8 rounded-[2rem] bg-gray-50 flex flex-col items-center justify-center text-center group hover:bg-gray-100 transition-colors">
        <span class="text-5xl md:text-6xl font-heading font-black {{ $stat['color'] }} mb-3 group-hover:scale-110 transition-transform duration-300">{{ $stat['val'] }}</span>
        <span class="text-sm text-gray-500 font-bold uppercase tracking-widest">{{ $stat['label'] }}</span>
      </div>
      @endforeach
    </div>
  </section>

  <!-- NEWS SECTION -->
  <section class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
    <h2 class="text-4xl md:text-5xl font-heading font-bold text-gray-900 tracking-tight mb-12">Latest Updates</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
      <!-- INSPIRING NEWS -->
      <div class="flex flex-col gap-6">
        <h3 class="text-2xl font-heading font-bold text-gray-800 flex items-center gap-3">
            <span class="w-4 h-4 rounded-full bg-warning"></span> Inspiring News
        </h3>
        @forelse($bigNews as $news)
        <a href="{{ url('/news/'.$news->slug) }}" class="group bg-white p-6 rounded-[2rem] shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 flex flex-col sm:flex-row gap-6 items-start">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-4 py-1.5 bg-gray-100 text-gray-700 rounded-full text-xs font-bold uppercase tracking-wider group-hover:bg-warning group-hover:text-gray-900 transition-colors">Inspirational</span>
                    <span class="text-xs text-gray-400 font-medium">{{ \Carbon\Carbon::parse($news->created_at)->format('d M Y') }}</span>
                </div>
                <h4 class="text-xl font-heading font-bold text-gray-900 leading-tight mb-3 group-hover:text-primary transition-colors">{{ $news->title }}</h4>
                <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed">{{ Str::limit(strip_tags($news->content), 120) }}</p>
            </div>
        </a>
        @empty
        <div class="p-8 text-center text-gray-400 bg-gray-50 rounded-[2rem]">No latest news available</div>
        @endforelse
      </div>

      <!-- INTERNATIONAL NEWS -->
      <div class="flex flex-col gap-6">
        <h3 class="text-2xl font-heading font-bold text-gray-800 flex items-center gap-3">
            <span class="w-4 h-4 rounded-full bg-blue-500"></span> International
        </h3>
        @forelse($internationalNews as $news)
        <a href="{{ url('/news/'.$news->slug) }}" class="group bg-white p-6 rounded-[2rem] shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 flex flex-col sm:flex-row gap-6 items-start">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-4 py-1.5 bg-gray-100 text-gray-700 rounded-full text-xs font-bold uppercase tracking-wider group-hover:bg-blue-600 group-hover:text-white transition-colors">{{ $news->category ?? 'News' }}</span>
                    <span class="text-xs text-gray-400 font-medium">{{ \Carbon\Carbon::parse($news->created_at)->format('d M Y') }}</span>
                </div>
                <h4 class="text-xl font-heading font-bold text-gray-900 leading-tight mb-3 group-hover:text-blue-600 transition-colors">{{ $news->title }}</h4>
                <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed">{{ Str::limit(strip_tags($news->content), 120) }}</p>
            </div>
        </a>
        @empty
        <div class="p-8 text-center text-gray-400 bg-gray-50 rounded-[2rem]">No latest news available</div>
        @endforelse
      </div>
    </div>
  </section>

  <!-- KEGIATAN TERBARU (Activities Grid) -->
  <section class="max-w-7xl mx-auto px-6 lg:px-8 py-24">
    <div class="flex justify-between items-end mb-12">
        <h2 class="text-4xl md:text-5xl font-heading font-bold text-gray-900 tracking-tight">Discover Activities</h2>
        <a href="{{ url('/news') }}" class="hidden sm:inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white font-bold rounded-full hover:bg-gray-800 transition-colors">
            See All <span aria-hidden="true">&rarr;</span>
        </a>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
      @foreach($kegiatan as $keg)
      <div class="group cursor-pointer">
        <div class="relative w-full aspect-[4/5] rounded-[2rem] overflow-hidden mb-5 shadow-sm group-hover:shadow-xl transition-all duration-500">
          <img src="{{ $keg->image ? asset('storage/'.$keg->image) : 'https://placehold.co/600x800' }}" alt="{{ $keg->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
          <div class="absolute bottom-6 left-6 right-6 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
            <a href="{{ $keg->link ?? '#' }}" class="block w-full py-3 bg-white text-gray-900 text-center font-bold rounded-full shadow-lg hover:bg-gray-50">
              Explore Activity
            </a>
          </div>
        </div>
        <h4 class="font-heading font-bold text-xl text-gray-900 leading-tight group-hover:text-primary transition-colors px-2">
           {{ $keg->name }}
        </h4>
      </div>
      @endforeach
    </div>
    <div class="mt-10 sm:hidden text-center">
        <a href="{{ url('/news') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gray-900 text-white font-bold rounded-full hover:bg-gray-800 transition-colors">
            See All Activities
        </a>
    </div>
  </section>

  <!-- SOCIAL MEDIA FEEDS -->
  <section class="max-w-7xl mx-auto px-6 lg:px-8 py-16 mb-10">
    <div class="flex items-center justify-between mb-10">
        <h2 class="text-3xl font-heading font-bold text-gray-900 tracking-tight">Stay Connected</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Instagram -->
        <a href="https://www.instagram.com/westjavahandball" target="_blank" class="group bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">IG</div>
                <div>
                    <div class="font-bold text-gray-900 text-lg group-hover:text-primary transition-colors">westjavahandball</div>
                    <div class="text-sm text-gray-500">Instagram</div>
                </div>
            </div>
            <p class="text-gray-600 mb-6">Ikuti berbagai kegiatan dan update terbaru seputar bola tangan di Jawa Barat.</p>
            <div class="font-bold text-sm text-purple-600 group-hover:text-purple-700">Follow on Instagram &rarr;</div>
        </a>

        <!-- TikTok -->
        <a href="https://www.tiktok.com/@teamjawabarat" target="_blank" class="group bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 bg-black rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">TK</div>
                <div>
                    <div class="font-bold text-gray-900 text-lg group-hover:text-primary transition-colors">teamjawabarat</div>
                    <div class="text-sm text-gray-500">TikTok</div>
                </div>
            </div>
            <p class="text-gray-600 mb-6">Saksikan keseruan dan momen menarik atlet bola tangan Jawa Barat.</p>
            <div class="font-bold text-sm text-gray-900 group-hover:text-black">Follow on TikTok &rarr;</div>
        </a>

        <!-- YouTube -->
        <a href="https://www.youtube.com/@westjavahandball" target="_blank" class="group bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 bg-red-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">YT</div>
                <div>
                    <div class="font-bold text-gray-900 text-lg group-hover:text-primary transition-colors">westjavahandball</div>
                    <div class="text-sm text-gray-500">YouTube</div>
                </div>
            </div>
            <p class="text-gray-600 mb-6">Tonton siaran ulang pertandingan, podcast, dan video eksklusif lainnya.</p>
            <div class="font-bold text-sm text-red-600 group-hover:text-red-700">Subscribe Channel &rarr;</div>
        </a>
    </div>
  </section>

  <!-- SPONSOR & MITRA STRATEGIS -->
  <section class="max-w-7xl mx-auto px-6 lg:px-8 py-16 border-t border-gray-200">
    <div class="text-center mb-10">
      <h2 class="text-sm font-bold text-gray-400 uppercase tracking-[0.2em]">Trusted By Our Partners</h2>
    </div>
    @if($sponsors->count())
      <div class="flex flex-wrap justify-center items-center gap-12 opacity-60 hover:opacity-100 transition-opacity duration-500">
          @foreach($sponsors->take(10) as $sponsor)
          <div class="h-10 md:h-12 flex items-center justify-center grayscale hover:grayscale-0 transition-all duration-300">
              <img src="{{ asset('storage/'.$sponsor->image) }}" alt="{{ $sponsor->name }}" class="max-h-full max-w-full object-contain">
          </div>
          @endforeach
      </div>
    @else
      <div class="text-center text-gray-400 text-sm">
          <p>Informasi sponsor akan segera diperbarui.</p>
      </div>
    @endif
  </section>

</main>
@endsection
