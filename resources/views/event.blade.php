@extends('layouts.app')
@section('content')
<main class="page">
    <!-- ===================== EVENT PAGE HEADER (ABTI JABAR) ===================== -->
    <section class="page-header" id="eventHeader" aria-label="Event page header">
        <div class="page-header__inner">
            <h1 class="page-header__title">
                <span class="page-header__title-black">Event dan Kejuaraan</span>
                <span class="page-header__title-red">ABTI Jawa Barat</span>
            </h1>
            <p class="page-header__subtitle">
                Informasi resmi dan terkini mengenai berbagai event dan kejuaraan olahraga bola tangan di wilayah
                Jawa Barat.
            </p>
        </div>
    </section>
    <section class="events" id="events">
        <div class="events__container">
            <div class="events__tools anim-in" id="eventsTools">
                <div class="events__search">
                    <span class="events__searchIcon" aria-hidden="true"></span>
                    <input type="text" id="eventSearch" class="events__searchInput" placeholder="Search event..."
                        aria-label="Search event" />
                </div>
                <div class="events__filters" role="group" aria-label="Category filters">
                    <button class="chip is-active" type="button" data-filter="ALL">All</button>
                    <button class="chip" type="button" data-filter="INDOOR">Indoor</button>
                    <button class="chip" type="button" data-filter="BEACH">Beach</button>
                    <button class="chip" type="button" data-filter="WHEELCHAIR">Wheelchair</button>
                </div>
            </div>
            <div class="events__grid" id="eventsGrid" aria-label="Event list">
            </div>
            <div class="events__pager anim-in" id="eventsPager" aria-label="Pagination">
                <button class="pager-btn" id="prevBtn" type="button" aria-label="Previous page">
                    <span aria-hidden="true">‹</span> Prev
                </button>
                <div class="pager-info" aria-live="polite">
                    <span id="pagerCount">0</span>
                </div>
                <button class="pager-btn" id="nextBtn" type="button" aria-label="Next page">
                    Next <span aria-hidden="true">›</span>
                </button>
            </div>
        </div>
        <div class="modal" id="eventModal" aria-hidden="true" role="dialog" aria-modal="true"
            aria-labelledby="modalTitle">
            <div class="modal__backdrop" data-ev-close></div>
            <div class="modal__panel" role="document">
                <button class="modal__close" type="button" data-ev-close aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <div class="modal__header">
                    <div class="modal__logoWrap">
                        <img class="modal__logo" id="modalLogo" alt="" />
                    </div>
                    <div class="modal__titleWrap">
                        <h3 class="modal__title" id="modalTitle">Nama Event</h3>
                        <div class="modal__badges" id="modalBadges"></div>
                    </div>
                </div>
                <div class="modal__divider"></div>
                <div class="modal__body" id="modalBody">
                </div>
                <div class="modal__footer">
                    <a class="btn-ghost" href="#" target="_blank" rel="noopener noreferrer" id="modalWebsite">
                        Website
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection