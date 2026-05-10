<x-auth-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin — Verifikasi Dokumen
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

            {{-- ====== FILTER TABS ====== --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 flex flex-wrap gap-2">
                    @php
                        $tabs = [
                            'pending' => ['label' => 'Menunggu Verifikasi', 'color' => 'yellow'],
                            'verified' => ['label' => 'Terverifikasi', 'color' => 'green'],
                            'rejected' => ['label' => 'Ditolak', 'color' => 'red'],
                            'all' => ['label' => 'Semua', 'color' => 'gray'],
                        ];
                    @endphp
                    @foreach($tabs as $key => $tab)
                        <a href="{{ route('admin.dashboard', ['filter' => $key]) }}"
                           class="px-4 py-2 rounded-lg text-sm font-medium transition
                                  {{ $filter === $key
                                      ? 'bg-' . $tab['color'] . '-100 text-' . $tab['color'] . '-800 ring-1 ring-' . $tab['color'] . '-300'
                                      : 'bg-gray-50 text-gray-600 hover:bg-gray-100' }}">
                            {{ $tab['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- ====== DOCUMENTS TABLE ====== --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($documents->count() === 0)
                        <div class="text-center py-10">
                            <svg class="mx-auto w-14 h-14 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-gray-500 text-sm">Tidak ada dokumen dengan status ini.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                                    <tr>
                                        <th class="px-4 py-3">User</th>
                                        <th class="px-4 py-3">Nama Dokumen</th>
                                        <th class="px-4 py-3">Tipe</th>
                                        <th class="px-4 py-3">Ukuran</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">Tanggal Upload</th>
                                        <th class="px-4 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($documents as $doc)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $doc->user->name }}</p>
                                                <p class="text-xs text-gray-400">{{ $doc->user->email }}</p>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $doc->file_name }}</td>
                                        <td class="px-4 py-3 uppercase text-gray-500">{{ $doc->file_type }}</td>
                                        <td class="px-4 py-3 text-gray-500">{{ number_format($doc->file_size / 1024, 1) }} KB</td>
                                        <td class="px-4 py-3">
                                            @if($doc->status === 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($doc->status === 'verified')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Verified</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">Rejected</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-gray-500">{{ $doc->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-2">
                                                {{-- View file --}}
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                                   class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded-md bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                                                    Lihat File
                                                </a>

                                                @if($doc->status === 'pending')
                                                    {{-- Verify --}}
                                                    <form action="{{ route('admin.documents.verify', $doc) }}" method="POST" class="inline">
                                                        @csrf @method('PATCH')
                                                        <button type="submit"
                                                                class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded-md bg-green-50 text-green-700 hover:bg-green-100 transition"
                                                                title="Verifikasi">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                            Verifikasi
                                                        </button>
                                                    </form>

                                                    {{-- Reject (with modal) --}}
                                                    <button type="button"
                                                            onclick="openRejectModal({{ $doc->id }})"
                                                            class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded-md bg-red-50 text-red-700 hover:bg-red-100 transition">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                        Tolak
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $documents->appends(['filter' => $filter])->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- ====== REJECT MODAL ====== --}}
    <div id="rejectModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-2">Tolak Dokumen</h3>
            <p class="text-sm text-gray-500 mb-4">Berikan alasan penolakan agar user dapat memahami.</p>
            <form id="rejectForm" method="POST">
                @csrf @method('PATCH')
                <textarea name="notes" rows="3" required
                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm mb-4"
                          placeholder="Alasan penolakan..."></textarea>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeRejectModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                        Tolak Dokumen
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal(docId) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = `/admin/documents/${docId}/reject`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-auth-layout>
