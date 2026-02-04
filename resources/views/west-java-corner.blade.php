@extends('layouts.app')
@section('content')
<main class="page">
    <header class="page-header">
        <div class="page-header__inner">
            <h1 class="page-header__title">
                <span class="page-header__title-red">West Java Corner</span>
            </h1>
            <p class="page-header__subtitle">
                Berita terkini, highlight terbaik, dan video pendek pilihan seputar bola tangan Jawa Barat.
            </p>
        </div>
    </header>
<!-- ================= PODCAST TERBARU ================= -->
<section class="podcast" id="podcastSection">
    <div class="podcast__container">
        <header class="podcast__head">
            <h2 class="podcast__title">Podcast Terbaru</h2>
            <p class="podcast__sub">Dengarkan diskusi mendalam seputar dunia bola tangan Jawa Barat.</p>
        </header>
        <div class="podcast__carousel-container">
            <div class="podcast__carousel-wrapper">
                <div class="podcast__carousel" id="podcastCarousel">
                    <div class="podcast__track" id="podcastTrack" aria-live="polite">
                        <!-- Podcast items will be dynamically loaded here -->
                    </div>
                </div>
                <button class="podcast__nav podcast__nav--prev" id="podcastPrev" type="button" aria-label="Previous podcast">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
                    </svg>
                </button>
                <button class="podcast__nav podcast__nav--next" id="podcastNext" type="button" aria-label="Next podcast">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
                    </svg>
                </button>
            </div>
            <div class="podcast__indicators" id="podcastIndicators" aria-label="Podcast navigation dots"></div>
        </div>
        <footer class="podcast__footer">
            <a class="podcast__link" href="https://www.youtube.com/@CHANNEL_KAMU/podcasts" target="_blank" rel="noopener">
                Lihat semua podcast di YouTube
            </a>
        </footer>
    </div>
</section>
    <section class="enterprise-news-video" id="newsVideoSection">
        <div class="env-container">
            <div class="env-grid">
                <article class="env-card env-news" aria-labelledby="envNewsTitle">
                    <header class="env-card__header">
                        <h2 class="env-title" id="envNewsTitle">Berita terbaru</h2>
                        <p class="env-subtitle">Pembaruan ringkas dan formal untuk menjaga Anda tetap terinformasi.
                        </p>
                    </header>
                    <div class="env-news__list" id="envNewsList" aria-live="polite"></div>
                    <footer class="env-card__footer env-news__footer">
                        <a class="env-link" href="https://www.youtube.com/@CHANNEL_KAMU" target="_blank"
                            rel="noopener">
                            Lihat semua update di YouTube
                        </a>
                        <div class="env-news__pager" aria-label="Navigasi berita">
                            <button id="envNewsPrev" class="env-pagerbtn" type="button">Prev</button>
                            <button id="envNewsNext" class="env-pagerbtn" type="button">Next</button>
                        </div>
                    </footer>
                </article>
                <aside class="env-card env-video" aria-labelledby="envVideoTitle">
                    <header class="env-card__header">
                        <h2 class="env-title" id="envVideoTitle">Best Parts</h2>
                        <p class="env-subtitle">Cuplikan singkat: highlight utama dalam format YouTube Shorts.</p>
                    </header>
                    <div class="env-video__frame">
                        <div id="envReels" class="env-reels" aria-label="YouTube Shorts Feed" tabindex="0"></div>
                    </div>
                    <footer class="env-card__footer env-video__footer">
                        <a id="envShortCta" class="env-btn env-btn--ghost"
                            href="https://www.youtube.com/shorts/VIDEO_ID" target="_blank" rel="noopener">
                            Buka di YouTube
                        </a>
                    </footer>
                </aside>
            </div>
        </div>
    </section>

    <!-- ================= BERITA LAINNYA (GRID CARDS) ================= -->
    <section class="moreNews" id="moreNews">
        <div class="moreNews__container">
            <header class="moreNews__head">
                <h2 class="moreNews__title">Berita Lainnya</h2>
                <p class="moreNews__sub">Kumpulan berita pilihan dalam format kartu.</p>
            </header>
            <div class="moreNewsGrid" id="moreNewsGrid" aria-label="Berita lainnya">
            </div>
        </div>
    </section>
</main>
@endsection