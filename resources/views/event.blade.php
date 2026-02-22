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
            <div class="events__grid" id="ballEventsGrid">

@foreach($events as $event)
    <div class="event-card"
         data-id="{{ $event->id }}"
         data-name="{{ $event->name }}"
         data-category="{{ strtoupper($event->category) }}"
         data-location="{{ $event->loc }}"
         data-athletes="{{ $event->athletes }}"
         data-coaches="{{ $event->coaches }}"
         data-teams="{{ $event->teams }}"
         data-management="{{ $event->management }}"
         data-audience="{{ $event->audience_offline }}"
         data-website="{{ $event->website }}"
         data-admin="{{ $event->administrator }}"
         data-logo="{{ $event->logo ? asset('storage/'.$event->logo) : '' }}"
         data-cover="{{ $event->cover ? asset('storage/'.$event->cover) : '' }}"
    >

        <div class="event-card__media">
            <img src="{{ $event->cover ? asset('storage/'.$event->cover) : 'https://via.placeholder.com/600x350' }}"
                 alt="{{ $event->name }}">
        </div>

        <div class="event-card__body">
            <div class="event-card__head">
                <div class="event-card__logoWrap">
                <img class="event-card__logo"
                     src="{{ $event->logo ? asset('storage/'.$event->logo) : 'https://via.placeholder.com/80' }}"
                     alt="">
                </div>
                <div class="event-card__titleWrap">
                  <h3>{{ $event->name }}</h3>
                </div>
            </div>

            <div class="event-card__metaRow">
                <div class="event-card__loc">
                  <span class="icon icon--pin" aria-hidden="true"></span>
                  <span class="event-card__locText">{{ $event->loc }}</span>
                </div>
                <span class="pill">{{ strtoupper($event->category) }}</span>
            </div>

            <button class="btn-primary open-modal">
                Detail Event
            </button>
        </div>

    </div>
@endforeach

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
<script>
document.querySelectorAll('.open-modal').forEach(btn => {
    btn.addEventListener('click', function() {

        const card = this.closest('.event-card');

        document.getElementById('modalTitle').innerText = card.dataset.name;
        document.getElementById('modalLogo').src = card.dataset.logo;

        document.getElementById('modalWebsite').href = card.dataset.website;

        document.getElementById('modalBadges').innerHTML =
            `<span class="badge">${card.dataset.category}</span>`;

        document.getElementById('modalBody').innerHTML = `
    <div class="modal-info">

        <div class="modal-info__item">
            <span class="modal-info__icon">📍</span>
            <div>
                <div class="modal-info__label">Lokasi</div>
                <div class="modal-info__value">${card.dataset.location || '-'}</div>
            </div>
        </div>

        <div class="modal-info__item">
            <span class="modal-info__icon">👥</span>
            <div>
                <div class="modal-info__label">Jumlah Atlet</div>
                <div class="modal-info__value">${card.dataset.athletes || 0} atlet</div>
            </div>
        </div>

        <div class="modal-info__item">
            <span class="modal-info__icon">🏃</span>
            <div>
                <div class="modal-info__label">Jumlah Pelatih</div>
                <div class="modal-info__value">${card.dataset.coaches || 0} pelatih</div>
            </div>
        </div>

        <div class="modal-info__item">
            <span class="modal-info__icon">👥</span>
            <div>
                <div class="modal-info__label">Jumlah Tim</div>
                <div class="modal-info__value">${card.dataset.teams || 0} tim</div>
            </div>
        </div>

        <div class="modal-info__item">
            <span class="modal-info__icon">🗂</span>
            <div>
                <div class="modal-info__label">Tim Manajemen</div>
                <div class="modal-info__value">${card.dataset.management || 0} orang</div>
            </div>
        </div>

        <div class="modal-info__item">
            <span class="modal-info__icon">👁</span>
            <div>
                <div class="modal-info__label">Penonton Offline per Hari</div>
                <div class="modal-info__value">${card.dataset.audience || 0} orang</div>
            </div>
        </div>

        <div class="modal-info__item">
            <span class="modal-info__icon">🌐</span>
            <div>
                <div class="modal-info__label">Website</div>
                <div class="modal-info__value">
                    <a href="${card.dataset.website}" target="_blank">
                        ${card.dataset.website}
                    </a>
                </div>
            </div>
        </div>

        <div class="modal-info__item">
            <span class="modal-info__icon">⚙</span>
            <div>
                <div class="modal-info__label">Administrator</div>
                <div class="modal-info__value">${card.dataset.admin || '-'}</div>
            </div>
        </div>

    </div>
`;

        document.getElementById('eventModal').classList.add('is-open');
    });
});

document.querySelectorAll('[data-ev-close]').forEach(el => {
    el.addEventListener('click', function(){
        document.getElementById('eventModal').classList.remove('is-open');
    });
});
</script>
@endsection