@extends('layouts.app')
@section('content')
  <main class="page">
    <section class="page-header" id="galleryHeader" aria-label="Event page header">
      <div class="page-header__inner">
        <h1 class="page-header__title">
          <span class="page-header__title-black">Galeri Kegiatan</span>
          <span class="page-header__title-red">ABTI Jawa Barat</span>
        </h1>
        <p class="page-header__subtitle">
          Ikuti perjalanan ABTI Jawa Barat melalui rangkaian dokumentasi event, kompetisi, dan pembinaan atlet.
        </p>
      </div>
    </section>
    @if ($galleries->isEmpty())
      <section class="ihf-section">
          <div class="ihf-shell">
              <div class="gallery-empty">
                  <div class="gallery-empty__icon">
                      📷
                  </div>
                  <h3 class="gallery-empty__title">
                      Belum Ada Galeri
                  </h3>
                  <p class="gallery-empty__desc">
                      Dokumentasi kegiatan dan event ABTI Jawa Barat akan ditampilkan di sini.
                  </p>
              </div>
          </div>
      </section>
    @else
    <section class="ihf-section" data-ihf-gallery>
      <div class="ihf-shell">
        <header class="ihf-head"></header>
        <div class="ihf-cardbar" aria-label="Event list">
          @if ($galleries->isNotEmpty())
              <button class="ihf-navbtn" type="button" data-card-prev aria-label="Previous events">‹</button>
          @endif
          <div class="ihf-cardtrack" data-card-track>
            @foreach($galleries as $gallery)
            <article class="ihf-card"
                tabindex="0"
                data-event-id="gallery-{{ $gallery->id }}"
                data-event-title="{{ $gallery->title }}"
                data-event-date="{{ $gallery->event_season }}"
                data-event-cover="{{ $gallery->cover ? asset('storage/'.$gallery->cover) : asset('images/placeholder.jpg') }}"
                data-event-images='@json(
                    $gallery->photos->map(function($photo){
                        return asset("storage/".$photo->photo_path);
                    })
                )'
            >

                <div class="ihf-cardimg">
                    <img
                        src="{{ $gallery->cover ? asset('storage/'.$gallery->cover) : asset('images/placeholder.jpg') }}"
                        alt="{{ $gallery->title }}"
                        loading="lazy"
                        decoding="async">
                </div>

                <div class="ihf-cardmeta">
                    <div class="ihf-cardtitle">
                        {{ $gallery->title }}
                    </div>
                    <div class="ihf-cardsub">
                        {{ $gallery->event_season }}
                    </div>
                </div>

            </article>
            @endforeach
          </div>
          @if ($galleries->isNotEmpty())
              <button class="ihf-navbtn" type="button" data-card-next aria-label="Next events">›</button>
          @endif
        </div>
        <!-- ===== GALLERY LIKE IHF ===== -->
        <div class="ihfGalleryIHF" data-gallery hidden>
          <div class="ihfGalleryIHF__head">
            <div>
              <h2 class="ihfGalleryIHF__title" data-gallery-title>GALERY EVENT</h2>
              <div class="ihfGalleryIHF__meta">
                <span class="ihfGalleryIHF__date" data-gallery-date>—</span>
                <span class="ihfGalleryIHF__dot">•</span>
                <span class="ihfGalleryIHF__pill">Photos</span>
              </div>
            </div>
            <button class="ihfGalleryIHF__ghost" type="button" data-gallery-close>Close</button>
          </div>
          <div class="ihfGalleryIHF__divider"></div>
          <div class="ihfGalleryIHF__viewer">
            <div class="ihfGalleryIHF__main">
              <figure class="ihfGalleryIHF__frame" aria-live="polite">
                <img class="ihfGalleryIHF__img" data-stage-img alt="" loading="lazy" decoding="async" />
                <div class="ihfGalleryIHF__load" data-stage-load>Loading…</div>
              </figure>
            </div>
            <div class="ihfGalleryIHF__thumbbar">
              <button class="ihfGalleryIHF__panel ihfGalleryIHF__panel--prev" type="button" data-stage-prev
                aria-label="Previous photo">
                <span class="ihfGalleryIHF__arrow" aria-hidden="true">‹</span>
              </button>
              <div class="ihfGalleryIHF__thumbtrack" data-thumbs></div>
              <button class="ihfGalleryIHF__panel ihfGalleryIHF__panel--next" type="button" data-stage-next
                aria-label="Next photo">
                <span class="ihfGalleryIHF__arrow" aria-hidden="true">›</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
    @endif
  </main>
@endsection