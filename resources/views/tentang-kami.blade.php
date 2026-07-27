@extends('layouts.app')
@section('content')
  <main class="w-full font-sans overflow-hidden text-gray-800 bg-white">
    
    <!-- ================= HERO TENTANG KAMI ================= -->
    <section class="relative pt-20 pb-20 lg:pt-28 lg:pb-32 overflow-hidden" aria-label="Tentang Kami">
      <div class="w-full px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          
          <!-- Left Column: Text -->
          <div class="z-10">
            <p class="text-primary font-bold tracking-wider uppercase mb-4 text-sm md:text-base">Tentang Kami</p>
            <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
              Asosiasi Bola Tangan Indonesia<br>
              <span class="text-primary">Provinsi Jawa Barat</span>
            </h1>
            <p class="text-lg text-gray-600 mb-8 max-w-xl leading-relaxed">
              Adalah organisasi yang mewadahi pembinaan, pengembangan,
              dan pengelolaan olahraga bola tangan di Provinsi Jawa Barat.
            </p>
            <a href="#program-kerja" class="inline-flex items-center justify-center px-8 py-4 bg-primary text-on-primary font-bold rounded-full hover:bg-danger transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1">
              Program Kami
            </a>
          </div>

          <!-- Right Column: Image -->
          <div class="relative z-10 hidden lg:block">
            <!-- Decorative background blob -->
            <div class="absolute inset-0 bg-primary/10 rounded-[3rem] transform rotate-3 scale-105"></div>
            <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl border-4 border-white">
              <img src="{{ asset('img/about1.avif') }}" alt="ABTI Jabar" class="w-full h-auto object-cover object-center aspect-[4/3]" onerror="this.src='{{ asset('img/mainhero.png') }}'">
            </div>
          </div>
          
        </div>
      </div>
    </section>

    <!-- ===================== ABOUT (TENTANG ABTI JABAR) ===================== -->
    <section class="py-20 bg-white" id="aboutShell">
      <div class="w-full px-4 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-16">
          <h2 class="font-heading text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Tentang ABTI Jawa Barat</h2>
          <p class="text-gray-600 text-lg">Perjalanan, arah, dan struktur organisasi untuk membangun ekosistem bola tangan di Jawa Barat.</p>
        </div>

        <!-- Horizontal Tabs -->
        <div class="flex flex-wrap justify-center gap-4 mb-12" id="about-tabs">
          <button class="about-tab-btn px-6 py-3 rounded-full font-bold transition-all duration-300 bg-primary text-white shadow-md" data-about="history" type="button">
            Sejarah
          </button>
          <button class="about-tab-btn px-6 py-3 rounded-full font-bold transition-all duration-300 bg-gray-100 text-gray-600 hover:bg-gray-200" data-about="vision" type="button">
            Visi dan Misi
          </button>
          <button class="about-tab-btn px-6 py-3 rounded-full font-bold transition-all duration-300 bg-gray-100 text-gray-600 hover:bg-gray-200" data-about="org" type="button">
            Organisasi
          </button>
        </div>

        <!-- Content Card -->
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-12 min-h-[400px]">
          
          {{-- HISTORY --}}
          <div class="about-content-item block animate-fadeIn" id="about-history">
              <h4 class="text-sm md:text-base font-semibold text-primary uppercase tracking-wider mb-2">{{ $history->kicker ?? 'HISTORY' }}</h4>
              <h3 class="font-heading text-2xl md:text-3xl lg:text-4xl font-extrabold text-gray-900 mb-6">{{ $history->title ?? '-' }}</h3>

              <p class="text-base md:text-lg text-gray-700 leading-relaxed mb-8">{{ $history->desc ?? '-' }}</p>

              @if($history && $history->timeline)
                  @php $timelines = json_decode($history->timeline); @endphp
                  @if(is_array($timelines) && count($timelines) > 0)
                      <div class="mt-8 border-l-2 border-primary pl-6 space-y-8">
                          @foreach($timelines as $item)
                              <div class="relative">
                                  <div class="absolute -left-[33px] bg-primary h-4 w-4 rounded-full border-4 border-white shadow-sm"></div>
                                  <h4 class="font-bold text-lg text-gray-900">{{ $item->title ?? '' }}</h4>
                                  <p class="text-sm text-gray-600 mt-1">{{ $item->subtitle ?? '' }}</p>
                              </div>
                          @endforeach
                      </div>
                  @endif
              @endif
          </div>

          {{-- VISION --}}
          <div class="about-content-item hidden animate-fadeIn" id="about-vision">
              <h4 class="text-sm md:text-base font-semibold text-primary uppercase tracking-wider mb-2">{{ $visi->kicker ?? 'VISION & MISSION' }}</h4>
              <h3 class="font-heading text-2xl md:text-3xl lg:text-4xl font-extrabold text-gray-900 mb-6">{{ $visi->title ?? '-' }}</h3>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                  <div class="inline-block px-4 py-2 bg-primary/10 text-primary font-bold rounded-lg mb-6 text-xl">Visi</div>
                  @if($visi && $visi->visi)
                      @php $visiList = json_decode($visi->visi, true); @endphp
                      @if(is_array($visiList) && count($visiList) > 0)
                          <ul class="space-y-4">
                              @foreach($visiList as $v)
                                  <li class="flex items-start">
                                      <svg class="h-6 w-6 text-primary mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                      </svg>
                                      <span class="text-base md:text-lg text-gray-700 leading-relaxed">{{ $v }}</span>
                                  </li>
                              @endforeach
                          </ul>
                      @else
                          <p class="text-base md:text-lg text-gray-700 leading-relaxed">{{ $visi->visi }}</p>
                      @endif
                  @endif
                </div>
                <div>
                  <div class="inline-block px-4 py-2 bg-primary/10 text-primary font-bold rounded-lg mb-6 text-xl">Misi</div>
                  @if($visi && $visi->misi)
                      @php $misiList = json_decode($visi->misi, true); @endphp
                      @if(is_array($misiList) && count($misiList) > 0)
                          <ul class="space-y-4">
                              @foreach($misiList as $m)
                                  <li class="flex items-start">
                                      <svg class="h-6 w-6 text-primary mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                      </svg>
                                      <span class="text-base md:text-lg text-gray-700 leading-relaxed">{{ $m }}</span>
                                  </li>
                              @endforeach
                          </ul>
                      @else
                          <p class="text-base md:text-lg text-gray-700 leading-relaxed">{{ $visi->misi }}</p>
                      @endif
                  @endif
                </div>
              </div>
          </div>

          {{-- ORGANISASI --}}
          <div class="about-content-item hidden animate-fadeIn" id="about-org">
              <h4 class="text-sm md:text-base font-semibold text-primary uppercase tracking-wider mb-2">{{ $organisasi->kicker ?? 'ORGANIZATION' }}</h4>
              <h3 class="font-heading text-2xl md:text-3xl lg:text-4xl font-extrabold text-gray-900 mb-6">{{ $organisasi->title ?? '-' }}</h3>

              <p class="text-base md:text-lg text-gray-700 leading-relaxed mb-8 max-w-3xl">{{ $organisasi->desc ?? '-' }}</p>
              
              @if($organisasi && $organisasi->tag)
                  @php $tags = json_decode($organisasi->tag, true); @endphp
                  @if(is_array($tags) && count($tags) > 0)
                      <div class="flex flex-wrap gap-3">
                          @foreach($tags as $tag)
                              <span class="inline-flex items-center px-5 py-2 rounded-full text-sm font-bold bg-primary/10 text-primary border border-primary/20 transition-all hover:bg-primary hover:text-white">
                                  {{ $tag }}
                              </span>
                          @endforeach
                      </div>
                  @endif
              @endif
          </div>

        </div>

      </div>
    </section>

    <!-- ===================== ANGGOTA ABTI ===================== -->
    <section class="py-20 bg-white border-t border-gray-100" id="members">
      <div class="w-full px-4 lg:px-8">
        
        <header class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 mb-12">
          <div>
            <h2 class="font-heading text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">Anggota ABTI Kota/Kab</h2>
            <p class="text-gray-500 font-medium">Directory listing</p>
          </div>
          
          <div class="w-full lg:w-auto flex flex-col sm:flex-row gap-4">
            <!-- Search -->
            <div class="relative flex-grow sm:w-80">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
              <input id="abtiSearch" class="block w-full pl-11 pr-10 py-3 bg-white border border-gray-200 rounded-full text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all shadow-sm" type="search" placeholder="Cari kota/kab, ketua..." autocomplete="off" />
              <button id="abtiSearchClear" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none hidden">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
              </button>
            </div>
            
            <!-- Sort -->
            <div class="relative">
              <button id="abtiSortBtn" type="button" class="w-full sm:w-auto inline-flex justify-between items-center px-6 py-3 border border-gray-200 shadow-sm text-sm font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary transition-all">
                <span id="abtiSortLabel">Sort: Kota/Kab (A-Z)</span>
                <svg class="ml-2 -mr-1 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </button>
              
              <div id="abtiSortMenu" class="origin-top-right absolute right-0 mt-2 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden z-20">
                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                  <button class="abti-sort-item block w-full text-left px-4 py-2 text-sm text-primary font-bold bg-primary/5" data-sort="city_asc">Kota/Kab (A-Z)</button>
                  <button class="abti-sort-item block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" data-sort="name_asc">Nama Sekretariat (A-Z)</button>
                </div>
              </div>
            </div>
          </div>
        </header>

        <!-- Card Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="anggotaGrid">
          @forelse($clubs as $club)
            <div class="anggota-card bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 p-6 transition-all duration-300 hover:-translate-y-1 flex flex-col"
                data-city="{{ strtolower($club->city) }}"
                data-ketua="{{ strtolower($club->secretariat_name) }}"
                data-sekretaris="{{ strtolower($club->phone_number) }}"
                data-search="{{ strtolower($club->city . ' ' . $club->secretariat_name . ' ' . $club->phone_number . ' ' . $club->email) }}">
              
              <div class="flex items-center gap-4 mb-5 pb-5 border-b border-gray-100">
                @if($club->logo)
                  <img src="{{ asset('storage/' . $club->logo) }}" alt="Logo {{ $club->city }}" class="w-14 h-14 object-contain rounded-full bg-gray-50 border border-gray-100 p-1">
                @else
                  <div class="w-14 h-14 rounded-full bg-primary/10 flex items-center justify-center text-primary font-heading font-extrabold text-xl border border-primary/20">
                    {{ substr($club->city, 0, 1) }}
                  </div>
                @endif
                <div>
                  <h3 class="font-heading font-bold text-gray-900 text-lg leading-tight">{{ $club->city }}</h3>
                  <span class="text-xs font-semibold text-primary uppercase tracking-wide">Cabang</span>
                </div>
              </div>

              <div class="flex-grow space-y-4">
                <div>
                  <p class="text-[11px] text-gray-400 uppercase font-bold tracking-wider mb-1">Sekretariat</p>
                  <p class="text-sm font-semibold text-gray-800">{{ $club->secretariat_name }}</p>
                </div>
                <div>
                  <p class="text-[11px] text-gray-400 uppercase font-bold tracking-wider mb-1">No. Handphone</p>
                  <p class="text-sm font-semibold text-gray-800">{{ $club->phone_number }}</p>
                </div>
                @if($club->email)
                <div>
                  <p class="text-[11px] text-gray-400 uppercase font-bold tracking-wider mb-1">Email</p>
                  <p class="text-sm text-gray-600 truncate"><a href="mailto:{{ $club->email }}" class="hover:text-primary transition-colors">{{ $club->email }}</a></p>
                </div>
                @endif
              </div>

              @if($club->link)
                <div class="mt-6 pt-4">
                  <a href="{{ $club->link }}" target="_blank" class="block w-full py-2.5 text-center bg-gray-50 hover:bg-primary text-gray-700 hover:text-white text-sm font-bold rounded-xl transition-all border border-gray-200 hover:border-primary">
                    Kunjungi Web
                  </a>
                </div>
              @endif
            </div>
          @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-dashed border-gray-300">
              <span class="text-5xl mb-4 block">🏟️</span>
              <p class="text-xl font-heading font-bold text-gray-900">Belum Ada Anggota</p>
              <p class="text-gray-500 mt-2">Data anggota ABTI akan segera diperbarui.</p>
            </div>
          @endforelse
        </div>

      </div>
    </section>

    <!-- ===================== PROGRAM KERJA ===================== -->
    <section id="program-kerja" class="py-20 bg-white border-t border-gray-100">
      <div class="w-full px-4 lg:px-8">
        
        <header class="text-center max-w-3xl mx-auto mb-16">
          <p class="text-primary font-bold tracking-wider uppercase mb-2 text-sm">Program Kerja</p>
          <h2 class="font-heading text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Daftar Program ABTI</h2>
          <p class="text-gray-600 text-lg">
            Program kerja dirancang untuk pembinaan atlet, penguatan kompetisi,
            serta pengembangan ekosistem bola tangan.
          </p>
        </header>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          @if($programKerja->count())
              @foreach($programKerja as $pk)
                  <article class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl border border-gray-100 flex flex-col overflow-hidden transition-all duration-500 hover:-translate-y-2">
                      <div class="aspect-video relative overflow-hidden bg-gray-100">
                          @if($pk->image)
                              <img src="{{ asset('storage/' . $pk->image) }}"
                                  alt="{{ $pk->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                          @else
                              <div class="w-full h-full flex items-center justify-center font-heading font-bold text-gray-400 text-2xl tracking-wider transition-transform duration-700 group-hover:scale-110 bg-gray-50">
                                  {{ $pk->thumbnail_text ?? 'ABTI' }}
                              </div>
                          @endif
                          <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                      </div>

                      <div class="p-8 flex flex-col flex-grow relative bg-white">
                          <p class="text-xs font-bold text-primary uppercase tracking-wider mb-3">
                              {{ $pk->hero_meta ?? 'PROGRAM KERJA' }}
                              @if($pk->year)
                                  • {{ $pk->year }}
                              @endif
                          </p>

                          <h4 class="font-heading text-xl font-bold text-gray-900 mb-4 line-clamp-2 group-hover:text-primary transition-colors">
                              {{ $pk->title }}
                          </h4>

                          <p class="text-gray-600 text-sm leading-relaxed line-clamp-3 mb-6">
                              {{ Str::limit($pk->desc, 120) }}
                          </p>
                          
                          <div class="mt-auto">
                              <span class="inline-flex items-center text-sm font-bold text-primary">
                                  Baca Selengkapnya
                                  <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                  </svg>
                              </span>
                          </div>
                      </div>
                  </article>
              @endforeach
          @else
              <div class="col-span-full py-16 text-center bg-gray-50 rounded-3xl border border-dashed border-gray-300">
                  <span class="text-5xl mb-4 block">📄</span>
                  <p class="text-xl font-heading font-bold text-gray-900">Belum Ada Program Kerja</p>
                  <p class="text-gray-500 mt-2">Program kerja akan segera diperbarui.</p>
              </div>
          @endif
        </div>

        <div class="mt-12 flex justify-center">
            {{ $programKerja->links() }}
        </div>
      </div>
    </section>

  </main>

  <style>
    /* Custom Animations */
    .animate-fadeIn {
      animation: fadeIn 0.4s ease-out forwards;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- TABS LOGIC ---
        const tabBtns = document.querySelectorAll('.about-tab-btn');
        const tabContents = document.querySelectorAll('.about-content-item');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Reset all buttons
                tabBtns.forEach(b => {
                    b.classList.remove('bg-primary', 'text-white', 'shadow-md');
                    b.classList.add('bg-gray-100', 'text-gray-600');
                });
                // Activate clicked button
                this.classList.remove('bg-gray-100', 'text-gray-600');
                this.classList.add('bg-primary', 'text-white', 'shadow-md');

                // Hide all content
                tabContents.forEach(c => {
                    c.classList.remove('block');
                    c.classList.add('hidden');
                });

                // Show target content
                const targetId = 'about-' + this.dataset.about;
                const targetEl = document.getElementById(targetId);
                if(targetEl) {
                    targetEl.classList.remove('hidden');
                    targetEl.classList.add('block');
                }
            });
        });

        // --- SEARCH LOGIC ---
        const searchInput = document.getElementById('abtiSearch');
        const searchClear = document.getElementById('abtiSearchClear');
        const grid = document.getElementById('anggotaGrid');
        
        if (grid) {
            const cards = Array.from(grid.querySelectorAll('.anggota-card'));
            
            function filterCards() {
                const query = searchInput.value.toLowerCase().trim();
                
                // Toggle clear button visibility
                if (query.length > 0) {
                    searchClear.classList.remove('hidden');
                } else {
                    searchClear.classList.add('hidden');
                }

                cards.forEach(card => {
                    if (card.dataset.search.includes(query)) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            if(searchInput) {
                searchInput.addEventListener('input', filterCards);
            }
            if(searchClear) {
                searchClear.addEventListener('click', () => {
                    if(searchInput) {
                        searchInput.value = '';
                        filterCards();
                    }
                });
            }

            // --- SORT LOGIC ---
            const sortItems = document.querySelectorAll('.abti-sort-item');
            const sortLabel = document.getElementById('abtiSortLabel');
            const sortBtn = document.getElementById('abtiSortBtn');
            const sortMenu = document.getElementById('abtiSortMenu');
            
            // Toggle dropdown
            if(sortBtn && sortMenu) {
                sortBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    sortMenu.classList.toggle('hidden');
                });
                document.addEventListener('click', (e) => {
                    if (!sortBtn.contains(e.target) && !sortMenu.contains(e.target)) {
                        sortMenu.classList.add('hidden');
                    }
                });
            }

            sortItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Update active state visuals
                    sortItems.forEach(i => {
                        i.classList.remove('text-primary', 'font-bold', 'bg-primary/5');
                        i.classList.add('text-gray-700');
                    });
                    this.classList.remove('text-gray-700');
                    this.classList.add('text-primary', 'font-bold', 'bg-primary/5');
                    
                    if(sortLabel) sortLabel.textContent = 'Sort: ' + this.textContent.trim();
                    sortMenu.classList.add('hidden');
                    
                    const sortType = this.dataset.sort;
                    
                    cards.sort((a, b) => {
                        let valA = '', valB = '';
                        if (sortType === 'city_asc') {
                            valA = a.dataset.city;
                            valB = b.dataset.city;
                        } else if (sortType === 'name_asc') {
                            valA = a.dataset.ketua;
                            valB = b.dataset.ketua;
                        }
                        return valA.localeCompare(valB);
                    });
                    
                    // Re-append sorted cards
                    cards.forEach(card => grid.appendChild(card));
                });
            });
        }
    });
  </script>
@endsection