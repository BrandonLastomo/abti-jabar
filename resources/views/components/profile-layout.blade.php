@extends('layouts.app')

@section('content')
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">{{ $title ?? 'Profil Saya' }}</h2>
            </div>
            
            <div class="flex flex-col md:flex-row gap-6">
                
                {{-- SIDEBAR --}}
                <div class="w-full md:w-1/4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4">
                            <nav class="space-y-1">
                                @php
                                    $navItems = [
                                        ['route' => 'user.profile', 'label' => 'Overview & Dokumen', 'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
                                        ['route' => 'user.profile.general', 'label' => 'Profil Umum', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                                        ['route' => 'user.profile.identity', 'label' => 'Dokumen Identitas', 'icon' => 'M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1zM4 4h3a3 3 0 006 0h3a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm4.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM12 14a3 3 0 00-3-3H7a3 3 0 00-3 3h12z'],
                                        ['route' => 'user.profile.education', 'label' => 'Pendidikan', 'icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z'],
                                        ['route' => 'user.team-experiences.index', 'label' => 'Pengalaman Tim', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                                        ['route' => 'user.event-experiences.index', 'label' => 'Pengalaman Event', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                                        ['route' => 'user.certifications.index', 'label' => 'Sertifikasi', 'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
                                        ['route' => 'user.integrity-documents.index', 'label' => 'Pakta Integritas', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                        ['route' => 'user.mutation', 'label' => 'Pengajuan Mutasi', 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
                                    ];
                                @endphp

                                @foreach($navItems as $item)
                                    @php
                                        $isActive = request()->routeIs($item['route']);
                                    @endphp
                                    <a href="{{ route($item['route']) }}" 
                                       class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ $isActive ? 'bg-red-50 text-red-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                                        <svg class="flex-shrink-0 -ml-1 mr-3 h-5 w-5 {{ $isActive ? 'text-red-700' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                                        </svg>
                                        <span class="truncate">
                                            {{ $item['label'] }}
                                        </span>
                                    </a>
                                @endforeach
                            </nav>
                        </div>
                    </div>
                </div>

                {{-- MAIN CONTENT --}}
                <div class="w-full md:w-3/4 space-y-6">
                    {{-- Success / Error Messages --}}
                    @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm font-medium">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm font-medium">
                        {{ session('error') }}
                    </div>
                    @endif

                    {{ $slot }}
                </div>

            </div>
        </div>
    </div>
@endsection
