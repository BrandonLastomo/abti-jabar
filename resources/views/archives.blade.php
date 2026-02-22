@extends('layouts.app')
@section('content')
  <main class="page">
    <section class="abti-archives" id="archives">
      <div class="archives-shell">
        <header class="archives-header">
          <p class="archives-eyebrow">ABTI Jawa Barat</p>
          <h1 class="archives-title">Archives</h1>
          <p class="archives-subtitle">
            Kumpulan dokumen regulasi resmi. Klik kategori untuk melihat daftar dokumen, lalu unduh file PDF.
          </p>
        </header>
        <div class="archives-accordion" data-accordion="abti-archives">
        @php
        $categories = [
            'Mutation Regulation',
            'Club Regulation',
            'Event Regulation',
            'Sanction Regulation',
            'Statutes & Regulation'
        ];
        @endphp

        @foreach($categories as $category)
            @php
                $docs = $archives[$category] ?? collect();
                $slug = \Str::slug($category);
            @endphp

            <div class="acc-item">
                <button class="acc-trigger"
                    type="button"
                    aria-expanded="false"
                    aria-controls="acc-panel-{{ $slug }}"
                    id="acc-trigger-{{ $slug }}">

                    <span class="acc-title">{{ $category }}</span>
                    <span class="acc-meta">{{ $docs->count() }} dokumen</span>
                    <span class="acc-icon" aria-hidden="true"></span>
                </button>

                <div class="acc-panel"
                    id="acc-panel-{{ $slug }}"
                    role="region"
                    aria-labelledby="acc-trigger-{{ $slug }}"
                    hidden>

                    @if($docs->count())
                        <ul class="doc-list">
                            @foreach($docs as $doc)
                                <li class="doc-item">
                                    <div class="doc-main">
                                        <span class="doc-name">
                                            {{ $doc->title }}
                                        </span>
                                    </div>

                                    <a class="doc-download"
                                      href="{{ asset('storage/' . $doc->file) }}"
                                      download>
                                        Download PDF
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p style="padding:15px;">Belum ada dokumen.</p>
                    @endif

                </div>
            </div>
        @endforeach

        </div>
        <footer class="archives-footer">
          <p class="archives-note">
            Catatan: Lihat detailnya melalui <code>PDF</code> yang dapat anda unduh.
          </p>
        </footer>
      </div>
    </section>
  </main>
@endsection