<x-profile-layout title="Pengalaman Event / Kejuaraan">
    
    {{-- Form Tambah Pengalaman Event --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Tambah Pengalaman Kejuaraan</h3>
            <p class="text-sm text-gray-500 mb-4">Tambahkan riwayat kejuaraan atau event yang pernah Anda ikuti.</p>

            <form action="{{ route('user.event-experiences.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kejuaraan / Event <span class="text-red-500">*</span></label>
                        <input type="text" name="event_name" required value="{{ old('event_name') }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                        @error('event_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Tim (Yang Dibela) <span class="text-red-500">*</span></label>
                        <input type="text" name="team_name" required value="{{ old('team_name') }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                        @error('team_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kab / Kota Penyelenggara <span class="text-red-500">*</span></label>
                        <select name="event_regency" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                            <option value="">Pilih Kab / Kota</option>
                            @foreach(config('dropdown.other_regencies') as $reg)
                                <option value="{{ $reg }}" {{ old('event_regency') == $reg ? 'selected' : '' }}>{{ $reg }}</option>
                            @endforeach
                        </select>
                        @error('event_regency') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi Penyelenggara <span class="text-red-500">*</span></label>
                        <select name="event_province" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                            <option value="">Pilih Provinsi</option>
                            @foreach(config('dropdown.provinces') as $prov)
                                <option value="{{ $prov }}" {{ old('event_province') == $prov ? 'selected' : '' }}>{{ $prov }}</option>
                            @endforeach
                        </select>
                        @error('event_province') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Peran di Event <span class="text-red-500">*</span></label>
                        <select name="event_role" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                            <option value="">Pilih Peran</option>
                            @foreach(config('dropdown.event_roles') as $opt)
                                <option value="{{ $opt }}" {{ old('event_role') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                        @error('event_role') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Lapangan <span class="text-red-500">*</span></label>
                        <select name="court_type" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                            <option value="">Pilih Jenis</option>
                            @foreach(config('dropdown.court_types') as $opt)
                                <option value="{{ $opt }}" {{ old('court_type') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                        @error('court_type') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Format Event <span class="text-red-500">*</span></label>
                        <select name="event_format" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                            <option value="">Pilih Format</option>
                            @foreach(config('dropdown.event_formats') as $opt)
                                <option value="{{ $opt }}" {{ old('event_format') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                        @error('event_format') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat Kompetisi <span class="text-red-500">*</span></label>
                        <select name="competition_level" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                            <option value="">Pilih Tingkat</option>
                            @foreach(config('dropdown.competition_levels') as $opt)
                                <option value="{{ $opt }}" {{ old('competition_level') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                        @error('competition_level') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lingkup Peserta <span class="text-red-500">*</span></label>
                        <select name="participant_scope" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                            <option value="">Pilih Lingkup</option>
                            @foreach(config('dropdown.participant_scopes') as $opt)
                                <option value="{{ $opt }}" {{ old('participant_scope') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                        @error('participant_scope') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Usia <span class="text-red-500">*</span></label>
                        <select name="age_category" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                            <option value="">Pilih Kategori</option>
                            @foreach(config('dropdown.age_categories') as $opt)
                                <option value="{{ $opt }}" {{ old('age_category') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                        @error('age_category') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <input type="date" name="event_start_date" required value="{{ old('event_start_date') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                        @error('event_start_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <input type="date" name="event_end_date" value="{{ old('event_end_date') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                        @error('event_end_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hasil / Pencapaian <span class="text-red-500">*</span></label>
                        <select name="result" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                            <option value="">Pilih Hasil</option>
                            @foreach(config('dropdown.results') as $opt)
                                <option value="{{ $opt }}" {{ old('result') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                        @error('result') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                </div>
                <button type="submit" class="inline-flex items-center px-5 py-2 bg-red-700 text-white text-sm font-semibold rounded-lg hover:bg-red-800 transition shadow-sm">
                    Tambah Pengalaman Event
                </button>
            </form>
        </div>
    </div>

    {{-- Daftar Pengalaman --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Riwayat Event Saya</h3>

            @if($experiences->count() === 0)
                <div class="text-center py-8">
                    <svg class="mx-auto w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <p class="text-gray-500 text-sm">Belum ada pengalaman event yang ditambahkan.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Nama Event</th>
                                <th class="px-4 py-3">Tim / Kota</th>
                                <th class="px-4 py-3">Peran / Kategori</th>
                                <th class="px-4 py-3">Hasil</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3 w-20">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($experiences as $exp)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $exp->event_name }}</div>
                                    <div class="text-xs text-gray-500 capitalize">{{ $exp->competition_level }} - {{ $exp->event_format }} ({{ $exp->court_type }})</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $exp->team_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $exp->event_regency }}, {{ $exp->event_province }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900 capitalize">{{ $exp->event_role }}</div>
                                    <div class="text-xs text-gray-500 capitalize">{{ $exp->participant_scope }} - {{ $exp->age_category }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded bg-gray-100 text-gray-800 capitalize">{{ $exp->result }}</span>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ \Carbon\Carbon::parse($exp->event_start_date)->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('user.event-experiences.destroy', $exp) }}" method="POST" onsubmit="return confirm('Hapus pengalaman event ini?')">
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
