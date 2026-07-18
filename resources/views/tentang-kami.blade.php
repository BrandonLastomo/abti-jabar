@extends('layouts.app')
@section('content')
  <main class="page">
    <!-- ================= HERO TENTANG KAMI ================= -->
    <section class="heroTK" aria-label="Tentang Kami">
      <div class="heroTK__bg" aria-hidden="true"></div>
      <div class="heroTK__overlay"></div>
      <div class="heroTK__content">
        <p class="heroTK__kicker">Tentang Kami</p>
        <h1 class="heroTK__title">
          Asosiasi Bola Tangan Indonesia<br>
          Provinsi Jawa Barat
        </h1>
        <p class="heroTK__sub">
          Adalah organisasi yang mewadahi pembinaan, pengembangan,
          dan pengelolaan olahraga bola tangan di Provinsi Jawa Barat
        </p>
        <a href="#program-kerja" class="heroTK__cta">
          Program Kami
        </a>
      </div>
    </section>
    <!-- ===================== ABOUT ===================== -->
    <section class="aboutShell" id="aboutShell">
      <section class="aboutXWrap" id="about">
        <div class="aboutXHead reveal">
          <h2>Tentang ABTI Jawa Barat</h2>
          <p>Perjalanan, arah, dan struktur organisasi untuk membangun ekosistem bola tangan di Jawa Barat.</p>
        </div>
        <div class="aboutXGrid">
          <div class="aboutXNav">
            <button class="aboutXCard is-active reveal" data-about="history" type="button">
              <span class="tag">A</span>
              <div>
                <div class="title">Sejarah</div>
                <div class="desc">Perjalanan & milestone</div>
              </div>
              <span class="arrow">→</span>
            </button>
            <button class="aboutXCard reveal" data-about="vision" type="button">
              <span class="tag">B</span>
              <div>
                <div class="title">Visi dan Misi</div>
                <div class="desc">Arah pembinaan</div>
              </div>
              <span class="arrow">→</span>
            </button>
            <button class="aboutXCard reveal" data-about="org" type="button">
              <span class="tag">C</span>
              <div>
                <div class="title">Organisasi</div>
                <div class="desc">Struktur & peran</div>
              </div>
              <span class="arrow">→</span>
            </button>
          </div>
          <div class="aboutXPanel reveal">
            <div class="aboutXBanner" data-parallax>
              <div class="overlay"></div>
              <div class="bannerText">
                <div class="kicker" id="aboutKicker">HISTORY</div>
                <h3 id="aboutTitle">Perjalanan ABTI Jawa Barat</h3>
              </div>
            </div>
            <div class="aboutXContent">
            {{-- HISTORY --}}
            <div class="about-content-item is-active" id="about-history">
                <h4 class="text-sm md:text-base font-semibold text-gray-500 uppercase tracking-wider mb-2">{{ $history->kicker ?? 'HISTORY' }}</h4>
                <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-4">{{ $history->title ?? '-' }}</h3>

                <p class="text-base md:text-lg text-gray-700 leading-relaxed">{{ $history->desc ?? '-' }}</p>

                @if($history && $history->timeline)
                    @php $timelines = json_decode($history->timeline); @endphp
                    @if(is_array($timelines) && count($timelines) > 0)
                        <div class="mt-8 border-l-2 border-red-500 pl-6 space-y-6">
                            @foreach($timelines as $item)
                                <div class="relative">
                                    <div class="absolute -left-[31px] bg-red-500 h-4 w-4 rounded-full border-4 border-white"></div>
                                    <h4 class="font-bold text-lg text-gray-900">{{ $item->title ?? '' }}</h4>
                                    <p class="text-sm text-gray-600">{{ $item->subtitle ?? '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
            </div>

            {{-- VISION --}}
            <div class="about-content-item" id="about-vision">
                <h4 class="text-sm md:text-base font-semibold text-gray-500 uppercase tracking-wider mb-2">{{ $visi->kicker ?? 'VISION & MISSION' }}</h4>
                <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-4">{{ $visi->title ?? '-' }}</h3>

                <h5 class="text-xl md:text-2xl font-bold text-gray-900 mt-6 mb-4">Visi</h5>
                @if($visi && $visi->visi)
                    @php $visiList = json_decode($visi->visi, true); @endphp
                    @if(is_array($visiList) && count($visiList) > 0)
                        <ul class="space-y-3 mb-6">
                            @foreach($visiList as $v)
                                <li class="flex items-start">
                                    <svg class="h-6 w-6 text-red-500 mr-2 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="text-base md:text-lg text-gray-700">{{ $v }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-base md:text-lg text-gray-700 leading-relaxed">{{ $visi->visi }}</p>
                    @endif
                @endif

                <h5 class="text-xl md:text-2xl font-bold text-gray-900 mt-6 mb-4">Misi</h5>
                @if($visi && $visi->misi)
                    @php $misiList = json_decode($visi->misi, true); @endphp
                    @if(is_array($misiList) && count($misiList) > 0)
                        <ul class="space-y-3">
                            @foreach($misiList as $m)
                                <li class="flex items-start">
                                    <svg class="h-6 w-6 text-red-500 mr-2 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="text-base md:text-lg text-gray-700">{{ $m }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-base md:text-lg text-gray-700 leading-relaxed">{{ $visi->misi }}</p>
                    @endif
                @endif
            </div>

            {{-- ORGANISASI --}}
            <div class="about-content-item" id="about-org">
                <h4 class="text-sm md:text-base font-semibold text-gray-500 uppercase tracking-wider mb-2">{{ $organisasi->kicker ?? 'ORGANIZATION' }}</h4>
                <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-4">{{ $organisasi->title ?? '-' }}</h3>

                <p class="text-base md:text-lg text-gray-700 leading-relaxed">{{ $organisasi->desc ?? '-' }}</p>
                
                @if($organisasi && $organisasi->tag)
                    @php $tags = json_decode($organisasi->tag, true); @endphp
                    @if(is_array($tags) && count($tags) > 0)
                        <div class="mt-8 flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-red-100 text-red-700 shadow-sm border border-red-200">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                @endif
            </div>

        </div>
            </div>
          </div>
        </div>
      </section>
      <!-- ===================== ABOUT (MOBILE: accordion, auto generated) ===================== -->
      <section class="aboutAccWrap" id="about-mobile"></section>
    </section>
    <section class="abti-members" id="members">
      <div class="abti-container">
        <header class="abti-header">
          <div>
            <h2 class="abti-title">Anggota ABTI Kota/Kab</h2>
            <p class="abti-subtitle" id="abtiMeta">Directory listing</p>
          </div>
          <div class="abti-toolbar" role="group" aria-label="Members toolbar">
            <div class="abti-searchbox" role="search">
              <span class="abti-search-ico" aria-hidden="true">
                <svg class="abti-ico" viewBox="0 0 24 24" focusable="false" aria-hidden="true">
                  <circle cx="11" cy="11" r="6.5"></circle>
                  <path d="M20 20l-3.6-3.6"></path>
                </svg>
              </span>
              <label class="sr-only" for="abtiSearch">Search</label>
              <input id="abtiSearch" class="abti-search-input" type="search"
                placeholder="Cari kota/kab, ketua, sekretaris…" autocomplete="off" />
              <button class="abti-search-clear" id="abtiSearchClear" type="button" aria-label="Clear search">
                ×
              </button>
            </div>
            <div class="abti-dd" id="abtiSortDD">
              <span class="sr-only">Sort</span>
              <button class="abti-dd-btn" type="button" id="abtiSortBtn" aria-haspopup="menu" aria-expanded="false">
                <span id="abtiSortLabel">Sort: Kota/Kab (A–Z)</span>
                <span class="abti-dd-caret" aria-hidden="true">▾</span>
              </button>
              <div class="abti-dd-menu" id="abtiSortMenu" role="menu" aria-label="Sort menu">
                <button class="abti-dd-item is-active" type="button" role="menuitem" data-sort="city_asc">
                  Kota/Kab (A–Z)
                </button>
                <button class="abti-dd-item" type="button" role="menuitem" data-sort="name_asc">
                  Nama Ketua (A–Z)
                </button>
              </div>
            </div>
          </div>
        </header>
        <div class="abti-panel">
          <div class="abti-list" aria-label="Members list">
            <div class="abti-list-head">
              <div class="abti-count">
                <span class="abti-badge">
                    {{ $clubs->total() }}
                </span>
                <span class="abti-muted">entries</span>
              </div>
              <div class="abti-muted abti-hint">
                Klik “Detail” untuk melihat kontak lengkap
              </div>
            </div>
            
            <div class="abti-rows">
              @if($clubs->count())

                  @foreach($clubs as $club)
                      <div class="abti-row">

                          <div class="abti-row-main">
                              <h4 class="abti-row-title">
                                  {{ $club->city }}
                              </h4>

                              <p class="abti-row-sub">
                                  {{ $club->name }}
                              </p>
                          </div>

                          <div class="abti-row-meta">
                              <span>Direktur: {{ $club->director_club }}</span>
                          </div>

                          <div class="abti-row-actions">
                              <button type="button"
                                      class="abti-btn abti-btn--primary"
                                      data-bs-toggle="collapse"
                                      data-bs-target="#club-{{ $club->id }}">
                                  Detail
                              </button>
                          </div>

                      </div>

                      <div class="abti-detail collapse" id="club-{{ $club->id }}">
                          <div class="abti-detail-card">
                              <p><strong>Administrator:</strong> {{ $club->administrator }}</p>
                              <p><strong>Direktur Teknik:</strong> {{ $club->technical_director }}</p>
                              <p><strong>Venue:</strong> {{ $club->training_venue }}</p>
                              <p><strong>Email:</strong> {{ $club->email ?? '-' }}</p>
                              <p><strong>Kontak:</strong> {{ $club->contact_person ?? '-' }}</p>
                              <p><strong>Website:</strong> 
                                  @if($club->website)
                                      <a href="{{ $club->website }}" target="_blank">
                                          {{ $club->website }}
                                      </a>
                                  @else
                                      -
                                  @endif
                              </p>
                              <p><strong>Tahun Berdiri:</strong> {{ $club->founded_year ?? '-' }}</p>
                              <p><strong>Status:</strong> {{ ucfirst($club->status) }}</p>
                          </div>
                      </div>
                  @endforeach
              @else
                  <div class="abti-empty">
                      <div class="abti-empty-icon">🏟️</div>
                      <h4>Belum Ada Anggota</h4>
                      <p>Data anggota ABTI akan segera diperbarui.</p>
                  </div>
              @endif
              </div>
            <div class="abti-pagination" aria-label="Pagination">
              <div class="abti-pagination">
                  {{ $clubs->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="abti-drawer" id="abtiDrawer" aria-hidden="true">
        <div class="abti-drawer-backdrop" id="abtiDrawerBackdrop"></div>
        <aside class="abti-drawer-panel" role="dialog" aria-modal="true" aria-labelledby="abtiDrawerTitle">
          <div class="abti-drawer-head">
            <div class="abti-drawer-titlewrap">
              <h3 class="abti-drawer-title" id="abtiDrawerTitle">Member Detail</h3>
              <p class="abti-drawer-subtitle" id="abtiDrawerSubtitle">—</p>
            </div>
            <button class="abti-iconbtn" type="button" id="abtiDrawerClose" aria-label="Close">
              ✕
            </button>
          </div>
          <div class="abti-drawer-body" id="abtiDrawerBody">
          </div>
          <div class="abti-drawer-foot">
            <button class="abti-btn" type="button" id="abtiDrawerPrimary">Buka Link</button>
            <button class="abti-btn abti-btn-ghost" type="button" id="abtiDrawerSecondary">Copy Email</button>
          </div>
        </aside>
      </div>
    </section>
    <!-- ===================== PROGRAM KERJA ===================== -->
    <section id="program-kerja" class="pk-section" aria-labelledby="pk-title">
      <div class="pk-bg">
        <div class="pk-hero" role="banner" id="pk-hero">
          <div class="pk-hero__overlay" aria-hidden="true"></div>
          <div class="pk-hero__content">
            <div class="pk-hero__default" id="pk-hero-default">
              <p class="pk-eyebrow">PROGRAM KERJA</p>
              <h2 id="pk-title" class="pk-title">ABTI Jawa Barat</h2>
              <p class="pk-subtitle">
                Program kerja ABTI Jawa Barat dirancang untuk pembinaan atlet, penguatan kompetisi,
                serta pengembangan SDM dan ekosistem bola tangan di Jawa Barat secara berkelanjutan.
              </p>
              <div class="pk-hero__actions">
                <a class="pk-btn pk-btn--primary" href="#pk-grid">Lihat Program</a>
                <a class="pk-btn pk-btn--ghost" href="#kontak">Hubungi Kami</a>
              </div>
            </div>
            <div class="pk-hero__detail" id="pk-hero-detail" aria-hidden="true">
              <p class="pk-eyebrow pk-hero__meta" id="pk-hero-meta">PROGRAM KERJA • 2026</p>
              <h2 class="pk-title pk-hero__title" id="pk-hero-title">Judul Program</h2>
              <p class="pk-subtitle pk-hero__desc" id="pk-hero-desc">
                Deskripsi singkat program kerja akan muncul di sini.
              </p>
              <div class="pk-hero__actions">
                <a class="pk-btn pk-btn--primary" id="pk-hero-doc" href="#" target="_blank" rel="noopener">
                  Unduh Dokumen Lengkap
                </a>
                <button class="pk-btn pk-btn--ghost" id="pk-hero-close" type="button">Tutup</button>
              </div>
            </div>
          </div>
        </div>
        <div class="pk-container">
          <header class="pk-header">
            <div>
              <h3 class="pk-h3">Daftar Program Kerja</h3>
              <p class="pk-muted">
                Menampilkan 
                <span>{{ $programKerja->count() }}</span> 
                dari 
                <span>{{ $programKerja->count() }}</span> 
                program.
              </p>
            </div>
            <div class="pk-tools">
              <label class="pk-search" for="pk-search-input">
                <span class="pk-search__icon" aria-hidden="true">⌕</span>
                <input id="pk-search-input" type="search" placeholder="Cari program kerja..." autocomplete="off" />
              </label>
            </div>
          </header>
          
          <div id="pk-grid" class="pk-grid">
          @if($programKerja->count())

              @foreach($programKerja as $pk)
                  <article class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 flex flex-col hover:shadow-lg transition-shadow duration-300">

                      <div class="aspect-video relative overflow-hidden bg-gray-100">
                          @if($pk->image)
                              <img src="{{ asset('storage/' . $pk->image) }}"
                                  alt="{{ $pk->title }}" class="w-full h-full object-cover">
                          @else
                              <div class="w-full h-full flex items-center justify-center font-bold text-gray-400 text-xl tracking-wider">
                                  {{ $pk->thumbnail_text ?? 'ABTI' }}
                              </div>
                          @endif
                      </div>

                      <div class="p-6 flex flex-col flex-grow">
                          <p class="text-xs font-semibold text-red-600 uppercase tracking-wider mb-2">
                              {{ $pk->hero_meta ?? 'PROGRAM KERJA' }}
                              @if($pk->year)
                                  • {{ $pk->year }}
                              @endif
                          </p>

                          <h4 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">
                              {{ $pk->title }}
                          </h4>

                          <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">
                              {{ Str::limit($pk->desc, 120) }}
                          </p>
                      </div>

                  </article>
              @endforeach

          @else

              <div class="pk-empty">
                  <div class="pk-empty__icon">📄</div>
                  <h4>Belum Ada Program Kerja</h4>
                  <p>Program kerja akan segera diperbarui.</p>
              </div>

          @endif
          </div>

          </div> {{-- END pk-grid --}}

          <div class="pk-pagination">
              {{ $programKerja->links() }}
          </div>
        </div>
      </div>
    </section>
  </main>
  <script>
document.querySelectorAll('[data-about]').forEach(btn => {
    btn.addEventListener('click', function(){

        document.querySelectorAll('.aboutXCard')
            .forEach(el => el.classList.remove('is-active'));

        this.classList.add('is-active');

        document.querySelectorAll('.about-content-item')
            .forEach(el => el.classList.remove('is-active'));

        document
            .getElementById('about-' + this.dataset.about)
            .classList.add('is-active');
    });
});
</script>
@endsection