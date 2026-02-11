@extends('layouts.app')
@section('content')
  <main class="page">
    <!-- ========================= HERO ========================= -->
    <section class="hero" id="beranda">
      <div class="heroWrap">
        <div class="heroText">
          <h1 class="heroTitle">
            <span class="heroKicker" id="heroKicker"></span>
            <span class="heroBig" id="heroBig"></span>
          </h1>
          <p class="heroDesc" id="heroDesc">
            Wadah pembinaan, kompetisi, dan<br />
            pengembangan bola tangan di <span class="heroEm">Jawa Barat</span>
          </p>
          <a class="heroBtn" href="{{ route('event') }}" data-scroll>
            <span>Lihat Event</span>
            <span class="heroBtnIcon" aria-hidden="true">→</span>
          </a>
        </div>
        <div class="heroMedia">
          <picture class="heroimg">
            <source id="heroImgMobile" media="(max-width: 980px)" srcset="{{ asset('img/sechero.png') }}">
            <img id="heroImgDesktop" src="{{ asset('img/mainhero.png') }}" alt="ABTI JAWA BARAT" />
          </picture>
        </div>
      </div>
    </section>

<section class="livestream-section">
    <h2 class="section-heading">PAST LIVESTREAMS</h2>

    <div class="marquee-container" id="marqueeContainer">
        <div class="marquee-track" id="marqueeTrack">

            <a href="#" class="card-link">
                <div class="image-wrapper">
                    <img src="https://i.ytimg.com/vi/3yWd2qK4k7k/maxresdefault.jpg" alt="Beach Handball">
                    <div class="overlay-title">BEACH HANDBALL: WHEN THE SAND RULES</div>
                </div>
                <div class="card-sub-title">Rangkuman Momen Tak Terduga di Beach Handball</div>
            </a>

            <a href="#" class="card-link">
                <div class="image-wrapper">
                    <img src="https://www.ihf.info/sites/default/files/2019-07/Nycke%20Groot_0.jpg" alt="Nycke Groot">
                    <div class="overlay-title">NYCKE GROOT HER BEST ACTIONS</div>
                </div>
                <div class="card-sub-title">NYCKE GROOT dan Perspektif Handball</div>
            </a>

            <a href="#" class="card-link">
                <div class="image-wrapper">
                    <img src="https://editorial01.shutterstock.com/wm-preview-1500/13978383a/63622158/shutterstock_editorial_13978383a.jpg" alt="Top Assists">
                    <div class="overlay-title">TOP ASSISTS FROM NORA MORK</div>
                </div>
                <div class="card-sub-title">Nora Mørk: Assist Terbaik</div>
            </a>

            <a href="#" class="card-link">
                <div class="image-wrapper">
                    <img src="https://i.ytimg.com/vi/7_V_w6k2w-0/maxresdefault.jpg" alt="Spain vs Germany">
                    <div class="overlay-title">SPAIN VS GERMANY PENALTY SHOOT-OUT!</div>
                </div>
                <div class="card-sub-title">Spanyol vs Jerman: Adu Penalti</div>
            </a>

             <a href="#" class="card-link">
                <div class="image-wrapper">
                    <img src="https://www.ihf.info/sites/default/files/styles/news_main/public/2024-08/DEN_2569.jpg?itok=zQ74Wj4_" alt="World Games">
                    <div class="overlay-title">THE WORLD GAMES 2025</div>
                </div>
                <div class="card-sub-title">Handball | The World Games 2025</div>
            </a>

        </div>
    </div>
</section>

    <!-- ===================== YOUTUBE ===================== -->
    <section class="ytStrip" id="highlights">
      <div class="ytHead">
        <h2 class="ytTitle">EXTENDED HIGHLIGHTS</h2>
      </div>
      <div class="ytMarquee" aria-label="YouTube highlights">
        <div class="ytTrack" data-yt-track>
        </div>
      </div>
    </section>
    <!-- ===================== BERITA TERBARU (BIG SLIDER) ===================== -->
    <div class="bigNewsSectionBg">
      <section class="bigNews">
        <div class="bigNewsViewport" id="bigNewsViewport">
          <div class="bigNewsTrack" id="bigNewsTrack"></div>
        </div>
        <div class="bigNewsDots" id="bigNewsDots" aria-hidden="true"></div>
      </section>
      <section class="actStrip">
        <div class="actHead">
          <h2 class="actTitle">Kegiatan Terbaru</h2>
        </div>
        <div class="actWrap">
          <button class="actArrow left" type="button" id="actPrev" aria-label="Prev">‹</button>
          <button class="actArrow right" type="button" id="actNext" aria-label="Next">›</button>
          <div class="actViewport" id="actViewport">
            <div class="actTrack" id="actTrack"></div>
          </div>
        </div>
      </section>
    </div>
    <section class="stats" id="stats">
      <div class="statsWrap">
        <div class="statsGrid" id="statsGrid">
          <div class="statsGridLabel">Data Keanggotaan</div>
          <article class="statCard stat-clubs" data-target="12721" data-icon="clubs">
            <div class="statBadge" aria-hidden="true">
              <span class="statSvg" data-icon="clubs"></span>
            </div>
            <div class="statValue">0</div>
            <div class="statLabel">KLUB</div>
          </article>
          <article class="statCard stat-school" data-target="21000" data-icon="school_clubs">
            <div class="statBadge" aria-hidden="true">
              <span class="statSvg" data-icon="school_clubs"></span>
            </div>
            <div class="statValue">0</div>
            <div class="statLabel">KLUB SEKOLAH</div>
          </article>
          <article class="statCard stat-university" data-target="521302" data-icon="university_clubs">
            <div class="statBadge" aria-hidden="true">
              <span class="statSvg" data-icon="university_clubs"></span>
            </div>
            <div class="statValue">0</div>
            <div class="statLabel">KLUB UNIVERSITAS</div>
          </article>
          <article class="statCard stat-atlet" data-target="70" data-icon="atlet">
            <div class="statBadge" aria-hidden="true">
              <span class="statSvg" data-icon="atlet"></span>
            </div>
            <div class="statValue">0</div>
            <div class="statLabel">ATLET</div>
          </article>
          <article class="statCard stat-wasit" data-target="1000" data-icon="wasit">
            <div class="statBadge" aria-hidden="true">
              <span class="statSvg" data-icon="wasit"></span>
            </div>
            <div class="statValue">0</div>
            <div class="statLabel">WASIT</div>
          </article>
          <article class="statCard stat-pelatih" data-target="1000" data-icon="pelatih">
            <div class="statBadge" aria-hidden="true">
              <span class="statSvg" data-icon="pelatih"></span>
            </div>
            <div class="statValue">0</div>
            <div class="statLabel">PELATIH</div>
          </article>
          <article class="statCard stat-gk" data-target="1000" data-icon="pelatih_gk">
            <div class="statBadge" aria-hidden="true">
              <span class="statSvg" data-icon="pelatih_gk"></span>
            </div>
            <div class="statValue">0</div>
            <div class="statLabel">PELATIH GK</div>
          </article>
          <article class="statCard stat-td" data-target="1000" data-icon="technical_director">
            <div class="statBadge" aria-hidden="true">
              <span class="statSvg" data-icon="technical_director"></span>
            </div>
            <div class="statValue">0</div>
            <div class="statLabel">DIREKTUR TEKNIS</div>
          </article>
          <article class="statCard stat-manajemen" data-target="1000" data-icon="tim_manajemen">
            <div class="statBadge" aria-hidden="true">
              <span class="statSvg" data-icon="tim_manajemen"></span>
            </div>
            <div class="statValue">0</div>
            <div class="statLabel">TIM MANAJEMEN</div>
          </article>
          <article class="statCard stat-match" data-target="1000" data-icon="match_official">
            <div class="statBadge" aria-hidden="true">
              <span class="statSvg" data-icon="match_official"></span>
            </div>
            <div class="statValue">0</div>
            <div class="statLabel">OFISIAL PERTANDINGAN</div>
          </article>
          <article class="statCard stat-delegates" data-target="1000" data-icon="technical_delegates">
            <div class="statBadge" aria-hidden="true">
              <span class="statSvg" data-icon="technical_delegates"></span>
            </div>
            <div class="statValue">0</div>
            <div class="statLabel">DELEGASI TEKNIS</div>
          </article>
          <article class="statCard stat-volunteer" data-target="1000" data-icon="volunteer">
            <div class="statBadge" aria-hidden="true">
              <span class="statSvg" data-icon="volunteer"></span>
            </div>
            <div class="statValue">0</div>
            <div class="statLabel">VOLUNTEER</div>
          </article>
        </div>
        <div class="statsToggle">
          <button id="statsToggleBtn" type="button">Lihat Semua</button>
        </div>
      </div>
    </section>
    <section class="sponsor-section" id="sponsors">
      <h2 class="sponsor-headline">Sponsor & Mitra Strategis</h2>
      <p class="sponsor-subheadline">Dukungan sponsor dan mitra turut memperkuat pembinaan serta prestasi atlet bola
        tangan Jawa Barat.</p>
      <div class="marquee marquee-right" data-marquee>
        <div class="marquee-track">
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
        </div>
      </div>
      <div class="marquee marquee-left" data-marquee>
        <div class="marquee-track">
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
          <div class="logo-card"><img src="{{ asset('img/logo1.png') }}" alt=""></div>
        </div>
      </div>
    </section>
  </main>
@endsection