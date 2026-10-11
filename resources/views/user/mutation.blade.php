<x-profile-layout title="Pengajuan Mutasi / Transfer">
    <div class="bg-white/90 backdrop-blur-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl transition-all">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Transfer/Mutation Proposal</h3>
            <p class="text-sm text-gray-500 mb-4">Pengajuan mutasi atau transfer atlet yang hanya dapat dilakukan 4 tahun sekali.</p>

            @if(!($isAthlete ?? true))
                <div class="bg-amber-50/80 backdrop-blur-sm border border-amber-200 text-amber-900 p-6 rounded-2xl mb-4">
                    <div class="flex items-start gap-4">
                        <div class="p-2.5 rounded-xl bg-amber-100 text-amber-700 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-base text-gray-900">Pengajuan Mutasi Khusus Atlet</h4>
                            <p class="text-sm text-gray-600 mt-1 leading-relaxed">
                                Pengajuan transfer dan mutasi antar-klub/kabupaten diperuntukkan khusus bagi anggota dengan peran <strong>Atlet</strong>.
                            </p>
                            <p class="text-xs text-gray-500 mt-3">
                                Klasifikasi akun Anda saat ini terdaftar sebagai <strong>{{ ucfirst($memberType ?? 'Non-Atlet') }}</strong>. Jika Anda adalah atlet aktif yang ingin mengajukan mutasi, silakan ubah klasifikasi peran Anda di halaman <a href="{{ route('user.profile.general') }}" class="text-red-600 underline font-semibold hover:text-red-700">Profil Umum</a>.
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($mutation_open !== '1')
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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Surat Izin Orang Tua <span class="text-red-500">*</span></label>
                                <input type="file" name="parental_consent" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 transition-colors" accept=".pdf,.jpg,.jpeg,.png">
                                @error('parental_consent')
                                    <p class="mt-2 text-xs font-bold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Surat Pengunduran Diri <span class="text-red-500">*</span></label>
                                <input type="file" name="withdrawal_letter" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 transition-colors" accept=".pdf,.jpg,.jpeg,.png">
                                @error('withdrawal_letter')
                                    <p class="mt-2 text-xs font-bold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Surat Rekomendasi/Mutasi <span class="text-red-500">*</span></label>
                                <input type="file" name="mutation_memo" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 transition-colors" accept=".pdf,.jpg,.jpeg,.png">
                                @error('mutation_memo')
                                    <p class="mt-2 text-xs font-bold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Pakta Integritas <span class="text-red-500">*</span></label>
                                <input type="file" name="integrity_pact" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 transition-colors" accept=".pdf,.jpg,.jpeg,.png">
                                @error('integrity_pact')
                                    <p class="mt-2 text-xs font-bold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-primary text-white text-sm font-bold rounded-xl shadow-[0_4px_14px_0_rgba(220,38,38,0.39)] hover:shadow-[0_6px_20px_rgba(220,38,38,0.23)] hover:bg-red-700 hover:-translate-y-0.5 transition-all">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Submit Proposal Mutasi
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </div>
</x-profile-layout>
