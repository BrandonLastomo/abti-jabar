<!-- ================= NAVBAR ================= -->
  <header class="navWrap" data-navbar>
    <nav class="nav" aria-label="Primary">
      <a class="brand" href="{{ route('home') }}">ABTI jawa Barat</a>
      <ul class="menu" role="menubar">
        <li class="item">
          <a class="link" href="{{ route('home') }}" data-scroll>Beranda</a>
        </li>
        <li class="item dd" data-dd>
          <button class="ddBtn" type="button" aria-expanded="false">
            Tentang Kami <span class="caret" aria-hidden="true"></span>
          </button>
          <div class="ddPanel" role="menu">
            <a class="ddLink" href="{{ route('about') }}#aboutShell" data-scroll role="menuitem">Sejarah</a>
            <a class="ddLink" href="{{ route('about') }}#aboutShell" data-scroll role="menuitem">Visi &amp; Misi</a>
            <a class="ddLink" href="{{ route('about') }}#aboutShell" data-scroll role="menuitem">Organisasi</a>
            <a class="ddLink" href="{{ route('about') }}#members" data-scroll role="menuitem">Member ABTI</a>
            <a class="ddLink" href="{{ route('about') }}#program-kerja" data-scroll role="menuitem">Program Kerja</a>
          </div>
        </li>
        <li class="item dd" data-dd>
          <button class="ddBtn" type="button" aria-expanded="false">
            West Java Corner <span class="caret" aria-hidden="true"></span>
          </button>
          <div class="ddPanel" role="menu">
            <a class="ddLink" href="{{ route('west-java-corner') }}#podcastSection" data-scroll role="menuitem">Podcast</a>
            <a class="ddLink" href="{{ route('west-java-corner') }}#newsVideoSection" data-scroll role="menuitem">Berita Terbaru</a>
            <a class="ddLink" href="{{ route('west-java-corner') }}#envReels" data-scroll role="menuitem">Cuplikan</a>
          </div>
        </li>
        <li class="item">
          <a class="link" href="{{ route('event') }}" data-scroll>Event</a>
        </li>
        <li class="item">
          <a class="link" href="{{ route('database') }}" data-scroll>Database</a>
        </li>
        <li class="item dd" data-dd>
          <button class="ddBtn" type="button" aria-expanded="false">
            Profile <span class="caret" aria-hidden="true"></span>
          </button>
          <div class="ddPanel" role="menu">
            <a class="ddLink" href="{{ route('profile') }}#indoor" data-scroll role="menuitem">Tim Indoor</a>
            <a class="ddLink" href="{{ route('profile') }}#beach" data-scroll role="menuitem">Tim Beach</a>
            <a class="ddLink" href="{{ route('profile') }}#clubs" data-scroll role="menuitem">Klub</a>
          </div>
        </li>
        <li class="item">
          <a class="link" href="{{ route('gallery') }}" data-scroll>Gallery</a>
        </li>
        <li class="item">
          <a class="link" href="{{ route('archives') }}" data-scroll>Archives</a>
        </li>
      </ul>
      <button class="burger" type="button" aria-label="Open menu" aria-expanded="false" data-burger>
        <span class="burgerLines" aria-hidden="true"></span>
      </button>
    </nav>
  </header>
  <!-- ================= MOBILE MENU ================= -->
  <div class="mOverlay" data-moverlay aria-hidden="true">
    <div class="mBackdrop" data-close></div>
    <aside class="mDrawer" role="dialog" aria-modal="true" aria-label="Mobile menu">
      <div class="mTop">
        <div class="mBrand">ABTI JABAR</div>
        <button class="mClose" type="button" aria-label="Close menu" data-close>
          <span aria-hidden="true">✕</span>
        </button>
      </div>
      <div class="mBody">
        <a class="mLink" href="index.html#beranda" data-scroll data-close>Beranda</a>
        <div class="mGroup" data-mdd>
          <button class="mDD" type="button" aria-expanded="false">
            Tentang Kami <span class="caret" aria-hidden="true"></span>
          </button>
          <div class="mPanel">
            <a class="mSublink" href="{{ route('about') }}#aboutShell" data-scroll data-close>Sejarah</a>
            <a class="mSublink" href="{{ route('about') }}#aboutShell" data-scroll data-close>Visi &amp; Misi</a>
            <a class="mSublink" href="{{ route('about') }}#aboutShell" data-scroll data-close>Organisasi</a>
            <a class="mSublink" href="{{ route('about') }}#members" data-scroll data-close>Member ABTI</a>
            <a class="mSublink" href="{{ route('about') }}#program-kerja" data-scroll data-close>Program Kerja</a>
          </div>
        </div>
        <div class="mGroup" data-mdd>
          <button class="mDD" type="button" aria-expanded="false">
            West Java Corner <span class="caret" aria-hidden="true"></span>
          </button>
          <div class="mPanel">
            <a class="mSublink" href="{{ route('west-java-corner') }}#podcastSection" data-scroll data-close>Podcast</a>
            <a class="mSublink" href="{{ route('west-java-corner') }}#newsVideoSection" data-scroll data-close>Berita Terbaru</a>
            <a class="mSublink" href="{{ route('west-java-corner') }}#envReels" data-scroll data-close>Cuplikan</a>
          </div>
        </div>
        <a class="mLink" href="{{ route('event') }}" data-scroll data-close>Event</a>
        <a class="mLink" href="{{ route('database') }}" data-scroll data-close>Database</a>
        <div class="mGroup" data-mdd>
          <button class="mDD" type="button" aria-expanded="false">
            Profile <span class="caret" aria-hidden="true"></span>
          </button>
          <div class="mPanel">
            <a class="mSublink" href="{{ route('profile') }}#indoor" data-scroll data-close>Tim Indoor</a>
            <a class="mSublink" href="{{ route('profile') }}#beach" data-scroll data-close>Tim Beach</a>
            <a class="mSublink" href="{{ route('profile') }}#clubs" data-scroll data-close>Klub</a>
          </div>
        </div>
        <a class="mLink" href="{{ route('gallery') }}" data-scroll data-close>Gallery</a>
        <a class="mLink" href="{{ route('archives') }}" data-scroll data-close>Archives</a>
      </div>
    </aside>
  </div>