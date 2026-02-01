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