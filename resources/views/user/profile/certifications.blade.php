<x-profile-layout title="Sertifikasi & Lisensi">
    
    {{-- Form Tambah Sertifikasi --}}
    <div class="bg-white/90 backdrop-blur-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl transition-all mb-6"
         x-data="{
             category: '{{ old('category', 'Handball') }}'
         }">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Tambah Sertifikasi</h3>
            <p class="text-sm text-gray-500 mb-4">Tambahkan sertifikat/lisensi kepelatihan, perwasitan, atau keolahragaan yang Anda miliki.</p>

            <form action="{{ route('user.certifications.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    {{-- Kategori Sertifikasi (Handball / Non-Handball) --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Kategori Sertifikasi <span class="text-red-500">*</span></label>
                        <select name="category" x-model="category" required
                                class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                            @foreach(config('dropdown.certification_categories') as $cat)
                                <option value="{{ $cat }}" {{ old('category', 'Handball') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nama Sertifikasi --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Sertifikasi <span class="text-red-500">*</span></label>
                        <input type="text" name="certification_name" required value="{{ old('certification_name') }}"
                               placeholder="Contoh: Lisensi Pelatih Nasional / Workshop Sport Science"
                               class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                        @error('certification_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nomor Sertifikat / Lisensi --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nomor Sertifikat / Lisensi <span class="text-red-500">*</span></label>
                        <input type="text" name="certification_number" required value="{{ old('certification_number') }}"
                               placeholder="Contoh: CERT-2024-00123"
                               class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                        @error('certification_number') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Penyelenggara / Organizer --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Penyelenggara / Organizer <span class="text-red-500">*</span></label>
                        <input type="text" name="organizer" required value="{{ old('organizer') }}"
                               placeholder="Contoh: PP ABTI / IHF / Kemenpora"
                               class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                        @error('organizer') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Role (Handball / Non-Handball) --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
                        
                        {{-- Handball Roles --}}
                        <select name="role" x-show="category === 'Handball'" :disabled="category !== 'Handball'"
                                {{ old('category', 'Handball') !== 'Handball' ? 'disabled style=display:none;' : '' }}
                                required class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                            <option value="">Pilih Role</option>
                            @foreach(config('dropdown.certification_handball_roles') as $role)
                                <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>

                        {{-- Non-Handball Roles --}}
                        <select name="role" x-show="category === 'Non-Handball'" :disabled="category !== 'Non-Handball'"
                                {{ old('category', 'Handball') !== 'Non-Handball' ? 'disabled style=display:none;' : '' }}
                                required class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                            <option value="">Pilih Role</option>
                            @foreach(config('dropdown.certification_non_handball_roles') as $role)
                                <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>
                        @error('role') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Course / Detail (Handball: Course, Non-Handball: Detail) --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">
                            <span x-text="category === 'Handball' ? 'Course' : 'Detail'">{{ old('category', 'Handball') === 'Non-Handball' ? 'Detail' : 'Course' }}</span> <span class="text-red-500">*</span>
                        </label>

                        {{-- Handball Course --}}
                        <select name="course" x-show="category === 'Handball'" :disabled="category !== 'Handball'"
                                {{ old('category', 'Handball') !== 'Handball' ? 'disabled style=display:none;' : '' }}
                                required class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                            <option value="">Pilih Course</option>
                            @foreach(config('dropdown.certification_handball_courses') as $course)
                                <option value="{{ $course }}" {{ old('course') == $course ? 'selected' : '' }}>{{ $course }}</option>
                            @endforeach
                        </select>

                        {{-- Non-Handball Detail --}}
                        <select name="course" x-show="category === 'Non-Handball'" :disabled="category !== 'Non-Handball'"
                                {{ old('category', 'Handball') !== 'Non-Handball' ? 'disabled style=display:none;' : '' }}
                                required class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                            <option value="">Pilih Detail</option>
                            @foreach(config('dropdown.certification_non_handball_courses') as $course)
                                <option value="{{ $course }}" {{ old('course') == $course ? 'selected' : '' }}>{{ $course }}</option>
                            @endforeach
                        </select>
                        @error('course') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Level --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Level <span class="text-red-500">*</span></label>
                        <select name="level" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                            <option value="">Pilih Level</option>
                            @foreach(config('dropdown.certification_levels') as $lvl)
                                <option value="{{ $lvl }}" {{ old('level') == $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                            @endforeach
                        </select>
                        @error('level') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Number --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Number <span class="text-red-500">*</span></label>
                        <select name="number" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                            <option value="">Pilih Number</option>
                            @foreach(config('dropdown.certification_numbers') as $num)
                                <option value="{{ $num }}" {{ old('number') == $num ? 'selected' : '' }}>{{ $num }}</option>
                            @endforeach
                        </select>
                        @error('number') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tanggal Diterbitkan --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Diterbitkan <span class="text-red-500">*</span></label>
                        <input type="date" name="date_of_issue" required value="{{ old('date_of_issue') }}"
                               class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                        @error('date_of_issue') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kab / Kota Lokasi --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Kab / Kota Lokasi <span class="text-red-500">*</span></label>
                        <select name="regency" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                            <option value="">Pilih Kab / Kota</option>
                            @foreach(config('dropdown.other_regencies') as $reg)
                                <option value="{{ $reg }}" {{ old('regency') == $reg ? 'selected' : '' }}>{{ $reg }}</option>
                            @endforeach
                        </select>
                        @error('regency') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Provinsi Lokasi --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Provinsi Lokasi <span class="text-red-500">*</span></label>
                        <select name="province" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                            <option value="">Pilih Provinsi</option>
                            @foreach(config('dropdown.provinces') as $prov)
                                <option value="{{ $prov }}" {{ old('province') == $prov ? 'selected' : '' }}>{{ $prov }}</option>
                            @endforeach
                        </select>
                        @error('province') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    {{-- Upload File --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Upload Sertifikat <span class="text-red-500">*</span></label>
                        <input type="file" name="file" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" accept=".pdf,.jpg,.jpeg,.png">
                        <p class="text-xs text-gray-400 mt-1">Format: PDF, JPG, JPEG, PNG (Maksimal 5MB)</p>
                        @error('file') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <button type="submit" class="inline-flex items-center px-5 py-2 bg-red-700 text-white text-sm font-semibold rounded-lg hover:bg-red-800 transition shadow-sm">
                    Upload Sertifikasi
                </button>
            </form>
        </div>
    </div>

    {{-- Daftar Sertifikasi --}}
    <div class="bg-white/90 backdrop-blur-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl transition-all">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Sertifikasi & Lisensi Saya</h3>

            @if($certifications->count() === 0)
                <div class="text-center py-8">
                    <svg class="mx-auto w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    <p class="text-gray-500 text-sm">Belum ada sertifikasi yang ditambahkan.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Sertifikasi & Kategori</th>
                                <th class="px-4 py-3">Role & Course/Detail</th>
                                <th class="px-4 py-3">Level & Number</th>
                                <th class="px-4 py-3">Penyelenggara & Lokasi</th>
                                <th class="px-4 py-3">Tanggal Terbit</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($certifications as $cert)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $cert->certification_name }}</div>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        @if(($cert->category ?? 'Handball') === 'Handball')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-red-50 text-red-700 border border-red-200">Handball</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">Non-Handball</span>
                                        @endif
                                        <span class="text-xs text-gray-500">No: {{ $cert->certification_number }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $cert->role ?? $cert->type ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ ($cert->category ?? 'Handball') === 'Non-Handball' ? 'Detail' : 'Course' }}: 
                                        <span class="font-medium text-gray-700">{{ $cert->course ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $cert->level ?? '-' }}</div>
                                    @if($cert->number)
                                        <div class="text-xs text-gray-500">Number: <span class="font-medium text-gray-700">{{ $cert->number }}</span></div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    <div class="font-medium text-gray-900">{{ $cert->organizer }}</div>
                                    <div class="text-xs text-gray-500">{{ $cert->regency }}, {{ $cert->province }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ \Carbon\Carbon::parse($cert->date_of_issue)->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2 mb-1">
                                        <a href="{{ asset('storage/' . $cert->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-xs font-medium">Lihat Dokumen</a>
                                        <form action="{{ route('user.certifications.destroy', $cert) }}" method="POST" onsubmit="return confirm('Hapus sertifikasi ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium">Hapus</button>
                                        </form>
                                    </div>
                                    <x-verification-badge :model="$cert" field="file_path" />
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
