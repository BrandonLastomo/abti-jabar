<x-auth-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil Saya
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

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

            {{-- ====== USER INFO CARD ====== --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 rounded-full bg-red-700 flex items-center justify-center text-white font-bold text-2xl flex-shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ ucfirst($user->getRoleNames()->first() ?? 'user') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ====== UPLOAD DOCUMENT FORM ====== --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Upload Dokumen</h3>
                    <p class="text-sm text-gray-500 mb-4">Upload dokumen yang diperlukan untuk proses verifikasi. Maks 5MB per file.</p>

                    <form action="{{ route('user.documents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="file_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Dokumen <span class="text-red-500">*</span></label>
                                <input type="text" name="file_name" id="file_name" required
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm"
                                       placeholder="Contoh: KTP, Sertifikat, dll">
                                @error('file_name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="document" class="block text-sm font-medium text-gray-700 mb-1">File <span class="text-red-500">*</span></label>
                                <input type="file" name="document" id="document" required
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100"
                                       accept=".pdf,.jpg,.jpeg,.png,.webp,.doc,.docx">
                                @error('document')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <button type="submit"
                                class="inline-flex items-center px-5 py-2.5 bg-red-700 text-white text-sm font-semibold rounded-lg hover:bg-red-800 transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Upload Dokumen
                        </button>
                    </form>
                </div>
            </div>

            {{-- ====== DOCUMENTS LIST ====== --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Dokumen Saya</h3>

                    @if($documents->count() === 0)
                        <div class="text-center py-8">
                            <svg class="mx-auto w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500 text-sm">Belum ada dokumen. Upload dokumen pertama Anda di atas.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                                    <tr>
                                        <th class="px-4 py-3">Nama Dokumen</th>
                                        <th class="px-4 py-3">Tipe</th>
                                        <th class="px-4 py-3">Ukuran</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">Catatan</th>
                                        <th class="px-4 py-3">Tanggal Upload</th>
                                        <th class="px-4 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($documents as $doc)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $doc->file_name }}</td>
                                        <td class="px-4 py-3 uppercase text-gray-500">{{ $doc->file_type }}</td>
                                        <td class="px-4 py-3 text-gray-500">{{ number_format($doc->file_size / 1024, 1) }} KB</td>
                                        <td class="px-4 py-3">
                                            @if($doc->status === 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                    <svg class="w-3 h-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                                    </svg>
                                                    Menunggu Verifikasi
                                                </span>
                                            @elseif($doc->status === 'verified')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Terverifikasi
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Ditolak
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-gray-500 text-xs max-w-[150px] truncate">{{ $doc->notes ?? '-' }}</td>
                                        <td class="px-4 py-3 text-gray-500">{{ $doc->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                                   class="text-blue-600 hover:text-blue-800 text-xs font-medium">Lihat</a>
                                                @if($doc->status === 'pending')
                                                <form action="{{ route('user.documents.destroy', $doc) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium">Hapus</button>
                                                </form>
                                                @endif
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

            {{-- ====== MUTATION PROPOSAL ====== --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Transfer/Mutation Proposal</h3>
                    <p class="text-sm text-gray-500 mb-4">Pengajuan mutasi atau transfer atlet yang hanya dapat dilakukan 4 tahun sekali.</p>

                    @if($mutation_open !== '1')
                        <div class="bg-gray-50 border border-gray-200 text-gray-600 px-4 py-4 rounded-lg text-sm text-center">
                            Pendaftaran Transfer/Mutation Proposal saat ini <strong>ditutup</strong> oleh Administrator.
                        </div>
                    @elseif(!$can_propose_mutation)
                        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-4 rounded-lg text-sm">
                            <p class="font-bold mb-1">Anda sudah mengajukan proposal mutasi dalam 4 tahun terakhir.</p>
                            <p>Status Proposal Terakhir: <strong>{{ ucfirst($mutation_proposal->status) }}</strong></p>
                            @if($mutation_proposal->admin_notes)
                                <p class="mt-2 text-xs">Catatan Admin: {{ $mutation_proposal->admin_notes }}</p>
                            @endif
                        </div>
                    @else
                        {{-- Show the upload form if they can propose --}}
                        @if($mutation_proposal && $mutation_proposal->status === 'pending')
                            <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-4 rounded-lg text-sm mb-4">
                                <p class="font-bold">Proposal Mutasi Anda sedang Menunggu Verifikasi.</p>
                                <p class="text-xs mt-1">Diajukan pada: {{ $mutation_proposal->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        @else
                            <form action="{{ route('user.mutation.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Surat Izin Orang Tua <span class="text-red-500">*</span></label>
                                        <input type="file" name="parental_consent" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Surat Pengunduran Diri <span class="text-red-500">*</span></label>
                                        <input type="file" name="withdrawal_letter" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Surat Rekomendasi/Mutasi <span class="text-red-500">*</span></label>
                                        <input type="file" name="mutation_memo" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Pakta Integritas <span class="text-red-500">*</span></label>
                                        <input type="file" name="integrity_pact" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                                <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-gray-800 text-white text-sm font-semibold rounded-lg hover:bg-gray-900 transition shadow-sm">
                                    Submit Proposal Mutasi
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-auth-layout>
