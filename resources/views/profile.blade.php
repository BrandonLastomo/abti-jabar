@extends('layouts.app')
@section('content')
@php 
    use Carbon\Carbon;
    Carbon::setLocale('id'); 
@endphp

<main class="w-full bg-gray-50 overflow-hidden min-h-screen">
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <div class="mb-8">
      <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Profile Tim</h1>
      
      <!-- Category Tabs -->
      <div class="flex flex-col md:flex-row gap-4 md:gap-0 bg-white border border-gray-100 p-4 md:p-0 shadow-sm rounded-lg overflow-hidden">
        
        <div class="flex flex-col w-full md:w-1/4 border-r border-gray-100 bg-gray-50/50">
          <a href="{{ route('profile', ['category' => 'indoor', 'subcategory' => 'Senior putra']) }}" 
             class="px-6 py-4 text-sm font-bold {{ $category === 'indoor' ? 'bg-gray-100 text-gray-900 border-l-4 border-red-600' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900 border-l-4 border-transparent' }} transition">
            Westjava Indoor
          </a>
          <a href="{{ route('profile', ['category' => 'beach', 'subcategory' => 'Senior putra']) }}" 
             class="px-6 py-4 text-sm font-bold {{ $category === 'beach' ? 'bg-gray-100 text-gray-900 border-l-4 border-red-600' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900 border-l-4 border-transparent' }} transition">
            Westjava Beach
          </a>
          <a href="{{ route('profile', ['category' => 'wheelchair', 'subcategory' => 'Lihat Semua Tim']) }}" 
             class="px-6 py-4 text-sm font-bold {{ $category === 'wheelchair' ? 'bg-gray-100 text-gray-900 border-l-4 border-red-600' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-900 border-l-4 border-transparent' }} transition">
            Westjava wheelchair
          </a>
        </div>

        <!-- Subcategories -->
        <div class="flex-1 p-4 md:p-6 bg-white flex flex-wrap gap-2 content-start">
          @if(isset($subcategories[$category]))
            @foreach($subcategories[$category] as $sub)
              <a href="{{ route('profile', ['category' => $category, 'subcategory' => $sub]) }}" 
                 class="px-4 py-2 text-sm font-medium rounded-md transition {{ $subcategory === $sub ? 'bg-gray-200 text-gray-900' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                {{ $sub }}
              </a>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </section>

  <!-- Red Divider -->
  <div class="w-full h-px bg-red-600"></div>

  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-white mt-1">
    
    <div class="mb-10">
      <h2 class="text-2xl md:text-3xl font-medium text-gray-800 mb-6">
        Westjava {{ ucfirst($category) }} <span class="text-gray-400">『</span>{{ $subcategory }}<span class="text-gray-400">』</span>
      </h2>

      <!-- Team Photo -->
      <div class="w-full bg-gray-100 rounded-lg flex flex-col items-center justify-center p-12 min-h-[400px] md:min-h-[600px] overflow-hidden relative">
        @if($teamProfile && $teamProfile->picture)
          <img src="{{ asset('storage/'.$teamProfile->picture) }}" alt="Foto Tim {{ $subcategory }}" class="absolute inset-0 w-full h-full object-cover">
        @else
          <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
          <h3 class="text-gray-400 font-medium text-lg">Foto Tim {{ $subcategory }}</h3>
          <p class="text-gray-400 text-sm mt-2">[Placeholder for Official Team Photo]</p>
        @endif
      </div>
    </div>

    <!-- Aktivitas & Jadwal -->
    <div class="w-full">
      <h3 class="text-xl font-bold text-gray-900 mb-4">Aktivitas & Jadwal</h3>
      <div class="w-full h-px bg-gray-200 mb-8"></div>

      @forelse($groupedEvents as $year => $eventsInYear)
        <div class="mb-10">
          <h4 class="text-red-600 font-bold text-xl mb-4">{{ $year }}</h4>
          <div class="overflow-x-auto rounded border border-gray-100 shadow-sm">
            <table class="w-full text-left text-sm text-gray-600">
              <thead class="bg-gray-50 text-gray-900 border-b border-gray-100">
                <tr>
                  <th scope="col" class="px-6 py-4 font-bold">Tanggal</th>
                  <th scope="col" class="px-6 py-4 font-bold">Nama Kegiatan</th>
                  <th scope="col" class="px-6 py-4 font-bold">Lokasi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100">
                @foreach($eventsInYear as $event)
                  <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                      {{ $event->event_date ? Carbon::parse($event->event_date)->translatedFormat('F Y') : Carbon::parse($event->created_at)->translatedFormat('F Y') }}
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900">
                      {{ $event->name }}
                    </td>
                    <td class="px-6 py-4">
                      {{ $event->loc ?? '-' }}
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      @empty
        <div class="text-center py-12 text-gray-500">
          Belum ada jadwal aktivitas untuk tim ini.
        </div>
      @endforelse

    </div>

  </section>
</main>
@endsection