<x-profile-layout title="Pengalaman Tim">
    
    {{-- Form Tambah Pengalaman --}}
    <div class="bg-white/90 backdrop-blur-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl transition-all mb-6">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Tambah Pengalaman Tim</h3>
            <p class="text-sm text-gray-500 mb-4">Tambahkan riwayat tim yang pernah Anda bela atau latih.</p>

            <form action="{{ route('user.team-experiences.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="team_name" class="block text-sm font-bold text-gray-700 mb-1">Nama Tim <span class="text-red-500">*</span></label>
                        <input type="text" name="team_name" id="team_name" required value="{{ old('team_name') }}"
                               class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                        @error('team_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="team_type" class="block text-sm font-bold text-gray-700 mb-1">Kategori Tim <span class="text-red-500">*</span></label>
                        <select name="team_type" id="team_type" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                            <option value="">Pilih Kategori</option>
                            <option value="nasional" {{ old('team_type') == 'nasional' ? 'selected' : '' }}>Nasional (Timnas)</option>
                            <option value="provinsi" {{ old('team_type') == 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                            <option value="kab/kota" {{ old('team_type') == 'kab/kota' ? 'selected' : '' }}>Kabupaten / Kota</option>
                            <option value="klub" {{ old('team_type') == 'klub' ? 'selected' : '' }}>Klub</option>
                        </select>
                        @error('team_type') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="start_date" class="block text-sm font-bold text-gray-700 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" id="start_date" required value="{{ old('start_date') }}"
                               class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                        @error('start_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-bold text-gray-700 mb-1">Tanggal Selesai <span class="text-gray-400 font-normal">(Kosongkan jika masih aktif)</span></label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                               class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                        @error('end_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <button type="submit" class="inline-flex items-center px-5 py-2 bg-red-700 text-white text-sm font-semibold rounded-lg hover:bg-red-800 transition shadow-sm">
                    Tambah Pengalaman
                </button>
            </form>
        </div>
    </div>

    {{-- Daftar Pengalaman --}}
    <div class="bg-white/90 backdrop-blur-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl transition-all">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Riwayat Tim Saya</h3>

            @if($experiences->count() === 0)
                <div class="text-center py-8">
                    <svg class="mx-auto w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p class="text-gray-500 text-sm">Belum ada pengalaman tim yang ditambahkan.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Nama Tim</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Periode</th>
                                <th class="px-4 py-3 w-20">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($experiences as $exp)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $exp->team_name }}</td>
                                <td class="px-4 py-3 capitalize text-gray-600">{{ $exp->team_type }}</td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} - 
                                    {{ $exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('M Y') : 'Sekarang' }}
                                </td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('user.team-experiences.destroy', $exp) }}" method="POST" onsubmit="return confirm('Hapus pengalaman ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-profile-layout>
