@extends('cms.layouts.master')

@section('title', 'Admin Dashboard - Club Manager')

@section('full_content')
<div class="p-6 lg:p-10 min-h-screen bg-gray-50/50">
    
    <!-- Dashboard Header -->
    <div class="mb-10">
        <h1 class="font-heading font-extrabold text-4xl text-gray-900 tracking-tight mb-2">Club Dashboard</h1>
        <p class="text-gray-500 font-medium">Welcome, {{ Auth::user()->name }}. Manage your club details here.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 text-green-700 p-4 rounded-xl border border-green-100 font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if($myClub)
        <!-- Club Info Card -->
        <div class="bg-white/80 backdrop-blur-xl border border-gray-100 rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden mb-8">
            <div class="flex flex-col md:flex-row gap-8 items-center">
                <div class="w-32 h-32 flex-shrink-0 bg-gray-100 rounded-full flex items-center justify-center overflow-hidden border-4 border-white shadow-lg">
                    @if($myClub->logo)
                        <img src="{{ asset('storage/' . $myClub->logo) }}" alt="{{ $myClub->name }} Logo" class="w-full h-full object-cover">
                    @else
                        <span class="text-4xl text-gray-400 font-bold">{{ substr($myClub->name, 0, 1) }}</span>
                    @endif
                </div>
                
                <div class="flex-1 text-center md:text-left">
                    <span class="inline-block px-3 py-1 bg-primary/10 text-primary font-bold text-xs rounded-full mb-2 uppercase tracking-wide">
                        {{ $myClub->category }} - {{ $myClub->subcategory }}
                    </span>
                    <h2 class="font-heading font-extrabold text-3xl text-gray-900 mb-2">{{ $myClub->name }}</h2>
                    <p class="text-gray-500 font-medium mb-4">
                        <svg class="w-5 h-5 inline-block mr-1 -mt-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $myClub->office_address ?? 'No Office Address' }}
                    </p>
                    
                    <div class="flex flex-wrap justify-center md:justify-start gap-4">
                        <a href="{{ route('club.edit', $myClub->id) }}" class="inline-flex justify-center items-center px-5 py-2.5 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-800 transition-all shadow-md hover:shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit Profile
                        </a>
                        <a href="{{ route('club.staff.index', $myClub->id) }}" class="inline-flex justify-center items-center px-5 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all shadow-md hover:shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Manage Staff ({{ $myClub->staff()->count() }})
                        </a>
                        <a href="{{ route('club.documents.index', $myClub->id) }}" class="inline-flex justify-center items-center px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-md hover:shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Manage Documents
                        </a>
                    </div>
                </div>
            </div>
        </div>

    @else
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-8 text-center max-w-lg mx-auto mt-20 shadow-sm">
            <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h2 class="font-heading font-extrabold text-2xl text-gray-900 mb-2">No Club Assigned</h2>
            <p class="text-gray-600 mb-6">You have not created a club yet. Click the button below to register your club.</p>
            <a href="{{ route('club.create') }}" class="inline-flex justify-center items-center px-6 py-3 bg-primary text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Create My Club
            </a>
        </div>
    @endif

</div>
@endsection
