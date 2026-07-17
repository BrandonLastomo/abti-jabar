<x-profile-layout title="Pengajuan Mutasi / Transfer">
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
</x-profile-layout>
