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