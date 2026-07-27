@extends('layouts.app')
@section('content')
<main class="w-full bg-gray-50 font-sans overflow-hidden text-gray-800 min-h-screen">

    <!-- ===================== ARCHIVES HEADER ===================== -->
    <section class="relative pt-24 pb-12 lg:pt-32 lg:pb-16 overflow-hidden bg-white" id="archivesHeader">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 via-white to-red-50 opacity-80"></div>
        <div class="absolute top-0 right-0 -mr-32 -mt-32 w-96 h-96 rounded-full bg-primary/5 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-32 -mb-32 w-80 h-80 rounded-full bg-indigo-500/10 blur-3xl"></div>
        
        <div class="relative z-10 max-w-4xl mx-auto px-6 lg:px-8 text-center">
            <div class="mb-4">
                <span class="inline-block px-4 py-1.5 rounded-full bg-white/60 backdrop-blur-md border border-gray-200 text-xs font-bold tracking-widest uppercase text-indigo-600 shadow-sm">
                    Data & Regulasi
                </span>
            </div>
            <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-4 tracking-tight drop-shadow-sm">
                ABTI <span class="text-primary">Archives</span>
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Kumpulan dokumen regulasi resmi. Klik kategori untuk melihat daftar dokumen, lalu buka file PDF.
            </p>
        </div>
    </section>

    <!-- ===================== TIMELINE / ARCHIVES LIST ===================== -->
    <section id="archives" class="abti-archives relative z-20 max-w-4xl mx-auto px-6 lg:px-8 pb-24 -mt-6">
        
        <div class="bg-white/70 backdrop-blur-xl border border-white rounded-[2.5rem] p-6 md:p-10 shadow-2xl shadow-gray-200/50" data-accordion="abti-archives">
            
            @php
            $categories = [
                'Mutation Regulation',
                'Club Regulation',
                'Event Regulation',
                'Sanction Regulation',
                'Statutes & Regulation'
            ];
            @endphp

            <div class="relative">
                <!-- Vertical Timeline Line -->
                <div class="absolute left-6 md:left-8 top-8 bottom-8 w-0.5 bg-gray-200/60 rounded-full hidden sm:block"></div>

                <div class="space-y-6 relative z-10">
                    @foreach($categories as $category)
                        @php
                            $docs = $archives[$category] ?? collect();
                            $slug = \Str::slug($category);
                            $docCount = $docs->count();
                        @endphp

                        <div class="acc-item group">
                            
                            <button class="acc-trigger w-full text-left relative flex items-center p-4 md:p-6 bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md hover:border-indigo-100 transition-all duration-300 z-10 focus:outline-none focus:ring-2 focus:ring-indigo-500/50"
                                type="button"
                                aria-expanded="false"
                                aria-controls="acc-panel-{{ $slug }}"
                                id="acc-trigger-{{ $slug }}">
                                
                                <!-- Timeline Node -->
                                <div class="hidden sm:flex absolute -left-10 md:-left-8 w-4 h-4 rounded-full bg-white border-4 border-gray-200 group-[[aria-expanded=true]]:border-primary transition-colors duration-300"></div>

                                <div class="flex-1 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                    <h3 class="text-lg md:text-xl font-bold text-gray-900 group-[[aria-expanded=true]]:text-primary transition-colors">
                                        {{ $category }}
                                    </h3>
                                    <span class="inline-block px-3 py-1 bg-gray-100 text-gray-500 text-xs font-bold uppercase rounded-full tracking-wider group-[[aria-expanded=true]]:bg-red-50 group-[[aria-expanded=true]]:text-primary transition-colors">
                                        {{ $docCount }} Dokumen
                                    </span>
                                </div>
                                
                                <!-- Chevron Icon -->
                                <div class="ml-4 w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 group-[[aria-expanded=true]]:bg-red-50 group-[[aria-expanded=true]]:text-primary group-[[aria-expanded=true]]:rotate-180 transition-all duration-300 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </button>

                            <!-- Accordion Panel -->
                            <div class="acc-panel ml-0 sm:ml-6 md:ml-12"
                                id="acc-panel-{{ $slug }}"
                                role="region"
                                aria-labelledby="acc-trigger-{{ $slug }}"
                                hidden>
                                
                                <div class="pt-4 pb-2 px-2">
                                    @if($docCount > 0)
                                        <div class="space-y-3">
                                            @foreach($docs as $doc)
                                                <a href="{{ asset('storage/' . $doc->file) }}" target="_blank" class="flex items-center gap-4 p-4 bg-gray-50/50 border border-gray-100 hover:border-primary/30 hover:bg-red-50/30 rounded-xl transition-all duration-300 group/doc">
                                                    <div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center text-red-500 flex-shrink-0 group-hover/doc:bg-red-500 group-hover/doc:text-white transition-colors">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM6 20V4h5v7h7v9H6z"/><path d="M8 12h8v2H8zm0 4h8v2H8z"/></svg>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h4 class="text-sm md:text-base font-bold text-gray-900 group-hover/doc:text-primary transition-colors">
                                                            {{ $doc->title }}
                                                        </h4>
                                                    </div>
                                                    <div class="text-gray-400 group-hover/doc:text-primary transition-colors">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center justify-center py-8 text-center bg-gray-50/50 rounded-xl border border-dashed border-gray-200">
                                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-gray-300 mb-3">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            </div>
                                            <p class="text-gray-500 font-medium text-sm">Belum ada dokumen untuk kategori ini.</p>
                                        </div>
                                    @endif
                                </div>
                                
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="mt-10 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-500 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Catatan: Klik pada nama dokumen untuk membuka file PDF secara langsung.
                </p>
            </div>
            
        </div>
    </section>

</main>

<style>
/* Accordion transition for JS */
.acc-panel {
    transition: height 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
/* Override old style.css hiding the elements */
.acc-item {
    opacity: 1 !important;
    transform: none !important;
}
</style>
@endsection