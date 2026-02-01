@extends('layouts.app')
@section('content')
  <main class="page">
    <section class="rds" id="rds">
      <header class="rds__head">
        <div>
          <h2>Resources Dashboard</h2>
          <p>Ringkasan SDM + tabel (siap integrasi spreadsheet).</p>
        </div>
      </header>
      <div class="rds__ov">
        <article class="rds__card" data-rds-card>
          <div class="rds__top">
            <div class="rds__title">Atlet</div>
            <span class="rds__chip">Core</span>
          </div>
          <div class="rds__value" data-rds-count="128">0</div>
          <div class="rds__meta">Atlet terdaftar aktif</div>
        </article>
        <article class="rds__card" data-rds-card>
          <div class="rds__top">
            <div class="rds__title">Coaching & Technical Staff</div>
            <span class="rds__chip">Teknis</span>
          </div>
          <div class="rds__value" data-rds-count="34">0</div>
          <div class="rds__meta">Pelatih + Pelatih GK + TD</div>
        </article>
        <article class="rds__card" data-rds-card>
          <div class="rds__top">
            <div class="rds__title">Match Officials</div>
            <span class="rds__chip">Regulasi</span>
          </div>
          <div class="rds__value" data-rds-count="22">0</div>
          <div class="rds__meta">Wasit + Delegates</div>
        </article>
        <article class="rds__card" data-rds-card>
          <div class="rds__top">
            <div class="rds__title">Management & Support</div>
            <span class="rds__chip">Ops</span>
          </div>
          <div class="rds__value" data-rds-count="60">0</div>
          <div class="rds__meta">Manajemen + Volunteer</div>
        </article>
      </div>
      <div class="rds__panel" data-rds-panel>
        <div class="rds__panelHead">
          <div>
            <h3>Detail Resources</h3>
            <p>8 tabel detail. UI ini tinggal diisi data spreadsheet nanti.</p>
          </div>
          <div class="rds__hint"><span class="rds__dot"></span> Realtime-update</div>
        </div>
        <div class="rdsTabs" role="tablist" aria-label="Resources tabs">
          <button class="rdsTab is-active" data-rds-tab="atlet" role="tab" aria-selected="true">Atlet</button>
          <button class="rdsTab" data-rds-tab="pelatih" role="tab" aria-selected="false">Pelatih</button>
          <button class="rdsTab" data-rds-tab="pelatihgk" role="tab" aria-selected="false">Pelatih GK</button>
          <button class="rdsTab" data-rds-tab="td" role="tab" aria-selected="false">Technical Director</button>
          <button class="rdsTab" data-rds-tab="manajemen" role="tab" aria-selected="false">Tim Manajemen</button>
          <button class="rdsTab" data-rds-tab="wasit" role="tab" aria-selected="false">Wasit</button>
          <button class="rdsTab" data-rds-tab="delegates" role="tab" aria-selected="false">Technical Delegates</button>
          <button class="rdsTab" data-rds-tab="volunteer" role="tab" aria-selected="false">Volunteer</button>
        </div>
        <div class="rdsStage">
          <section class="rdsPane is-active" data-rds-pane="atlet">
            <div class="rdsPane__top">
              <div>
                <div class="rdsPane__title">Atlet</div>
                <div class="rdsPane__meta">Tabel terintegrasi spreadsheet</div>
              </div>
              <button class="rdsOpenMobile" type="button" data-rds-open-table>
                Lihat Tabel
              </button>
            </div>
            <div class="rdsTableWrap">
              <table class="rdsTable rdsTable--3">
                <thead>
                  <tr>
                    <th>Wilayah</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Bandung</td>
                    <td>42</td>
                    <td><span class="rdsBadge ok">Aktif</span></td>
                  </tr>
                  <tr>
                    <td>Bekasi</td>
                    <td>31</td>
                    <td><span class="rdsBadge ok">Aktif</span></td>
                  </tr>
                  <tr>
                    <td>Bogor</td>
                    <td>9</td>
                    <td><span class="rdsBadge warn">Perlu Verifikasi</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </section>
          <section class="rdsPane" data-rds-pane="pelatih" hidden>
            <div class="rdsPane__top">
              <div>
                <div class="rdsPane__title">Pelatih</div>
                <div class="rdsPane__meta">Spreadsheet</div>
              </div>
              <button class="rdsOpenMobile" type="button" data-rds-open-table>Lihat Tabel</button>
            </div>
            <div class="rdsTableWrap">
              <table class="rdsTable rdsTable--3">
                <thead>
                  <tr>
                    <th>Wilayah</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Bandung</td>
                    <td>12</td>
                    <td><span class="rdsBadge ok">Aktif</span></td>
                  </tr>
                  <tr>
                    <td>Depok</td>
                    <td>7</td>
                    <td><span class="rdsBadge warn">Perlu Update</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </section>
          <section class="rdsPane" data-rds-pane="pelatihgk" hidden>
            <div class="rdsPane__top">
              <div>
                <div class="rdsPane__title">Pelatih GK</div>
                <div class="rdsPane__meta">Spreadsheet</div>
              </div>
              <button class="rdsOpenMobile" type="button" data-rds-open-table>Lihat Tabel</button>
            </div>
            <div class="rdsTableWrap">
              <table class="rdsTable rdsTable--3">
                <thead>
                  <tr>
                    <th>Wilayah</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Bandung</td>
                    <td>3</td>
                    <td><span class="rdsBadge ok">Aktif</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </section>
          <section class="rdsPane" data-rds-pane="td" hidden>
            <div class="rdsPane__top">
              <div>
                <div class="rdsPane__title">Technical Director</div>
                <div class="rdsPane__meta">Spreadsheet</div>
              </div>
              <button class="rdsOpenMobile" type="button" data-rds-open-table>Lihat Tabel</button>
            </div>
            <div class="rdsTableWrap">
              <table class="rdsTable rdsTable--3">
                <thead>
                  <tr>
                    <th>Wilayah</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Jawa Barat</td>
                    <td>1</td>
                    <td><span class="rdsBadge ok">Aktif</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </section>
          <section class="rdsPane" data-rds-pane="manajemen" hidden>
            <div class="rdsPane__top">
              <div>
                <div class="rdsPane__title">Tim Manajemen</div>
                <div class="rdsPane__meta">Spreadsheet</div>
              </div>
              <button class="rdsOpenMobile" type="button" data-rds-open-table>Lihat Tabel</button>
            </div>
            <div class="rdsTableWrap">
              <table class="rdsTable rdsTable--3">
                <thead>
                  <tr>
                    <th>Wilayah</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Bandung</td>
                    <td>10</td>
                    <td><span class="rdsBadge ok">Aktif</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </section>
          <section class="rdsPane" data-rds-pane="wasit" hidden>
            <div class="rdsPane__top">
              <div>
                <div class="rdsPane__title">Wasit</div>
                <div class="rdsPane__meta">Spreadsheet</div>
              </div>
              <button class="rdsOpenMobile" type="button" data-rds-open-table>Lihat Tabel</button>
            </div>
            <div class="rdsTableWrap">
              <table class="rdsTable rdsTable--3">
                <thead>
                  <tr>
                    <th>Wilayah</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Bandung</td>
                    <td>6</td>
                    <td><span class="rdsBadge ok">Aktif</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </section>
          <section class="rdsPane" data-rds-pane="delegates" hidden>
            <div class="rdsPane__top">
              <div>
                <div class="rdsPane__title">Technical Delegates</div>
                <div class="rdsPane__meta">Spreadsheet</div>
              </div>
              <button class="rdsOpenMobile" type="button" data-rds-open-table>Lihat Tabel</button>
            </div>
            <div class="rdsTableWrap">
              <table class="rdsTable rdsTable--3">
                <thead>
                  <tr>
                    <th>Wilayah</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>West</td>
                    <td>4</td>
                    <td><span class="rdsBadge ok">Aktif</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </section>
          <section class="rdsPane" data-rds-pane="volunteer" hidden>
            <div class="rdsPane__top">
              <div>
                <div class="rdsPane__title">Volunteer</div>
                <div class="rdsPane__meta">Spreadsheet</div>
              </div>
              <button class="rdsOpenMobile" type="button" data-rds-open-table>Lihat Tabel</button>
            </div>
            <div class="rdsTableWrap">
              <table class="rdsTable rdsTable--3">
                <thead>
                  <tr>
                    <th>Wilayah</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Event 01</td>
                    <td>18</td>
                    <td><span class="rdsBadge ok">Aktif</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </section>
        </div>
        <dialog class="rdsModal" id="rdsMobileModal" aria-label="Tabel mobile">
          <div class="rdsModal__sheet">
            <div class="rdsModal__head">
              <div>
                <div class="rdsModal__title" id="rdsModalTitle">Tabel</div>
                <div class="rdsModal__sub" id="rdsModalSub">Spreadsheet</div>
              </div>
              <button class="rdsModal__close" type="button" data-rds-close-table>Close</button>
            </div>
            <div class="rdsModal__body" id="rdsModalBody"></div>
          </div>
        </dialog>
      </div>
    </section>
  </main>
@endsection