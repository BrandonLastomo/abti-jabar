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
          <div class="acc-item">
            <button class="acc-trigger" type="button" aria-expanded="false" aria-controls="acc-panel-mutation"
              id="acc-trigger-mutation">
              <span class="acc-title">Mutation Regulation</span>
              <span class="acc-meta">3 dokumen</span>
              <span class="acc-icon" aria-hidden="true"></span>
            </button>
            <div class="acc-panel" id="acc-panel-mutation" role="region" aria-labelledby="acc-trigger-mutation" hidden>
              <ul class="doc-list">
                <li class="doc-item">
                  <div class="doc-main">
                    <span class="doc-name">Ketentuan Mutasi Atlet ABTI Jawa Barat</span>
                  </div>
                  <a class="doc-download" href="./pdf/mutation-regulation-2024.pdf" download>
                    Download PDF
                  </a>
                </li>
                <li class="doc-item">
                  <div class="doc-main">
                    <span class="doc-name">Prosedur Administrasi Mutasi Klub</span>
                  </div>
                  <a class="doc-download" href="./pdf/mutation-procedure-2023.pdf" download>
                    Download PDF
                  </a>
                </li>
                <li class="doc-item">
                  <div class="doc-main">
                    <span class="doc-name">Panduan Verifikasi & Validasi Mutasi</span>
                  </div>
                  <a class="doc-download" href="./pdf/mutation-verification-2022.pdf" download>
                    Download PDF
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="acc-item">
            <button class="acc-trigger" type="button" aria-expanded="false" aria-controls="acc-panel-club"
              id="acc-trigger-club">
              <span class="acc-title">Club Regulation</span>
              <span class="acc-meta">3 dokumen</span>
              <span class="acc-icon" aria-hidden="true"></span>
            </button>
            <div class="acc-panel" id="acc-panel-club" role="region" aria-labelledby="acc-trigger-club" hidden>
              <ul class="doc-list">
                <li class="doc-item">
                  <div class="doc-main">
                    <span class="doc-name">Standar Registrasi Klub ABTI Jawa Barat</span>
                  </div>
                  <a class="doc-download" href="./pdf/club-registration-2025.pdf" download>
                    Download PDF
                  </a>
                </li>
                <li class="doc-item">
                  <div class="doc-main">
                    <span class="doc-name">Tata Kelola Klub & Kepengurusan</span>
                  </div>
                  <a class="doc-download" href="./pdf/club-governance-2024.pdf" download>
                    Download PDF
                  </a>
                </li>
                <li class="doc-item">
                  <div class="doc-main">
                    <span class="doc-name">Kode Etik Klub & Anggota</span>
                  </div>
                  <a class="doc-download" href="./pdf/club-code-of-conduct-2023.pdf" download>
                    Download PDF
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="acc-item">
            <button class="acc-trigger" type="button" aria-expanded="false" aria-controls="acc-panel-event"
              id="acc-trigger-event">
              <span class="acc-title">Event Regulation</span>
              <span class="acc-meta">3 dokumen</span>
              <span class="acc-icon" aria-hidden="true"></span>
            </button>
            <div class="acc-panel" id="acc-panel-event" role="region" aria-labelledby="acc-trigger-event" hidden>
              <ul class="doc-list">
                <li class="doc-item">
                  <div class="doc-main">
                    <span class="doc-name">Pedoman Penyelenggaraan Kejuaraan ABTI Jawa Barat</span>
                  </div>
                  <a class="doc-download" href="./pdf/event-guidelines-2025.pdf" download>
                    Download PDF
                  </a>
                </li>
                <li class="doc-item">
                  <div class="doc-main">
                    <span class="doc-name">Peraturan Teknis Pertandingan (Technical Handbook)</span>
                  </div>
                  <a class="doc-download" href="./pdf/event-technical-handbook-2024.pdf" download>
                    Download PDF
                  </a>
                </li>
                <li class="doc-item">
                  <div class="doc-main">
                    <span class="doc-name">Ketentuan Pendaftaran & Eligibility Peserta</span>
                  </div>
                  <a class="doc-download" href="./pdf/event-eligibility-2023.pdf" download>
                    Download PDF
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="acc-item">
            <button class="acc-trigger" type="button" aria-expanded="false" aria-controls="acc-panel-sanction"
              id="acc-trigger-sanction">
              <span class="acc-title">Sanction Regulation</span>
              <span class="acc-meta">3 dokumen</span>
              <span class="acc-icon" aria-hidden="true"></span>
            </button>
            <div class="acc-panel" id="acc-panel-sanction" role="region" aria-labelledby="acc-trigger-sanction" hidden>
              <ul class="doc-list">
                <li class="doc-item">
                  <div class="doc-main">
                    <span class="doc-name">Kode Disiplin & Sanksi Kejuaraan</span>
                  </div>
                  <a class="doc-download" href="./pdf/sanction-code-2025.pdf" download>
                    Download PDF
                  </a>
                </li>
                <li class="doc-item">
                  <div class="doc-main">
                    <span class="doc-name">Mekanisme Sidang & Banding</span>
                  </div>
                  <a class="doc-download" href="./pdf/sanction-appeal-2024.pdf" download>
                    Download PDF
                  </a>
                </li>
                <li class="doc-item">
                  <div class="doc-main">
                    <span class="doc-name">Daftar Pelanggaran & Skema Penalti</span>
                  </div>
                  <a class="doc-download" href="./pdf/sanction-penalties-2023.pdf" download>
                    Download PDF
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="acc-item">
            <button class="acc-trigger" type="button" aria-expanded="false" aria-controls="acc-panel-statutes"
              id="acc-trigger-statutes">
              <span class="acc-title">Statutes &amp; Regulation</span>
              <span class="acc-meta">3 dokumen</span>
              <span class="acc-icon" aria-hidden="true"></span>
            </button>
            <div class="acc-panel" id="acc-panel-statutes" role="region" aria-labelledby="acc-trigger-statutes" hidden>
              <ul class="doc-list">
                <li class="doc-item">
                  <div class="doc-main">
                    <span class="doc-name">Anggaran Dasar (AD) ABTI Jawa Barat</span>
                  </div>
                  <a class="doc-download" href="./pdf/statutes-ad-2025.pdf" download>
                    Download PDF
                  </a>
                </li>
                <li class="doc-item">
                  <div class="doc-main">
                    <span class="doc-name">Anggaran Rumah Tangga (ART) ABTI Jawa Barat</span>
                  </div>
                  <a class="doc-download" href="./pdf/statutes-art-2025.pdf" download>
                    Download PDF
                  </a>
                </li>
                <li class="doc-item">
                  <div class="doc-main">
                    <span class="doc-name">Peraturan Organisasi & Ketentuan Umum</span>
                  </div>
                  <a class="doc-download" href="./pdf/organization-regulation-2024.pdf" download>
                    Download PDF
                  </a>
                </li>
              </ul>
            </div>
          </div>
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