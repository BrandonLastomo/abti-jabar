@extends('layouts.app')
@section('content')
  <main class="page">
    <!-- ===================== PROFILE PAGE HEADER (ABTI JABAR) ===================== -->
    <section class="page-header" id="clubsHeader" aria-label="Event page header">
      <div class="page-header__inner">
        <h1 class="page-header__title">
          <span class="page-header__title-black">Database Klub</span>
          <span class="page-header__title-red">ABTI Jawa Barat</span>
        </h1>
        <p class="page-header__subtitle">
          Daftar resmi klub indoor dan beach yang terdaftar di bawah naungan ABTI Jawa Barat.
        </p>
      </div>
    </section>
    <section id="profile" class="profile">
      <div class="profile__container">
        <header class="profile__head">
          <article class="card">
            <div class="card__head">
              <div>
                <h3 class="card__title">Indoor Team</h3>
                <p class="card__desc">Gallery Team Indoor.</p>
              </div>
              <div class="pill">INDOOR</div>
            </div>
            <div class="hero" data-hero="indoor" aria-label="Indoor team hero slider">
              <div class="hero__viewport">
                <div class="hero__track" data-hero-track></div>
              </div>
              <div class="hero__ui">
                <div class="hero__dots" data-hero-dots aria-label="Hero pagination"></div>
              </div>
            </div>
          </article>
          <article class="card">
            <div class="card__head">
              <div>
                <h3 class="card__title">Beach Team</h3>
                <p class="card__desc">Gallery Team Indoor.</p>
              </div>
              <div class="pill pill--sec">BEACH</div>
            </div>
            <div class="hero" data-hero="beach" aria-label="Beach team hero slider">
              <div class="hero__viewport">
                <div class="hero__track" data-hero-track></div>
              </div>
              <div class="hero__ui">
                <div class="hero__dots" data-hero-dots aria-label="Hero pagination"></div>
              </div>
            </div>
          </article>
          <article class="card card--clubs">
            <div class="card__head card__head--clubs">
              <div>
                <h3 class="card__title">Clubs</h3>
                <p class="card__desc">Ditampilkan: logo, nama, asal kota/kab. Klik untuk detail di drawer.</p>
              </div>
              <div class="clubsTools">
                <label class="search">
                  <span class="srOnly"></span>
                  <input type="search" placeholder="Cari klub..." data-club-search />
                </label>
                <div class="cselect" data-city-select>
                  <button class="cselect__btn" type="button" data-city-btn aria-haspopup="listbox"
                    aria-expanded="false">
                    <span class="cselect__label" data-city-label>Semua kota/kab.</span>
                    <span class="cselect__chev" aria-hidden="true">▾</span>
                  </button>
                  <div class="cselect__panel" data-city-panel role="listbox" aria-label="Filter kota/kab.">
                  </div>
                </div>
              </div>
            </div>
            <div class="clubsGrid" data-clubs-grid></div>
            <nav class="pager" aria-label="Clubs pagination" data-clubs-pager>
              <button class="pager__btn" type="button" data-page-prev aria-label="Previous page">‹</button>
              <div class="pager__nums" data-page-nums></div>
              <button class="pager__btn" type="button" data-page-next aria-label="Next page">›</button>
            </nav>
            <div class="drawer" data-drawer aria-hidden="true">
              <div class="drawer__backdrop" data-drawer-close></div>
              <aside class="drawer__panel" role="dialog" aria-modal="true" aria-label="Club details">
                <header class="drawer__head">
                  <div class="drawer__title">
                    <img class="drawer__logo" alt="" data-drawer-logo />
                    <div class="drawer__titleText">
                      <h4 class="drawer__name" data-drawer-name>Nama Klub</h4>
                      <p class="drawer__city" data-drawer-city>Asal</p>
                    </div>
                  </div>
                  <button class="drawer__close" type="button" aria-label="Close" data-drawer-close>✕</button>
                </header>
                <div class="drawer__body">
                  <dl class="details">
                    <div class="details__row">
                      <dt>Direktur Klub</dt>
                      <dd data-drawer-director>-</dd>
                    </div>
                    <div class="details__row">
                      <dt>Administrator</dt>
                      <dd data-drawer-admin>-</dd>
                    </div>
                    <div class="details__row">
                      <dt>Direktur Teknik</dt>
                      <dd data-drawer-tech>-</dd>
                    </div>
                    <div class="details__row">
                      <dt>Venue Latihan</dt>
                      <dd data-drawer-venue>-</dd>
                    </div>
                    <div class="details__row">
                      <dt>E-mail</dt>
                      <dd><a href="#" data-drawer-email>-</a></dd>
                    </div>
                    <div class="details__row">
                      <dt>Contact Person</dt>
                      <dd data-drawer-contact>-</dd>
                    </div>
                    <div class="details__row">
                      <dt>Link</dt>
                      <dd><a href="#" target="_blank" rel="noopener" data-drawer-link>-</a></dd>
                    </div>
                  </dl>
                </div>
              </aside>
            </div>
          </article>
      </div>
    </section>
  </main>
@endsection