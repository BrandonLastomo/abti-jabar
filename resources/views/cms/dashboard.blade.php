@extends('cms.layouts.master')

@section('title', 'Superadmin Dashboard')

@section('full_content')
<div class="p-6 lg:p-10 min-h-screen bg-gray-50/50">
    
    <!-- Dashboard Header -->
    <div class="mb-10 flex flex-col lg:flex-row lg:items-end justify-between gap-6">
        <div>
            <h1 class="font-heading font-extrabold text-4xl text-gray-900 tracking-tight mb-2">Dashboard Overview</h1>
            <p class="text-gray-500 font-medium">Welcome back, Superadmin! Here is what's happening today.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('hero.index') }}" class="inline-flex justify-center items-center px-5 py-2.5 bg-primary text-white font-bold rounded-xl shadow-[0_4px_14px_0_rgba(220,38,38,0.39)] hover:shadow-[0_6px_20px_rgba(220,38,38,0.23)] hover:bg-red-700 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 text-sm tracking-wide">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Manage Hero
            </a>
            <a href="{{ route('users.index') }}" class="inline-flex justify-center items-center px-5 py-2.5 bg-white text-gray-700 font-bold rounded-xl border border-gray-200 shadow-sm hover:bg-gray-50 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 text-sm tracking-wide">
                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Manage Users
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Total Users Card -->
        <div class="bg-white/80 backdrop-blur-xl border border-gray-100 rounded-3xl p-6 shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <span class="text-sm font-bold text-green-500 bg-green-50 px-2 py-1 rounded-full">+Active</span>
            </div>
            <h3 class="text-gray-500 font-medium text-sm mb-1">Total Registered Users</h3>
            <p class="font-heading font-extrabold text-4xl text-gray-900">{{ number_format($totalUsers) }}</p>
        </div>

        <!-- Total Clubs Card -->
        <div class="bg-white/80 backdrop-blur-xl border border-gray-100 rounded-3xl p-6 shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
            <h3 class="text-gray-500 font-medium text-sm mb-1">Total Clubs</h3>
            <p class="font-heading font-extrabold text-4xl text-gray-900">{{ number_format($totalClubs) }}</p>
        </div>

        <!-- Pending Mutations Card -->
        <div class="bg-white/80 backdrop-blur-xl border border-gray-100 rounded-3xl p-6 shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                @if($pendingMutations > 0)
                <span class="text-sm font-bold text-amber-600 bg-amber-100 px-2 py-1 rounded-full animate-pulse">Needs Review</span>
                @endif
            </div>
            <h3 class="text-gray-500 font-medium text-sm mb-1">Pending Mutations</h3>
            <p class="font-heading font-extrabold text-4xl text-gray-900">{{ number_format($pendingMutations) }}</p>
        </div>

        <!-- Verified Mutations Card -->
        <div class="bg-white/80 backdrop-blur-xl border border-gray-100 rounded-3xl p-6 shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-green-50 text-green-500 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <h3 class="text-gray-500 font-medium text-sm mb-1">Verified Mutations</h3>
            <p class="font-heading font-extrabold text-4xl text-gray-900">{{ number_format($verifiedMutations) }}</p>
        </div>
    </div>

    <!-- Main Content Area Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Recent Activity (Takes up 2 columns) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-gray-100 rounded-3xl shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <div>
                        <h2 class="font-heading font-bold text-lg text-gray-900">Latest Registered Users</h2>
                        <p class="text-sm text-gray-500">The newest members to join the platform.</p>
                    </div>
                    <a href="{{ route('users.index') }}" class="text-primary font-medium text-sm hover:underline flex items-center">
                        View All
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50/50 text-xs uppercase font-semibold text-gray-500">
                            <tr>
                                <th scope="col" class="px-6 py-4">Name</th>
                                <th scope="col" class="px-6 py-4">Email</th>
                                <th scope="col" class="px-6 py-4">Joined At</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($latestUsers as $u)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold">
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        </div>
                                        {{ $u->name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">{{ $u->email }}</td>
                                <td class="px-6 py-4">{{ $u->created_at->diffForHumans() }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">No users found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: System Config or Quick Links -->
        <div class="space-y-6">
            <div class="bg-gradient-to-br from-gray-900 to-[#1e2335] rounded-3xl p-8 shadow-xl text-white relative overflow-hidden">
                <!-- Decorative background elements -->
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-primary/20 blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-32 h-32 rounded-full bg-blue-500/20 blur-2xl"></div>
                
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center backdrop-blur-md border border-white/10 mb-6">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h3 class="font-heading font-extrabold text-2xl mb-2">Mutation Settings</h3>
                    <p class="text-gray-300 text-sm mb-6 leading-relaxed">Configure the mutation period, enable or disable submissions, and manage system-wide settings for athlete mutations.</p>
                    
                    <a href="{{ route('settings.index') }}" class="inline-flex items-center justify-center w-full px-5 py-3 bg-primary text-white font-bold rounded-xl shadow-[0_4px_14px_0_rgba(220,38,38,0.39)] hover:bg-red-700 transition-colors duration-300 text-sm tracking-wide">
                        Configure Now
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
