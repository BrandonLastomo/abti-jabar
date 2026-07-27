@extends('layouts.app')
@section('content')
<main class="w-full bg-gray-50 font-sans overflow-hidden text-gray-800" id="rds">

    <!-- ===================== DATABASE PAGE HEADER ===================== -->
    <section class="relative pt-24 pb-12 lg:pt-32 lg:pb-16 overflow-hidden bg-white" aria-label="Database page header">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-red-50 opacity-80"></div>
        <div class="absolute top-0 right-0 -mr-32 -mt-32 w-96 h-96 rounded-full bg-primary/5 blur-3xl"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
            <div class="mb-4">
                <span class="inline-block px-4 py-1.5 rounded-full bg-white/60 backdrop-blur-md border border-gray-200 text-xs font-bold tracking-widest uppercase text-primary shadow-sm">
                    Database
                </span>
            </div>
            <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-4 tracking-tight drop-shadow-sm">
                Resources Dashboard
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl leading-relaxed">
                Ringkasan SDM + tabel (siap integrasi spreadsheet).
            </p>
        </div>
    </section>

    <!-- ===================== OVERVIEW CARDS ===================== -->
    <section class="relative z-20 max-w-7xl mx-auto px-6 lg:px-8 pb-12 -mt-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <article class="bg-white/70 backdrop-blur-xl border border-white rounded-[2rem] p-6 md:p-8 shadow-xl shadow-gray-200/50 hover:-translate-y-2 transition-transform duration-500 flex flex-col justify-between group" data-rds-card>
                <div class="flex justify-between items-start mb-6">
                    <div class="text-sm font-bold text-gray-500 uppercase tracking-wider group-hover:text-primary transition-colors">Atlet</div>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full">Core</span>
                </div>
                <div class="text-5xl font-heading font-extrabold text-gray-900 mb-2" data-rds-count="128">0</div>
                <div class="text-sm text-gray-500 font-medium">Atlet terdaftar aktif</div>
            </article>

            <article class="bg-white/70 backdrop-blur-xl border border-white rounded-[2rem] p-6 md:p-8 shadow-xl shadow-gray-200/50 hover:-translate-y-2 transition-transform duration-500 flex flex-col justify-between group" data-rds-card>
                <div class="flex justify-between items-start mb-6">
                    <div class="text-sm font-bold text-gray-500 uppercase tracking-wider group-hover:text-primary transition-colors">Coaching & Tech</div>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full">Teknis</span>
                </div>
                <div class="text-5xl font-heading font-extrabold text-gray-900 mb-2" data-rds-count="34">0</div>
                <div class="text-sm text-gray-500 font-medium">Pelatih + Pelatih GK + TD</div>
            </article>

            <article class="bg-white/70 backdrop-blur-xl border border-white rounded-[2rem] p-6 md:p-8 shadow-xl shadow-gray-200/50 hover:-translate-y-2 transition-transform duration-500 flex flex-col justify-between group" data-rds-card>
                <div class="flex justify-between items-start mb-6">
                    <div class="text-sm font-bold text-gray-500 uppercase tracking-wider group-hover:text-primary transition-colors">Match Officials</div>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full">Regulasi</span>
                </div>
                <div class="text-5xl font-heading font-extrabold text-gray-900 mb-2" data-rds-count="22">0</div>
                <div class="text-sm text-gray-500 font-medium">Wasit + Delegates</div>
            </article>

            <article class="bg-white/70 backdrop-blur-xl border border-white rounded-[2rem] p-6 md:p-8 shadow-xl shadow-gray-200/50 hover:-translate-y-2 transition-transform duration-500 flex flex-col justify-between group" data-rds-card>
                <div class="flex justify-between items-start mb-6">
                    <div class="text-sm font-bold text-gray-500 uppercase tracking-wider group-hover:text-primary transition-colors">Management & Support</div>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full">Ops</span>
                </div>
                <div class="text-5xl font-heading font-extrabold text-gray-900 mb-2" data-rds-count="60">0</div>
                <div class="text-sm text-gray-500 font-medium">Manajemen + Volunteer</div>
            </article>

        </div>
    </section>

    <!-- ===================== DETAIL RESOURCES ===================== -->
    <section class="relative z-20 max-w-7xl mx-auto px-6 lg:px-8 pb-24" data-rds-panel>
        <div class="bg-white/80 backdrop-blur-xl border border-white rounded-[2.5rem] p-6 md:p-10 shadow-2xl shadow-gray-200/60 flex flex-col gap-8">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div>
                    <h3 class="text-2xl md:text-3xl font-heading font-extrabold text-gray-900 mb-2">Detail Resources</h3>
                    <p class="text-gray-500">8 tabel detail. UI ini tinggal diisi data spreadsheet nanti.</p>
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-green-50 text-green-700 rounded-full text-sm font-bold border border-green-100">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    Realtime-update
                </div>
            </div>

            <!-- Tabs -->
            <div class="rdsTabs flex flex-nowrap overflow-x-auto pb-4 -mx-6 px-6 md:mx-0 md:px-0 gap-3 scroll-smooth custom-scrollbar" role="tablist" aria-label="Resources tabs">
                <button class="rdsTab flex-shrink-0 px-6 py-3 rounded-full font-bold text-sm transition-all duration-300 shadow-sm border border-transparent bg-gray-50 text-gray-500 hover:bg-gray-100 [&.is-active]:bg-primary [&.is-active]:text-white [&.is-active]:shadow-md is-active" data-rds-tab="atlet" role="tab" aria-selected="true">Atlet</button>
                <button class="rdsTab flex-shrink-0 px-6 py-3 rounded-full font-bold text-sm transition-all duration-300 shadow-sm border border-transparent bg-gray-50 text-gray-500 hover:bg-gray-100 [&.is-active]:bg-primary [&.is-active]:text-white [&.is-active]:shadow-md" data-rds-tab="pelatih" role="tab" aria-selected="false">Pelatih</button>
                <button class="rdsTab flex-shrink-0 px-6 py-3 rounded-full font-bold text-sm transition-all duration-300 shadow-sm border border-transparent bg-gray-50 text-gray-500 hover:bg-gray-100 [&.is-active]:bg-primary [&.is-active]:text-white [&.is-active]:shadow-md" data-rds-tab="pelatihgk" role="tab" aria-selected="false">Pelatih GK</button>
                <button class="rdsTab flex-shrink-0 px-6 py-3 rounded-full font-bold text-sm transition-all duration-300 shadow-sm border border-transparent bg-gray-50 text-gray-500 hover:bg-gray-100 [&.is-active]:bg-primary [&.is-active]:text-white [&.is-active]:shadow-md" data-rds-tab="td" role="tab" aria-selected="false">Tech. Director</button>
                <button class="rdsTab flex-shrink-0 px-6 py-3 rounded-full font-bold text-sm transition-all duration-300 shadow-sm border border-transparent bg-gray-50 text-gray-500 hover:bg-gray-100 [&.is-active]:bg-primary [&.is-active]:text-white [&.is-active]:shadow-md" data-rds-tab="manajemen" role="tab" aria-selected="false">Tim Manajemen</button>
                <button class="rdsTab flex-shrink-0 px-6 py-3 rounded-full font-bold text-sm transition-all duration-300 shadow-sm border border-transparent bg-gray-50 text-gray-500 hover:bg-gray-100 [&.is-active]:bg-primary [&.is-active]:text-white [&.is-active]:shadow-md" data-rds-tab="wasit" role="tab" aria-selected="false">Wasit</button>
                <button class="rdsTab flex-shrink-0 px-6 py-3 rounded-full font-bold text-sm transition-all duration-300 shadow-sm border border-transparent bg-gray-50 text-gray-500 hover:bg-gray-100 [&.is-active]:bg-primary [&.is-active]:text-white [&.is-active]:shadow-md" data-rds-tab="delegates" role="tab" aria-selected="false">Tech. Delegates</button>
                <button class="rdsTab flex-shrink-0 px-6 py-3 rounded-full font-bold text-sm transition-all duration-300 shadow-sm border border-transparent bg-gray-50 text-gray-500 hover:bg-gray-100 [&.is-active]:bg-primary [&.is-active]:text-white [&.is-active]:shadow-md" data-rds-tab="volunteer" role="tab" aria-selected="false">Volunteer</button>
            </div>

            <!-- Tab Content (Tables) -->
            <div class="rdsStage mt-4">
                @php
                $panes = [
                    'atlet' => [['Bandung', 42, 'ok', 'Aktif'], ['Bekasi', 31, 'ok', 'Aktif'], ['Bogor', 9, 'warn', 'Perlu Verifikasi']],
                    'pelatih' => [['Bandung', 12, 'ok', 'Aktif'], ['Depok', 7, 'warn', 'Perlu Update']],
                    'pelatihgk' => [['Bandung', 3, 'ok', 'Aktif']],
                    'td' => [['Jawa Barat', 1, 'ok', 'Aktif']],
                    'manajemen' => [['Bandung', 10, 'ok', 'Aktif']],
                    'wasit' => [['Bandung', 6, 'ok', 'Aktif']],
                    'delegates' => [['West', 4, 'ok', 'Aktif']],
                    'volunteer' => [['Event 01', 18, 'ok', 'Aktif']],
                ];
                $titles = [
                    'atlet' => 'Atlet', 'pelatih' => 'Pelatih', 'pelatihgk' => 'Pelatih GK', 
                    'td' => 'Technical Director', 'manajemen' => 'Tim Manajemen', 
                    'wasit' => 'Wasit', 'delegates' => 'Technical Delegates', 'volunteer' => 'Volunteer'
                ];
                @endphp

                @foreach($panes as $key => $data)
                <section class="rdsPane {{ $loop->first ? 'is-active' : '' }}" data-rds-pane="{{ $key }}">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                        <div>
                            <div class="text-xl font-bold text-gray-900 mb-1">{{ $titles[$key] }}</div>
                            <div class="text-sm text-gray-500">Tabel terintegrasi spreadsheet</div>
                        </div>
                        <!-- Provide standard unstyled classes since JS strips contents and styles the popup modal from the table directly -->
                        <button class="rdsOpenMobile md:hidden w-full md:w-auto px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-colors" type="button" data-rds-open-table>
                            Lihat Tabel
                        </button>
                    </div>

                    <div class="rdsTableWrap hidden md:block w-full overflow-hidden rounded-2xl border border-gray-100 shadow-sm bg-white">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-100">
                                    <th class="py-4 px-6 font-bold text-gray-500 uppercase text-xs tracking-wider">Wilayah</th>
                                    <th class="py-4 px-6 font-bold text-gray-500 uppercase text-xs tracking-wider">Jumlah</th>
                                    <th class="py-4 px-6 font-bold text-gray-500 uppercase text-xs tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($data as $row)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 px-6 font-bold text-gray-900">{{ $row[0] }}</td>
                                    <td class="py-4 px-6 font-medium text-gray-600">{{ $row[1] }}</td>
                                    <td class="py-4 px-6">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold {{ $row[2] == 'ok' ? 'bg-green-50 text-green-600 border border-green-100' : 'bg-orange-50 text-orange-600 border border-orange-100' }}">
                                            {{ $row[3] }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
                @endforeach
            </div>

            <!-- Mobile Modal (Triggered by JS) -->
            <dialog class="rdsModal fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 [&[open]]:opacity-100 [&[open]]:pointer-events-auto" id="rdsMobileModal" aria-label="Tabel mobile">
                <div class="rdsModal__sheet relative w-full max-w-lg bg-white rounded-3xl shadow-2xl overflow-hidden transform translate-y-8 transition-transform duration-300" style="max-height: 85vh; display: flex; flex-direction: column;">
                    <div class="rdsModal__head flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
                        <div>
                            <div class="text-xl font-bold text-gray-900" id="rdsModalTitle">Tabel</div>
                            <div class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-1" id="rdsModalSub">Spreadsheet</div>
                        </div>
                        <button class="rdsModal__close w-10 h-10 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 hover:bg-gray-100 hover:text-gray-900 transition-colors" type="button" data-rds-close-table>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <div class="rdsModal__body flex-1 overflow-y-auto p-6" id="rdsModalBody"></div>
                </div>
            </dialog>

        </div>
    </section>
</main>

<style>
/* CSS overrides for JS logic */
.rdsPane:not(.is-active) { display: none; }
.custom-scrollbar::-webkit-scrollbar { height: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #d1d5db; }

/* The JS for the mobile modal pulls from .rdsTableWrap, so let's ensure the JS works when injecting */
#rdsModalBody table {
    width: 100%;
    border-collapse: collapse;
}
#rdsModalBody th {
    padding: 1rem;
    font-weight: bold;
    color: #6b7280;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
    border-bottom: 1px solid #f3f4f6;
    background: #f9fafb;
    text-align: left;
}
#rdsModalBody td {
    padding: 1rem;
    font-weight: 500;
    color: #111827;
    border-bottom: 1px solid #f9fafb;
}
#rdsModalBody tr:hover td {
    background: #f9fafb;
}
/* Re-style the badge injected by JS inside modal */
#rdsModalBody .bg-green-50 {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: bold;
    background-color: #f0fdf4;
    color: #16a34a;
    border: 1px solid #dcfce3;
}
#rdsModalBody .bg-orange-50 {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: bold;
    background-color: #fff7ed;
    color: #ea580c;
    border: 1px solid #ffedd5;
}

/* Ensure JS dialog open state styles work */
dialog[open].rdsModal .rdsModal__sheet {
    transform: translateY(0);
}
</style>
@endsection