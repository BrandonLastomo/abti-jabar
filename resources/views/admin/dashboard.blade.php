@extends('cms.layouts.master')

@section('title', 'Admin Dashboard - Overview')

@section('full_content')
<div class="p-6 lg:p-10 min-h-screen bg-gray-50/50">
    
    <!-- Dashboard Header -->
    <div class="mb-10">
        <h1 class="font-heading font-extrabold text-4xl text-gray-900 tracking-tight mb-2">Dashboard Overview</h1>
        <p class="text-gray-500 font-medium">Welcome, Admin. Here is a snapshot of current verifications.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        
        <!-- Total Documents -->
        <div class="bg-white/80 backdrop-blur-xl border border-gray-100 rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
            <h3 class="text-gray-500 font-medium text-sm mb-1">Total Documents</h3>
            <p class="font-heading font-extrabold text-4xl text-gray-900">{{ number_format($stats['total_documents']) }}</p>
        </div>

        <!-- Pending Documents -->
        <div class="bg-white/80 backdrop-blur-xl border border-amber-100 rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(251,191,36,0.15)] hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-50 rounded-full blur-2xl opacity-60"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center ring-1 ring-amber-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                @if($stats['pending_documents'] > 0)
                <span class="text-xs font-bold text-amber-700 bg-amber-100 px-2.5 py-1 rounded-full animate-pulse">Action Required</span>
                @endif
            </div>
            <h3 class="text-gray-600 font-medium text-sm mb-1 relative z-10">Pending Documents</h3>
            <p class="font-heading font-extrabold text-4xl text-amber-600 relative z-10">{{ number_format($stats['pending_documents']) }}</p>
        </div>

        <!-- Total Mutations -->
        <div class="bg-white/80 backdrop-blur-xl border border-gray-100 rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                </div>
            </div>
            <h3 class="text-gray-500 font-medium text-sm mb-1">Total Mutations</h3>
            <p class="font-heading font-extrabold text-4xl text-gray-900">{{ number_format($stats['total_mutations']) }}</p>
        </div>

        <!-- Pending Mutations -->
        <div class="bg-white/80 backdrop-blur-xl border border-amber-100 rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(251,191,36,0.15)] hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-50 rounded-full blur-2xl opacity-60"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center ring-1 ring-amber-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                @if($stats['pending_mutations'] > 0)
                <span class="text-xs font-bold text-amber-700 bg-amber-100 px-2.5 py-1 rounded-full animate-pulse">Action Required</span>
                @endif
            </div>
            <h3 class="text-gray-600 font-medium text-sm mb-1 relative z-10">Pending Mutations</h3>
            <p class="font-heading font-extrabold text-4xl text-amber-600 relative z-10">{{ number_format($stats['pending_mutations']) }}</p>
        </div>

    </div>

    <!-- Quick Links -->
    <div class="flex flex-col sm:flex-row gap-4">
        <a href="{{ route('admin.documents.index') }}" class="inline-flex justify-center items-center px-6 py-3 bg-primary text-white font-bold rounded-xl shadow-[0_4px_14px_0_rgba(220,38,38,0.39)] hover:shadow-[0_6px_20px_rgba(220,38,38,0.23)] hover:bg-red-700 hover:-translate-y-0.5 transition-all">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Verify Documents
        </a>
        <a href="{{ route('admin.mutations.index') }}" class="inline-flex justify-center items-center px-6 py-3 bg-white text-gray-700 font-bold rounded-xl border border-gray-200 shadow-sm hover:bg-gray-50 hover:-translate-y-0.5 transition-all">
            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            Review Mutations
        </a>
    </div>

</div>
@endsection
