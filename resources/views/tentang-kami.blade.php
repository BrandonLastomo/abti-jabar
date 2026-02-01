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
            <div class="aboutXContent" id="aboutContent">
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
                <span class="abti-badge" id="abtiCount">0</span>
                <span class="abti-muted">entries</span>
              </div>
              <div class="abti-muted abti-hint">
                Klik “Detail” untuk melihat kontak lengkap
              </div>
            </div>
            <div class="abti-rows" id="abtiRows"></div>
            <div class="abti-pagination" aria-label="Pagination">
              <button class="abti-btn abti-btn-ghost" id="abtiPrev" type="button">Prev</button>
              <div class="abti-pageinfo" id="abtiPageInfo">Page 1/1</div>
              <button class="abti-btn abti-btn-ghost" id="abtiNext" type="button">Next</button>
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
                Menampilkan <span id="pk-visible-count">0</span> dari <span id="pk-total-count">0</span> program.
              </p>
            </div>
            <div class="pk-tools">
              <label class="pk-search" for="pk-search-input">
                <span class="pk-search__icon" aria-hidden="true">⌕</span>
                <input id="pk-search-input" type="search" placeholder="Cari program kerja..." autocomplete="off" />
              </label>
            </div>
          </header>
          <div id="pk-grid" class="pk-grid" aria-live="polite"></div>
          <nav class="pk-pagination" aria-label="Pagination Program Kerja">
            <button id="pk-prev" class="pk-btn pk-btn--ghost" type="button">Prev</button>
            <div class="pk-pageinfo"><span id="pk-page-label">Page 1/1</span></div>
            <button id="pk-next" class="pk-btn pk-btn--ghost" type="button">Next</button>
          </nav>
        </div>
      </div>
    </section>
  </main>
@endsection