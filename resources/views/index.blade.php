@extends('layouts.app')

@section('content')
@php use Illuminate\Support\Str; @endphp
<main class="w-full bg-gray-50 overflow-hidden">

  <!-- HERO SECTION -->
  <section id="beranda" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20 flex flex-col md:flex-row items-center justify-between gap-8">
    <div class="flex-1 space-y-6">
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-red-600 leading-tight">
        Asosiasi Bola <br/> Tangan Indonesia <br/> Provinsi Jawa Barat
      </h1>
      <div class="flex flex-wrap gap-4 mt-6">
        <a href="{{ route('event') }}" class="px-6 py-3 bg-red-600 text-white font-semibold rounded shadow-md hover:bg-red-700 transition">
          Lihat Event <span aria-hidden="true">&rarr;</span>
        </a>
        <a href="{{ route('gallery') }}" class="px-6 py-3 bg-red-600 text-white font-semibold rounded shadow-md hover:bg-red-700 transition">
          Lihat Galeri <span aria-hidden="true">&rarr;</span>
        </a>
        <a href="{{ route('profile') }}" class="px-6 py-3 bg-red-600 text-white font-semibold rounded shadow-md hover:bg-red-700 transition">
          Lihat Profil <span aria-hidden="true">&rarr;</span>
        </a>
      </div>
    </div>
    <div class="flex-1">
      <picture class="w-full h-auto">
        <source media="(max-width: 980px)" srcset="{{ asset('img/sechero.png') }}">
        <img src="{{ asset('img/mainhero.png') }}" alt="ABTI JAWA BARAT" class="w-full h-auto object-cover rounded-xl" />
      </picture>
    </div>
  </section>

  <!-- LIVESTREAM SECTION (IF ANY) -->
  @if($activeLive)
  <section id="livestream" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-gray-900 rounded-2xl overflow-hidden shadow-xl border border-gray-800">
      <div class="p-4 bg-red-600 text-white flex items-center gap-3">
        <span class="w-3 h-3 bg-white rounded-full animate-pulse"></span>
        <span class="font-bold tracking-wider text-sm">LIVE NOW</span>
      </div>
      <div class="p-6 md:p-8 space-y-4">
        <h2 class="text-2xl md:text-3xl font-bold text-white">{{ $activeLive->title }}</h2>
        <p class="text-gray-400">Saksikan pertandingan secara langsung</p>
        
        <div class="relative w-full aspect-video bg-black rounded-lg overflow-hidden mt-4">
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
        
        <div class="text-sm text-gray-500 pt-4">
          Streaming dimulai pada
          {{ \Carbon\Carbon::parse($activeLive->date)->format('d M Y') }}
          pukul {{ $activeLive->time }} WIB
        </div>
      </div>
    </div>
  </section>
  @endif

  <!-- BEST PARTS (EXTENDED HIGHLIGHTS) -->
  <section id="highlights" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-2xl font-bold text-red-600 mb-6 uppercase tracking-wide">BEST PARTS</h2>
    <div class="bg-gray-900 rounded-xl p-4 shadow-xl">
      @if($highlights->count() > 0)
        @php
            $mainHighlight = $highlights->first();
            preg_match('/(?:youtu\.be\/|youtube\.com\/watch\?v=)([^&]+)/', $mainHighlight->link, $matchesMain);
            $mainVideoId = $matchesMain[1] ?? null;
        @endphp
        @if($mainVideoId)
        <div class="relative w-full aspect-video bg-black rounded-lg overflow-hidden mb-4 group block">
          <a href="{{ $mainHighlight->link }}" target="_blank" class="block w-full h-full">
            <img src="https://img.youtube.com/vi/{{ $mainVideoId }}/maxresdefault.jpg" alt="{{ $mainHighlight->title }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition duration-300">
            <div class="absolute inset-0 flex items-center justify-center">
              <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition duration-300">
                <div class="w-0 h-0 border-t-[10px] border-t-transparent border-l-[16px] border-l-red-600 border-b-[10px] border-b-transparent ml-1"></div>
              </div>
            </div>
            <div class="absolute bottom-4 left-4 text-white font-semibold text-lg drop-shadow-md">
                {{ $mainHighlight->title }}
            </div>
          </a>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          @foreach($highlights->skip(1)->take(3) as $highlight)
              @php
                  preg_match('/(?:youtu\.be\/|youtube\.com\/watch\?v=)([^&]+)/', $highlight->link, $matches);
                  $videoId = $matches[1] ?? null;
              @endphp
              @if($videoId)
              <a href="{{ $highlight->link }}" target="_blank" class="block relative aspect-video rounded-lg overflow-hidden group">
                  <img src="https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg" alt="{{ $highlight->title }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition duration-300">
                  <div class="absolute inset-0 flex items-center justify-center">
                      <div class="w-10 h-10 bg-white/80 rounded-full flex items-center justify-center group-hover:bg-white transition duration-300">
                         <div class="w-0 h-0 border-t-[6px] border-t-transparent border-l-[10px] border-l-red-600 border-b-[6px] border-b-transparent ml-1"></div>
                      </div>
                  </div>
                  <div class="absolute bottom-2 left-2 text-white font-medium text-sm drop-shadow-md truncate w-11/12">
                      {{ $highlight->title }}
                  </div>
              </a>
              @endif
          @endforeach
        </div>
      @else
        <div class="text-center py-10 text-gray-400">
            <h4 class="text-lg font-semibold">Belum Ada Extended Highlights</h4>
            <p>Video highlight akan ditampilkan setelah tersedia.</p>
        </div>
      @endif
    </div>
  </section>

  <!-- NEWS SECTION (INSPIRING & INTERNATIONAL) -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
      <!-- INSPIRING NEWS -->
      <div>
        <h2 class="text-2xl font-bold text-red-600 mb-6 uppercase tracking-wide">INSPIRING NEWS</h2>
        <div class="space-y-6">
          @forelse($bigNews->take(3) as $news)
          <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="text-xs text-gray-400 mb-2">{{ \Carbon\Carbon::parse($news->created_at)->format('d M Y') }} &bull; {{ strtoupper($news->category ?? 'Berita Utama') }}</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2 leading-snug">{{ $news->title }}</h3>
            <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ Str::limit(strip_tags($news->content), 100) }}</p>
            <a href="{{ url('/news/'.$news->slug) }}" class="text-red-600 font-semibold text-sm hover:underline">Lihat update</a>
          </div>
          @empty
          <div class="text-gray-500">Belum Ada Berita Terbaru</div>
          @endforelse
        </div>
      </div>

      <!-- INTERNATIONAL NEWS -->
      <div>
        <h2 class="text-2xl font-bold text-red-600 mb-6 uppercase tracking-wide">INTERNATIONAL NEWS</h2>
        <div class="space-y-6">
          @forelse($activities->take(3) as $news)
          <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="text-xs text-gray-400 mb-2">{{ \Carbon\Carbon::parse($news->created_at)->format('d M Y') }} &bull; {{ strtoupper($news->category ?? 'Berita Internasional') }}</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2 leading-snug">{{ $news->title }}</h3>
            <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ Str::limit(strip_tags($news->content), 100) }}</p>
            <a href="{{ url('/news/'.$news->slug) }}" class="text-red-600 font-semibold text-sm hover:underline">Lihat update</a>
          </div>
          @empty
          <div class="text-gray-500">Belum Ada Berita Terbaru</div>
          @endforelse
        </div>
      </div>
    </div>
  </section>

  <!-- KEGIATAN TERBARU -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-2xl font-bold text-red-600 mb-6 uppercase tracking-wide">KEGIATAN TERBARU</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach($activities->skip(3)->take(3) as $news)
      <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col border border-gray-100">
        <div class="aspect-video w-full overflow-hidden bg-gray-200">
          <img src="{{ asset('storage/'.$news->image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
        </div>
        <div class="p-5 flex-1 flex flex-col justify-between">
          <h4 class="font-bold text-gray-900 mb-3 text-sm leading-snug line-clamp-3">
             {{ $news->title }}
          </h4>
          <a href="{{ url('/news/'.$news->slug) }}" class="mt-auto block w-full text-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded hover:bg-red-700 transition">
            Baca Berita
          </a>
        </div>
      </div>
      @endforeach
      
      <!-- Lihat Semua Card -->
      <a href="{{ url('/news') }}" class="bg-red-500 rounded-xl shadow-md flex flex-col items-center justify-center p-6 hover:bg-red-600 transition group min-h-[250px]">
        <span class="text-white font-bold text-lg mb-4">Lihat Semua</span>
        <div class="w-12 h-12 bg-white/20 group-hover:bg-white/30 rounded-full flex items-center justify-center transition border border-white/50">
          <span class="text-white text-xl font-bold">&rarr;</span>
        </div>
      </a>
    </div>
  </section>

  <!-- DATA KEANGGOTAAN -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <h2 class="text-2xl font-bold text-red-600 mb-10 uppercase tracking-wide">DATA KEANGGOTAAN</h2>
    
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
      @php
          $stats = [
              ['val' => '27', 'label' => 'KLUB'],
              ['val' => '156', 'label' => 'KLUB SEKOLAH'],
              ['val' => '42', 'label' => 'KLUB UNIVERSITAS'],
              ['val' => '89', 'label' => 'ATLET'],
              ['val' => '112', 'label' => 'WASIT'],
              ['val' => '240', 'label' => 'PELATIH'],
              ['val' => '180', 'label' => 'PELATIH GK'],
              ['val' => '45', 'label' => 'DIREKTUR TEKNIS'],
              ['val' => '320', 'label' => 'TIM MANAJEMEN'],
              ['val' => '15', 'label' => 'OFISIAL PERTANDINGAN'],
              ['val' => '60', 'label' => 'DELEGASI TEKNIS'],
              ['val' => '500', 'label' => 'VOLUNTEER'],
          ];
      @endphp
      @foreach($stats as $stat)
      <div class="bg-white border border-gray-200 rounded-xl py-6 px-4 shadow-sm flex flex-col items-center justify-center">
        <span class="text-3xl font-extrabold text-gray-900 mb-1">{{ $stat['val'] }}</span>
        <span class="text-xs text-gray-500 font-semibold tracking-wider uppercase text-center">{{ $stat['label'] }}</span>
      </div>
      @endforeach
    </div>
    
    <button type="button" class="px-8 py-3 bg-red-600 text-white font-bold rounded-lg shadow-md hover:bg-red-700 transition">
      Lihat Semua
    </button>
  </section>

  <!-- SPONSOR & MITRA STRATEGIS -->
  <section class="bg-red-600 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h2 class="text-3xl font-bold text-white mb-3">Sponsor & Mitra Strategis</h2>
      <p class="text-red-100 mb-10">Dukungan sponsor dan mitra turut memperkuat pembinaan serta prestasi atlet bola tangan Jawa Barat.</p>
      
      @if($sponsors->count())
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3 justify-center">
            @foreach($sponsors->take(16) as $sponsor)
            <div class="bg-white rounded-lg aspect-square flex items-center justify-center p-3 shadow-md hover:scale-105 transition duration-300">
                <img src="{{ asset('storage/'.$sponsor->logo) }}" alt="{{ $sponsor->name }}" class="max-h-full max-w-full object-contain filter grayscale hover:grayscale-0 transition duration-300">
            </div>
            @endforeach
        </div>
      @else
        <div class="text-white/80 py-8">
            <h3 class="text-xl font-semibold mb-2">Belum Ada Sponsor</h3>
            <p>Informasi sponsor dan mitra strategis akan segera diperbarui.</p>
        </div>
      @endif
    </div>
  </section>

  <!-- UPDATE INFORMASI (SOCIAL MEDIA FEEDS PLACEHOLDER) -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-2xl font-bold text-gray-900 mb-8 uppercase tracking-wide">UPDATE INFORMASI</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Placeholder for Instagram embed 1 -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-4 flex items-center gap-3 border-b border-gray-100">
                <div class="w-10 h-10 bg-gray-200 rounded-full flex-shrink-0"></div>
                <div>
                    <div class="text-sm font-bold text-gray-900">abti_jabar <span class="text-blue-500 material-icons text-sm align-middle">verified</span></div>
                    <div class="text-xs text-gray-500">Bandung, Jawa Barat</div>
                </div>
            </div>
            <div class="aspect-square bg-gray-200">
                <img src="{{ asset('img/mainhero.png') }}" class="w-full h-full object-cover" alt="IG Post 1">
            </div>
            <div class="p-4">
                <div class="text-sm text-gray-800 line-clamp-3 mb-4">
                    Pertandingan final yang sangat menegangkan antara tim...
                </div>
                <button class="w-full bg-red-600 text-white font-bold py-2 rounded text-sm hover:bg-red-700 transition">View on Instagram</button>
            </div>
        </div>

        <!-- Placeholder for Instagram embed 2 -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-4 flex items-center gap-3 border-b border-gray-100">
                <div class="w-10 h-10 bg-gray-200 rounded-full flex-shrink-0"></div>
                <div>
                    <div class="text-sm font-bold text-gray-900">abti_jabar <span class="text-blue-500 material-icons text-sm align-middle">verified</span></div>
                    <div class="text-xs text-gray-500">Cirebon</div>
                </div>
            </div>
            <div class="aspect-square bg-gray-200">
                <img src="{{ asset('img/sechero.png') }}" class="w-full h-full object-cover" alt="IG Post 2">
            </div>
            <div class="p-4">
                <div class="text-sm text-gray-800 line-clamp-3 mb-4">
                    Pelatihan wasit dan pelatih tingkat provinsi Jawa Barat tahun 2024...
                </div>
                <button class="w-full bg-red-600 text-white font-bold py-2 rounded text-sm hover:bg-red-700 transition">View on Instagram</button>
            </div>
        </div>

        <!-- Placeholder for Facebook embed -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden flex flex-col">
            <div class="p-4 bg-blue-600 text-white flex items-center gap-2">
                <span class="font-bold text-lg">Facebook</span>
            </div>
            <div class="p-6 flex-1 flex flex-col justify-center items-center text-center">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-4">
                    <span class="text-2xl font-bold">f</span>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">ABTI Jawa Barat</h3>
                <p class="text-sm text-gray-600 mb-6">Ikuti halaman Facebook resmi kami untuk mendapatkan informasi terbaru seputar bola tangan di Jawa Barat.</p>
                <button class="px-6 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition shadow-md">Ikuti Halaman</button>
            </div>
        </div>
    </div>
  </section>
</main>
@endsection
