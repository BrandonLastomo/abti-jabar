@extends('layouts.app')
@section('content')
@php 
    use Carbon\Carbon;
    Carbon::setLocale('id'); 
@endphp

<main class="w-full bg-gray-50 font-sans overflow-hidden text-gray-800">
  
    <!-- ===================== PROFILE PAGE HEADER ===================== -->
    <section class="relative pt-24 pb-12 lg:pt-32 lg:pb-16 overflow-hidden" aria-label="Profile page header">
        <div class="absolute inset-0 bg-gradient-to-br from-red-50 via-white to-orange-50 opacity-80"></div>
        <!-- decorative blobs -->
        <div class="absolute top-0 left-0 -ml-32 -mt-32 w-96 h-96 rounded-full bg-primary/10 blur-3xl"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
            <div class="mb-4">
                <span class="inline-block px-4 py-1.5 rounded-full bg-white/60 backdrop-blur-md border border-gray-200 text-xs font-bold tracking-widest uppercase text-primary shadow-sm">
                    Team Roster
                </span>
            </div>
            <h1 class="font-heading text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-4 tracking-tight drop-shadow-sm">
                Profile Tim
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl leading-relaxed">
                Telusuri data, roster, dan jadwal aktivitas dari seluruh tim bola tangan Jawa Barat.
            </p>
        </div>
    </section>

    <!-- ===================== NAVIGATION & FILTER ===================== -->
    <section class="relative z-20 max-w-7xl mx-auto px-6 lg:px-8 pb-8 -mt-6">
        <div class="bg-white/70 backdrop-blur-xl border border-white rounded-[2rem] shadow-xl shadow-gray-200/50 flex flex-col md:flex-row overflow-hidden">
            
            <!-- Category Tabs (Main) -->
            <div class="w-full md:w-1/3 border-b md:border-b-0 md:border-r border-white/50 bg-gray-50/30 flex flex-col">
                <a href="{{ route('profile', ['category' => 'indoor', 'subcategory' => 'Senior putra']) }}" 
                   class="px-8 py-6 text-sm font-bold transition-all duration-300 {{ $category === 'indoor' ? 'bg-white text-primary border-l-4 border-primary shadow-sm' : 'text-gray-500 hover:bg-white/50 hover:text-gray-900 border-l-4 border-transparent' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ $category === 'indoor' ? 'text-primary' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Westjava Indoor
                    </div>
                </a>
                <a href="{{ route('profile', ['category' => 'beach', 'subcategory' => 'Senior putra']) }}" 
                   class="px-8 py-6 text-sm font-bold transition-all duration-300 {{ $category === 'beach' ? 'bg-white text-primary border-l-4 border-primary shadow-sm' : 'text-gray-500 hover:bg-white/50 hover:text-gray-900 border-l-4 border-transparent' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ $category === 'beach' ? 'text-primary' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Westjava Beach
                    </div>
                </a>
                <a href="{{ route('profile', ['category' => 'wheelchair', 'subcategory' => 'Lihat Semua Tim']) }}" 
                   class="px-8 py-6 text-sm font-bold transition-all duration-300 {{ $category === 'wheelchair' ? 'bg-white text-primary border-l-4 border-primary shadow-sm' : 'text-gray-500 hover:bg-white/50 hover:text-gray-900 border-l-4 border-transparent' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ $category === 'wheelchair' ? 'text-primary' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                        Westjava Wheelchair
                    </div>
                </a>
            </div>

            <!-- Subcategories (Pills) -->
            <div class="w-full md:w-2/3 p-6 md:p-8 flex flex-wrap gap-3 content-start bg-white/40">
                <div class="w-full mb-2">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Sub Kategori</span>
                </div>
                @if(isset($subcategories[$category]))
                    @foreach($subcategories[$category] as $sub)
                        <a href="{{ route('profile', ['category' => $category, 'subcategory' => $sub]) }}" 
                           class="px-5 py-2.5 text-sm font-bold rounded-full transition-all duration-300 shadow-sm border border-transparent 
                           {{ $subcategory === $sub 
                               ? 'bg-gray-900 text-white shadow-md transform scale-105' 
                               : 'bg-white text-gray-600 border-white/50 hover:bg-gray-100 hover:text-gray-900' }}">
                            {{ $sub }}
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- ===================== MAIN 3D ID CARD ===================== -->
    <section class="relative z-20 max-w-7xl mx-auto px-6 lg:px-8 pb-24">
        
        <!-- Title & Subtitle inside the main flow -->
        <div class="mb-10 text-center">
            <h2 class="text-3xl md:text-4xl font-heading font-extrabold text-gray-900 mb-2">
                Westjava {{ ucfirst($category) }}
            </h2>
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/80 backdrop-blur-sm border border-gray-200 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                <span class="text-sm font-bold text-gray-600">{{ $subcategory }}</span>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-10">
            
            <!-- Left: Team Photo (3D Hover Effect) -->
            <div class="w-full lg:w-1/2 perspective-1000 group">
                <div class="relative w-full aspect-[4/3] bg-white/70 backdrop-blur-xl border border-white rounded-[2.5rem] p-3 shadow-2xl shadow-gray-200/60 transition-transform duration-700 ease-out group-hover:rotate-y-2 group-hover:rotate-x-2 group-hover:-translate-y-2">
                    <div class="w-full h-full rounded-[2rem] overflow-hidden relative bg-gray-100 flex items-center justify-center">
                        @if($teamProfile && $teamProfile->picture)
                            <img src="{{ asset('storage/'.$teamProfile->picture) }}" alt="Foto Tim {{ $subcategory }}" class="w-full h-full object-cover">
                            <!-- Soft inner glow -->
                            <div class="absolute inset-0 ring-1 ring-inset ring-white/20 rounded-[2rem]"></div>
                        @else
                            <div class="text-center p-8">
                                <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <h3 class="text-gray-500 font-bold text-lg mb-1">Foto Tim {{ $subcategory }}</h3>
                                <p class="text-gray-400 text-sm">Menunggu update foto resmi</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right: Aktivitas & Jadwal (Frosted Ledger Style) -->
            <div class="w-full lg:w-1/2">
                <div class="bg-white/80 backdrop-blur-xl border border-white rounded-[2.5rem] p-8 md:p-10 shadow-xl shadow-gray-200/50 h-full flex flex-col">
                    
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-red-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-heading font-extrabold text-gray-900">Aktivitas & Jadwal</h3>
                    </div>

                    <div class="flex-1 space-y-8 overflow-y-auto pr-2 custom-scrollbar">
                        @forelse($groupedEvents as $year => $eventsInYear)
                            <div class="relative">
                                <!-- Year sticky header -->
                                <div class="sticky top-0 bg-white/90 backdrop-blur-md py-2 z-10 mb-4 border-b border-gray-100">
                                    <span class="text-sm font-extrabold text-primary px-3 py-1 bg-red-50 rounded-full">{{ $year }}</span>
                                </div>
                                
                                <div class="w-full overflow-hidden rounded-2xl border border-gray-100 bg-white/50">
                                    <table class="w-full text-left text-sm">
                                        <thead class="bg-gray-50/50 text-gray-500 border-b border-gray-100">
                                            <tr>
                                                <th scope="col" class="px-5 py-3 font-bold uppercase text-xs tracking-wider">Tanggal</th>
                                                <th scope="col" class="px-5 py-3 font-bold uppercase text-xs tracking-wider">Kegiatan</th>
                                                <th scope="col" class="px-5 py-3 font-bold uppercase text-xs tracking-wider hidden sm:table-cell">Lokasi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-50">
                                            @foreach($eventsInYear as $event)
                                                <tr class="hover:bg-white transition-colors group">
                                                    <td class="px-5 py-4 whitespace-nowrap text-gray-500 font-medium group-hover:text-gray-900 transition-colors">
                                                        {{ $event->event_date ? Carbon::parse($event->event_date)->translatedFormat('d M') : Carbon::parse($event->created_at)->translatedFormat('d M') }}
                                                    </td>
                                                    <td class="px-5 py-4 font-bold text-gray-900">
                                                        {{ $event->name }}
                                                        <div class="sm:hidden text-xs text-gray-500 mt-1 font-medium">{{ $event->loc ?? '-' }}</div>
                                                    </td>
                                                    <td class="px-5 py-4 text-gray-500 hidden sm:table-cell">
                                                        {{ $event->loc ?? '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center h-full py-12 text-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h4 class="font-bold text-gray-900 mb-1">Belum Ada Jadwal</h4>
                                <p class="text-sm text-gray-500">Jadwal aktivitas untuk tim ini belum ditambahkan.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>

        </div>
    </section>
</main>

<style>
/* 3D Perspective Utils */
.perspective-1000 { perspective: 1000px; }
.rotate-y-2 { transform: rotateY(2deg); }
.rotate-x-2 { transform: rotateX(2deg); }
.custom-scrollbar::-webkit-scrollbar { width: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #d1d5db; }
</style>
@endsection