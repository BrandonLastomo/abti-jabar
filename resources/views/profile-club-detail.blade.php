@extends('layouts.app')
@section('content')

<main class="w-full bg-gray-50 font-sans overflow-hidden text-gray-800 pb-24">
    
    <!-- Header Section -->
    <section class="relative pt-24 pb-12 lg:pt-32 lg:pb-16 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-red-50 via-white to-orange-50 opacity-80"></div>
        <div class="absolute top-0 left-0 -ml-32 -mt-32 w-96 h-96 rounded-full bg-primary/10 blur-3xl"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
            <a href="{{ route('profile', ['category' => $club->category, 'subcategory' => $club->subcategory]) }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-primary transition-colors mb-8">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Tim
            </a>

            <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                <div class="w-32 h-32 md:w-40 md:h-40 bg-white rounded-3xl p-2 shadow-xl shadow-gray-200/50 flex-shrink-0">
                    <div class="w-full h-full bg-gray-50 rounded-2xl overflow-hidden flex items-center justify-center">
                        @if($club->logo)
                            <img src="{{ asset('storage/'.$club->logo) }}" alt="{{ $club->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-5xl font-extrabold text-gray-300">{{ substr($club->name, 0, 1) }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="text-center md:text-left pt-2 md:pt-4">
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-3">
                        <span class="inline-block px-3 py-1 bg-white/80 backdrop-blur-sm border border-gray-200 text-xs font-bold tracking-wider uppercase text-gray-600 rounded-full shadow-sm">
                            Westjava {{ ucfirst($club->category) }}
                        </span>
                        <span class="inline-block px-3 py-1 bg-primary/10 border border-primary/20 text-xs font-bold tracking-wider uppercase text-primary rounded-full shadow-sm">
                            {{ $club->subcategory }}
                        </span>
                        <span class="inline-block px-3 py-1 bg-amber-50 border border-amber-200 text-xs font-bold tracking-wider uppercase text-amber-600 rounded-full shadow-sm">
                            {{ $club->club_status === 'profesional' ? 'Profesional' : 'Amatir' }}
                        </span>
                    </div>
                    <h1 class="font-heading text-3xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-4 drop-shadow-sm">
                        {{ $club->name }}
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <section class="relative z-20 max-w-7xl mx-auto px-6 lg:px-8 mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- Left Column: Profile Data -->
            <div class="lg:col-span-1 space-y-6">
                
                <div class="bg-white/80 backdrop-blur-xl border border-white rounded-[2rem] p-8 shadow-xl shadow-gray-200/50">
                    <h3 class="text-xl font-heading font-extrabold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Informasi Klub
                    </h3>
                    
                    <div class="space-y-5">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Email</p>
                            <p class="text-sm font-medium text-gray-800">{{ $club->email ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Telepon</p>
                            <p class="text-sm font-medium text-gray-800">{{ $club->phone ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Website</p>
                            @if($club->website)
                                <a href="{{ $club->website }}" target="_blank" class="text-sm font-medium text-primary hover:underline">{{ $club->website }}</a>
                            @else
                                <p class="text-sm font-medium text-gray-800">-</p>
                            @endif
                        </div>
                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat Kantor</p>
                            <p class="text-sm font-medium text-gray-800">{{ $club->office_address_complete ?? $club->office_address ?? '-' }}</p>
                        </div>
                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat Pengcab</p>
                            <p class="text-sm font-medium text-gray-800">{{ $club->pengcab_address ?? '-' }}</p>
                        </div>
                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat Tempat Latihan (Venue)</p>
                            <p class="text-sm font-medium text-gray-800">{{ $club->venue_address_complete ?? $club->venue_address ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Team Photo if exists -->
                @if($club->picture)
                <div class="bg-white/80 backdrop-blur-xl border border-white rounded-[2rem] p-3 shadow-xl shadow-gray-200/50 overflow-hidden">
                    <img src="{{ asset('storage/'.$club->picture) }}" alt="Foto Tim" class="w-full h-auto rounded-[1.5rem] object-cover">
                </div>
                @endif
                
            </div>

            <!-- Right Column: Staff Roster -->
            <div class="lg:col-span-2">
                <div class="bg-white/80 backdrop-blur-xl border border-white rounded-[2.5rem] p-8 md:p-10 shadow-xl shadow-gray-200/50 h-full">
                    
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-red-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-heading font-extrabold text-gray-900">Roster Tim (Staff)</h3>
                    </div>

                    @if($club->staff->isEmpty())
                        <div class="flex flex-col items-center justify-center py-16 text-center bg-gray-50/50 rounded-2xl border border-gray-100">
                            <div class="w-16 h-16 bg-white rounded-full shadow-sm flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <h4 class="font-bold text-gray-900 mb-1">Belum Ada Staff</h4>
                            <p class="text-sm text-gray-500">Daftar staff untuk klub ini belum ditambahkan.</p>
                        </div>
                    @else
                        @php
                            // Group staff by their general categories to make it structured
                            $groupedStaff = [
                                'Manajemen Utama' => $club->staff->whereIn('position', ['Direktur Utama', 'Administrator', 'Bendahara']),
                                'Manajemen Operasional' => $club->staff->whereIn('position', [
                                    'Manajemen Kerjasama, Pendidikan, Hukum, Riset dan Pengembangan',
                                    'Manajemen Media Sosial dan Relasi Publik',
                                    'Manajemen Pemasaran dan Branding',
                                    'Manajemen Pemasalan, Pembinaan dan Event'
                                ]),
                                'Tim Kepelatihan' => $club->staff->whereIn('position', ['Direktur Teknik', 'Manajer', 'Coach', 'Fitness Coach', 'Goalkeeper Coach', 'Pelatih Mental']),
                                'Tim Medis' => $club->staff->whereNotIn('position', [
                                    'Direktur Utama', 'Administrator', 'Bendahara', 
                                    'Manajemen Kerjasama, Pendidikan, Hukum, Riset dan Pengembangan',
                                    'Manajemen Media Sosial dan Relasi Publik',
                                    'Manajemen Pemasaran dan Branding',
                                    'Manajemen Pemasalan, Pembinaan dan Event',
                                    'Direktur Teknik', 'Manajer', 'Coach', 'Fitness Coach', 'Goalkeeper Coach', 'Pelatih Mental'
                                ])
                            ];
                        @endphp

                        <div class="space-y-10">
                            @foreach($groupedStaff as $groupName => $staffList)
                                @if($staffList->isNotEmpty())
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 pb-3 mb-6">
                                            {{ $groupName }}
                                        </h4>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            @foreach($staffList as $staff)
                                                <div class="flex items-start gap-4 p-4 bg-gray-50/80 rounded-xl hover:bg-white hover:shadow-md transition-all duration-300 border border-transparent hover:border-gray-100">
                                                    <div class="w-10 h-10 bg-primary/10 text-primary rounded-full flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                    </div>
                                                    <div>
                                                        <p class="font-bold text-gray-900 mb-0.5">{{ $staff->name }}</p>
                                                        <p class="text-xs font-medium text-gray-500">{{ $staff->position }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </section>
</main>

@endsection
