@php
    $footer = \App\Models\FooterContent::getAll();

    $logoSrc = optional($footer->get('logo'))->value;
    if ($logoSrc && str_starts_with($logoSrc, 'footer/')) {
        $logoSrc = asset('storage/' . $logoSrc);
    } elseif ($logoSrc) {
        $logoSrc = asset($logoSrc);
    } else {
        $logoSrc = asset('img/mainlogo.avif');
    }

    $orgName = optional($footer->get('org_name'))->value ?? 'ABTI Jawa Barat';
    $orgDesc = optional($footer->get('org_description'))->value ?? 'Asosiasi Bola Tangan Indonesia<br>Provinsi Jawa Barat';

    $col1Title = optional($footer->get('nav_col_1_title'))->value ?? 'Organisasi';
    $col1Links = json_decode(optional($footer->get('nav_col_1_links'))->value ?? '[]', true);

    $col2Title = optional($footer->get('nav_col_2_title'))->value ?? 'Informasi';
    $col2Links = json_decode(optional($footer->get('nav_col_2_links'))->value ?? '[]', true);

    $contactTitle = optional($footer->get('contact_title'))->value ?? 'Kontak';
    $contactEmail = optional($footer->get('contact_email'))->value ?? 'sekretariat@abtijabar.or.id';
    $contactPhone = optional($footer->get('contact_phone'))->value ?? '+62 22 0000 0000';
    $contactAddress = optional($footer->get('contact_address'))->value ?? 'Bandung, Jawa Barat';

    $copyright = optional($footer->get('copyright'))->value ?? '© 2026 Asosiasi Bola Tangan Indonesia – Provinsi Jawa Barat';
@endphp
<footer class="siteFooterFed" aria-labelledby="footerTitle">
      <div class="sffWrap">
        <div class="sffTop">
          <div class="sffBrand">
            <div class="sffLogoWrap">
              <img src="{{ $logoSrc }}" alt="Logo {{ $orgName }}" class="sffLogo" />
            </div>
            <div class="sffBrandText">
              <h3 id="footerTitle">{{ $orgName }}</h3>
              <p>{!! $orgDesc !!}</p>
            </div>
          </div>
          <nav class="sffNav" aria-label="Footer navigation">
            <div class="sffCol">
              <span class="sffTitle">{{ $col1Title }}</span>
              @foreach($col1Links as $link)
                <a href="{{ $link['url'] }}">{{ $link['text'] }}</a>
              @endforeach
            </div>
            <div class="sffCol">
              <span class="sffTitle">{{ $col2Title }}</span>
              @foreach($col2Links as $link)
                <a href="{{ $link['url'] }}">{{ $link['text'] }}</a>
              @endforeach
            </div>
            <div class="sffCol">
              <span class="sffTitle">{{ $contactTitle }}</span>
              <span>{{ $contactEmail }}</span>
              <span>{{ $contactPhone }}</span>
              <span>{{ $contactAddress }}</span>
            </div>
          </nav>
        </div>
        <div class="sffBottom">
          {{ $copyright }}
        </div>
      </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>