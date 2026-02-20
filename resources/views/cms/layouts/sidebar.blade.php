<aside class="side">
    <div class="brand">
      <div class="logoDot" aria-hidden="true"></div>
      <div>
        <div class="brandTitle">CMS Panel</div>
        <div class="brandSub">© 2026 DB Panel</div>
      </div>
    </div>

<div class="nav" role="navigation" aria-label="Sections">

    <a href="{{ route('hero.index') }}" class="navBtn <?= $page === 'hero' ? 'active' : '' ?>">
      <span>Hero</span>
      <span class="navMeta"><span class="pill">Text + Image</span></span>
    </a>

    <a href="{{ route('big_news.index') }}" class="navBtn <?= $page === 'big-news' ? 'active' : '' ?>">
      <span>Big News</span>
      <span class="navMeta"><span class="pill">3 items</span></span>
    </a>

    <a href="{{ route('kegiatan.index') }}" class="navBtn <?= $page === 'kegiatan' ? 'active' : '' ?>">
      <span>Kegiatan</span>
      <span class="navMeta"><span class="pill">6 items</span></span>
    </a>

    <a href="{{ route('sponsor.index') }}" class="navBtn <?= $page === 'sponsor' ? 'active' : '' ?>">
      <span>Sponsor</span>
      <span class="navMeta"><span class="pill">16 logos</span></span>
    </a>

    <a href="{{ route('about.index') }}" class="navBtn <?= $page === 'about' ? 'active' : '' ?>">
      <span>About</span>
      <span class="navMeta"><span class="pill">Sejarah / Visi / Organisasi</span></span>
    </a>

    <a href="{{ route('anggota.index') }}" class="navBtn <?= $page === 'anggota' ? 'active' : '' ?>">
      <span>Anggota</span>
      <span class="navMeta"><span class="pill">Logo + Detail</span></span>
    </a>

    <a href="{{ route('program-kerja.index') }}" class="navBtn <?= $page === 'program-kerja' ? 'active' : '' ?>">
      <span>Program Kerja</span>
      <span class="navMeta"><span class="pill">Foto & Detail</span></span>
    </a>

    <a href="{{ route('news-content.index') }}" class="navBtn <?= $page === 'news-content' ? 'active' : '' ?>">
      <span>News Content</span>
      <span class="navMeta"><span class="pill">News + Shorts</span></span>
    </a>

    <a href="{{ route('event.index') }}" class="navBtn <?= $page === 'event' ? 'active' : '' ?>">
      <span>Event</span>
      <span class="navMeta"><span class="pill">Events + Header</span></span>
    </a>


    <a href="{{ route('profile.index') }}" class="navBtn <?= $page === 'profile' ? 'active' : '' ?>">
      <span>Profile</span>
      <span class="navMeta"><span class="pill">Header + Slider + Clubs</span></span>
    </a>

    <a href="{{ route('gallery.index') }}" class="navBtn <?= $page === 'gallery' ? 'active' : '' ?>">
      <span>Gallery</span>
      <span class="navMeta"><span class="pill">10 items × 10 photos</span></span>
    </a>

    <a href="{{ route('archives.index') }}" class="navBtn <?= $page === 'archives' ? 'active' : '' ?>">
      <span>Archives</span>
      <span class="navMeta"><span class="pill">Accordion + PDF links</span></span>
    </a>

</div>


    <div class="sideFoot">
      <a class="btn" href="logout.php">Logout</a>
      <a class="btn" href="/" target="_blank" rel="noopener">Open Site</a>
    </div>
  </aside>