<x-profile-layout title="Dokumen Integritas">
    
    {{-- Form Tambah Dokumen --}}
    <div class="bg-white/90 backdrop-blur-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl transition-all mb-6">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Tambah Dokumen Integritas</h3>
            <p class="text-sm text-gray-500 mb-4">Upload dokumen pakta integritas, sertifikat anti doping, atau pernyataan anti perundungan.</p>

            <form action="{{ route('user.integrity-documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Jenis Dokumen <span class="text-red-500">*</span></label>
                        <select name="type" required class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                            <option value="">Pilih Jenis</option>
                            <option value="anti_doping" {{ old('type') == 'anti_doping' ? 'selected' : '' }}>Sertifikat Anti Doping</option>
                            <option value="pelecehan_seksual_dan_perundungan" {{ old('type') == 'pelecehan_seksual_dan_perundungan' ? 'selected' : '' }}>Pernyataan Anti Pelecehan & Perundungan</option>
                            <option value="pakta_integritas" {{ old('type') == 'pakta_integritas' ? 'selected' : '' }}>Pakta Integritas (Umum)</option>
                        </select>
                        @error('type') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal Ditandatangani <span class="text-red-500">*</span></label>
                        <input type="date" name="signed_date" required value="{{ old('signed_date') }}"
                               class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                        @error('signed_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Upload Dokumen <span class="text-red-500">*</span></label>
                        <input type="file" name="file" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" accept=".pdf,.jpg,.jpeg,.png">
                        @error('file') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                <button type="submit" class="inline-flex items-center px-5 py-2 bg-red-700 text-white text-sm font-semibold rounded-lg hover:bg-red-800 transition shadow-sm">
                    Upload Dokumen
                </button>
            </form>
        </div>
    </div>

    {{-- Daftar Dokumen --}}
    <div class="bg-white/90 backdrop-blur-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl transition-all">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Dokumen Integritas Saya</h3>

            @if($documents->count() === 0)
                <div class="text-center py-8">
                    <svg class="mx-auto w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <p class="text-gray-500 text-sm">Belum ada dokumen integritas yang ditambahkan.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Jenis Dokumen</th>
                                <th class="px-4 py-3">Tanggal TTD</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($documents as $doc)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">
                                    {{ str_replace('_', ' ', ucwords($doc->type)) }}
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ \Carbon\Carbon::parse($doc->signed_date)->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-xs font-medium">Lihat</a>
                                        <form action="{{ route('user.integrity-documents.destroy', $doc) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium">Hapus</button>
                                        </form>
                                    </div>
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
