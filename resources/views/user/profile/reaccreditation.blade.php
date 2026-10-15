<x-profile-layout title="Reakreditasi Staff & Pelatih">
    
    {{-- Notice jika Akun adalah Atlet --}}
    @if($isAthlete ?? false)
        <div class="bg-amber-50/80 backdrop-blur-sm border border-amber-200 text-amber-900 p-6 rounded-3xl mb-6 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="p-2.5 rounded-2xl bg-amber-100 text-amber-700 flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-base text-gray-900">Pengajuan Reakreditasi Khusus Staff, Pelatih & SDM</h4>
                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">
                        Menu pengajuan re-akreditasi lisensi diperuntukkan khusus bagi anggota dengan klasifikasi peran <strong>SDM (Pelatih, Wasit, Official, Staff Teknis)</strong>.
                    </p>
                    <p class="text-xs text-gray-500 mt-3">
                        Klasifikasi akun Anda saat ini adalah <strong>Atlet</strong>. Jika Anda adalah staf teknis/pelatih yang ingin mengajukan reakreditasi lisensi, silakan ubah klasifikasi peran Anda di halaman <a href="{{ route('user.profile.general') }}" class="text-red-600 underline font-bold hover:text-red-700">Profil Umum</a>.
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Status Banner jika ada Proposal Pending --}}
    @if($pendingProposal)
        <div class="bg-blue-50/90 backdrop-blur-md border border-blue-200 text-blue-900 p-6 rounded-3xl mb-6 shadow-[0_4px_20px_rgba(59,130,246,0.08)]">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="p-3 rounded-2xl bg-blue-100 text-blue-700 flex-shrink-0">
                        <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-blue-100 text-blue-800 border border-blue-300">
                                Menunggu Verifikasi
                            </span>
                            <span class="text-xs text-gray-500 font-medium">{{ $pendingProposal->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <h4 class="font-heading font-extrabold text-lg text-gray-900">Pengajuan Reakreditasi Aktif</h4>
                        <p class="text-sm text-gray-600 mt-0.5">
                            Role: <strong class="text-gray-900">{{ $pendingProposal->role }}</strong> &bull; Lisensi: <strong class="text-gray-900">{{ $pendingProposal->applied_license }}</strong> &bull; Jalur: <strong class="text-gray-900">{{ $pendingProposal->track }}</strong>
                        </p>
                    </div>
                </div>

                <form action="{{ route('user.reaccreditations.destroy', $pendingProposal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini? Berkas yang telah diunggah akan dihapus.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-white text-red-600 hover:bg-red-50 text-xs font-bold rounded-xl border border-red-200 shadow-sm transition-all hover:scale-105">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Batalkan Pengajuan
                    </button>
                </form>
            </div>
        </div>
    @endif

    {{-- Form Pengajuan Reakreditasi (Tampil jika belum ada pending proposal) --}}
    @if(!$pendingProposal)
        <div class="bg-white/90 backdrop-blur-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl transition-all mb-8">
            <div class="p-6 md:p-8">
                <div class="mb-6">
                    <h3 class="font-heading font-extrabold text-xl text-gray-900 tracking-tight">Form Pengajuan Reakreditasi</h3>
                    <p class="text-sm text-gray-500 mt-1">Lengkapi data role, lisensi yang diajukan, jalur reakreditasi, dan unggah 5 berkas persyaratan.</p>
                </div>

                <form action="{{ route('user.reaccreditations.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Baris 1: Informasi Reakreditasi --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        {{-- Role Re-Akreditasi --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">
                                Role Re-Akreditasi <span class="text-red-500">*</span>
                            </label>
                            <select name="role" required class="w-full rounded-2xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-all text-sm py-2.5">
                                <option value="">-- Pilih Role --</option>
                                @foreach(config('dropdown.reaccreditation_roles', []) as $rRole)
                                    <option value="{{ $rRole }}" {{ old('role') === $rRole ? 'selected' : '' }}>{{ $rRole }}</option>
                                @endforeach
                            </select>
                            @error('role') <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        {{-- Lisensi yang diajukan --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">
                                Lisensi yang diajukan <span class="text-red-500">*</span>
                            </label>
                            <select name="applied_license" required class="w-full rounded-2xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-all text-sm py-2.5">
                                <option value="">-- Pilih Lisensi --</option>
                                @foreach(config('dropdown.reaccreditation_licenses', []) as $rLic)
                                    <option value="{{ $rLic }}" {{ old('applied_license') === $rLic ? 'selected' : '' }}>{{ $rLic }}</option>
                                @endforeach
                            </select>
                            @error('applied_license') <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        {{-- Jalur Re-Akreditasi --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">
                                Jalur Re-Akreditasi <span class="text-red-500">*</span>
                            </label>
                            <select name="track" required class="w-full rounded-2xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-all text-sm py-2.5">
                                <option value="">-- Pilih Jalur --</option>
                                @foreach(config('dropdown.reaccreditation_tracks', []) as $rTrack)
                                    <option value="{{ $rTrack }}" {{ old('track') === $rTrack ? 'selected' : '' }}>{{ $rTrack }}</option>
                                @endforeach
                            </select>
                            @error('track') <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Baris 2: Daftar Dokumen Upload --}}
                    <div class="border-t border-gray-100 pt-6 mb-8">
                        <div class="mb-5">
                            <h4 class="font-heading font-extrabold text-base text-gray-900 tracking-tight">Daftar Dokumen Upload</h4>
                            <p class="text-xs text-gray-500 mt-0.5">Format file: <strong>PDF, JPG, JPEG, atau PNG</strong> (Ukuran maksimal 5MB per berkas).</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- 1. Lisensi Terakhir --}}
                            <div class="bg-gray-50/70 p-4 rounded-2xl border border-gray-100 hover:border-gray-200 transition-all">
                                <label class="block text-sm font-bold text-gray-800 mb-1">
                                    1. Lisensi Terakhir <span class="text-red-500">*</span>
                                </label>
                                <p class="text-xs text-gray-500 mb-2.5">Scan/salinan lisensi keolahragaan terakhir yang Anda pegang.</p>
                                <input type="file" name="last_license_file" required accept=".pdf,.jpg,.jpeg,.png"
                                       class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-white file:text-gray-700 hover:file:bg-gray-100 file:shadow-sm file:border file:border-gray-200 transition-colors">
                                @error('last_license_file') <p class="mt-1.5 text-xs text-red-600 font-semibold">{{ $message }}</p> @enderror
                            </div>

                            {{-- 2. Sertifikat Event --}}
                            <div class="bg-gray-50/70 p-4 rounded-2xl border border-gray-100 hover:border-gray-200 transition-all">
                                <label class="block text-sm font-bold text-gray-800 mb-1">
                                    2. Sertifikat Event <span class="text-red-500">*</span>
                                </label>
                                <p class="text-xs text-gray-500 mb-2.5">Bukti partisipasi atau tugas pada kejuaraan/event resmi.</p>
                                <input type="file" name="event_certificate_file" required accept=".pdf,.jpg,.jpeg,.png"
                                       class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-white file:text-gray-700 hover:file:bg-gray-100 file:shadow-sm file:border file:border-gray-200 transition-colors">
                                @error('event_certificate_file') <p class="mt-1.5 text-xs text-red-600 font-semibold">{{ $message }}</p> @enderror
                            </div>

                            {{-- 3. Proyek Program --}}
                            <div class="bg-gray-50/70 p-4 rounded-2xl border border-gray-100 hover:border-gray-200 transition-all">
                                <label class="block text-sm font-bold text-gray-800 mb-1">
                                    3. Proyek Program <span class="text-red-500">*</span>
                                </label>
                                <p class="text-xs text-gray-500 mb-2.5">Laporan proyek, rancangan program latihan, atau portofolio.</p>
                                <input type="file" name="program_project_file" required accept=".pdf,.jpg,.jpeg,.png"
                                       class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-white file:text-gray-700 hover:file:bg-gray-100 file:shadow-sm file:border file:border-gray-200 transition-colors">
                                @error('program_project_file') <p class="mt-1.5 text-xs text-red-600 font-semibold">{{ $message }}</p> @enderror
                            </div>

                            {{-- 4. Persyaratan Khusus --}}
                            <div class="bg-gray-50/70 p-4 rounded-2xl border border-gray-100 hover:border-gray-200 transition-all">
                                <label class="block text-sm font-bold text-gray-800 mb-1">
                                    4. Persyaratan Khusus <span class="text-red-500">*</span>
                                </label>
                                <p class="text-xs text-gray-500 mb-2.5">Dokumen syarat tambahan sesuai tingkatan lisensi yang diajukan.</p>
                                <input type="file" name="special_requirements_file" required accept=".pdf,.jpg,.jpeg,.png"
                                       class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-white file:text-gray-700 hover:file:bg-gray-100 file:shadow-sm file:border file:border-gray-200 transition-colors">
                                @error('special_requirements_file') <p class="mt-1.5 text-xs text-red-600 font-semibold">{{ $message }}</p> @enderror
                            </div>

                            {{-- 5. Rekomendasi --}}
                            <div class="bg-gray-50/70 p-4 rounded-2xl border border-gray-100 hover:border-gray-200 transition-all md:col-span-2">
                                <label class="block text-sm font-bold text-gray-800 mb-1">
                                    5. Surat Rekomendasi <span class="text-red-500">*</span>
                                </label>
                                <p class="text-xs text-gray-500 mb-2.5">Surat rekomendasi dari Pengcab/Pengprov/Asosiasi Bola Tangan terkait.</p>
                                <input type="file" name="recommendation_file" required accept=".pdf,.jpg,.jpeg,.png"
                                       class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-white file:text-gray-700 hover:file:bg-gray-100 file:shadow-sm file:border file:border-gray-200 transition-colors">
                                @error('recommendation_file') <p class="mt-1.5 text-xs text-red-600 font-semibold">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-6 py-3.5 bg-primary text-white text-sm font-bold rounded-2xl shadow-[0_4px_14px_0_rgba(220,38,38,0.39)] hover:shadow-[0_6px_20px_rgba(220,38,38,0.23)] hover:bg-red-700 hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Kirim Pengajuan Reakreditasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Riwayat Pengajuan Reakreditasi --}}
    <div class="bg-white/90 backdrop-blur-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl transition-all">
        <div class="p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-heading font-extrabold text-xl text-gray-900 tracking-tight">Riwayat Pengajuan Reakreditasi</h3>
                    <p class="text-sm text-gray-500 mt-0.5">Daftar seluruh proposal re-akreditasi lisensi yang pernah Anda ajukan.</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-gray-100 text-gray-700">
                    Total: {{ $reaccreditations->count() }}
                </span>
            </div>

            @if($reaccreditations->isEmpty())
                <div class="text-center py-12 border-2 border-dashed border-gray-100 rounded-3xl">
                    <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-gray-50 flex items-center justify-center text-gray-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <p class="text-sm font-bold text-gray-700">Belum Ada Pengajuan Reakreditasi</p>
                    <p class="text-xs text-gray-400 mt-1">Gunakan formulir di atas untuk mengajukan re-akreditasi lisensi pertama Anda.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-[11px] font-extrabold uppercase tracking-wider text-gray-400">
                                <th class="py-3 px-4">Role & Lisensi</th>
                                <th class="py-3 px-4">Jalur</th>
                                <th class="py-3 px-4">Dokumen Persyaratan</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Tanggal Pengajuan</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @foreach($reaccreditations as $item)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 px-4 font-bold text-gray-900">
                                        <div>{{ $item->role }}</div>
                                        <div class="text-xs font-semibold text-red-600 mt-0.5">Lisensi {{ $item->applied_license }}</div>
                                    </td>
                                    <td class="py-4 px-4 text-gray-700 font-medium">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold bg-gray-100 text-gray-800">
                                            {{ $item->track }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex flex-wrap gap-1.5 max-w-xs">
                                            @if($item->last_license_file)
                                                <a href="{{ asset('storage/' . $item->last_license_file) }}" target="_blank" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-bold bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors">
                                                    <span>Lisensi</span>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                </a>
                                            @endif
                                            @if($item->event_certificate_file)
                                                <a href="{{ asset('storage/' . $item->event_certificate_file) }}" target="_blank" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-bold bg-purple-50 text-purple-700 hover:bg-purple-100 transition-colors">
                                                    <span>Sertifikat</span>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                </a>
                                            @endif
                                            @if($item->program_project_file)
                                                <a href="{{ asset('storage/' . $item->program_project_file) }}" target="_blank" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-colors">
                                                    <span>Proyek</span>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                </a>
                                            @endif
                                            @if($item->special_requirements_file)
                                                <a href="{{ asset('storage/' . $item->special_requirements_file) }}" target="_blank" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-bold bg-amber-50 text-amber-700 hover:bg-amber-100 transition-colors">
                                                    <span>Khusus</span>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                </a>
                                            @endif
                                            @if($item->recommendation_file)
                                                <a href="{{ asset('storage/' . $item->recommendation_file) }}" target="_blank" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-bold bg-teal-50 text-teal-700 hover:bg-teal-100 transition-colors">
                                                    <span>Rekomendasi</span>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        @if($item->status === 'verified')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-extrabold bg-green-50 text-green-700 border border-green-200">
                                                <svg class="w-3 h-3 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Terverifikasi
                                            </span>
                                        @elseif($item->status === 'rejected')
                                            <div>
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-extrabold bg-red-50 text-red-700 border border-red-200">
                                                    <svg class="w-3 h-3 mr-1 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    Ditolak
                                                </span>
                                                @if($item->admin_notes)
                                                    <p class="text-xs text-red-600 mt-1">Catatan: {{ $item->admin_notes }}</p>
                                                @endif
                                            </div>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-extrabold bg-blue-50 text-blue-700 border border-blue-200">
                                                <svg class="w-3 h-3 mr-1 text-blue-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                                                Menunggu Verifikasi
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 text-xs text-gray-500 font-medium">
                                        {{ $item->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="py-4 px-4 text-right">
                                        @if($item->status === 'pending')
                                            <form action="{{ route('user.reaccreditations.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Batalkan pengajuan ini?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-bold text-red-600 hover:text-red-800 p-1.5 rounded-lg hover:bg-red-50 transition-colors" title="Batalkan Pengajuan">
                                                    Hapus
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
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
