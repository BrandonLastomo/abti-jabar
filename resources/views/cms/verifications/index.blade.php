@extends('cms.layouts.master')

@section('title', 'Admin - Document Verifications')

@section('full_content')
<div class="p-6 lg:p-10 min-h-screen bg-gray-50/50">
    
    <!-- Header -->
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h1 class="font-heading font-extrabold text-4xl text-gray-900 tracking-tight mb-2">Document Verifications</h1>
            <p class="text-gray-500 font-medium">Verify documents uploaded by users and clubs.</p>
        </div>
        <a href="{{ route('superadmin.dashboard') }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-gray-900 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Dashboard
        </a>
    </div>

    {{-- Success Messages --}}
    @if(session('success'))
    <div class="mb-6 bg-green-50/80 backdrop-blur-sm border border-green-200 text-green-700 px-5 py-4 rounded-2xl shadow-sm text-sm font-bold flex items-center gap-3 animate-[fade-in_0.3s_ease-out]">
        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ session('success') }}
    </div>
    @endif
    <!-- Status Filters -->
    @php
        $filters = [
            'pending' => ['label' => 'Needs Review', 'color' => 'amber'],
            'verified' => ['label' => 'Verified', 'color' => 'green'],
            'rejected' => ['label' => 'Rejected', 'color' => 'red'],
            'all' => ['label' => 'All Statuses', 'color' => 'gray'],
        ];
    @endphp
    <div class="flex flex-wrap items-center gap-3 mb-6">
        @foreach($filters as $key => $filterData)
            @php
                $isActive = $filter === $key;
                $color = $filterData['color'];
                $activeClass = "bg-{$color}-100 text-{$color}-700 ring-1 ring-{$color}-400/50 shadow-sm font-bold scale-105";
                $inactiveClass = "bg-white text-gray-500 ring-1 ring-gray-200 hover:bg-gray-50 hover:text-gray-700 font-medium";
            @endphp
            <a href="{{ route('superadmin.verifications.index', ['filter' => $key]) }}"
               class="px-4 py-2 rounded-xl text-sm transition-all duration-300 flex items-center gap-2 {{ $isActive ? $activeClass : $inactiveClass }}">
                @if($key === 'pending')
                    <span class="w-2 h-2 rounded-full bg-amber-400 {{ $isActive ? 'animate-pulse' : '' }}"></span>
                @elseif($key === 'verified')
                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                @elseif($key === 'rejected')
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                @endif
                {{ $filterData['label'] }}
            </a>
        @endforeach
    </div>

    <!-- Data Card -->
    <div class="bg-white/90 backdrop-blur-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl overflow-hidden">
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50/50 text-gray-500 uppercase text-xs font-extrabold tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">User / Entitas</th>
                        <th class="px-6 py-4">Dokumen</th>
                        <th class="px-6 py-4">Waktu Upload</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/50">
                    @forelse($verifications as $v)
                    <tr class="hover:bg-gray-50/80 transition-colors duration-200 group">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-bold text-gray-900 group-hover:text-primary transition-colors">{{ $v->user->name ?? 'N/A' }}</p>
                                <p class="text-xs font-medium text-gray-400">{{ $v->user->email ?? 'N/A' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1.5">
                                <span class="text-xs font-bold text-gray-900">{{ class_basename($v->documentable_type) }} &mdash; <span class="text-gray-500 font-medium">{{ $v->field_name }}</span></span>
                                <a href="{{ Storage::url($v->documentable->{$v->field_name} ?? '') }}" target="_blank" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors mt-1">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    Lihat File Dokumen
                                </a>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs font-medium text-gray-500">{{ $v->created_at->diffForHumans() }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $v->created_at->format('d M Y, H:i') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($v->status === 'pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 ring-1 ring-amber-400/30">Needs Review</span>
                            @elseif($v->status === 'verified')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 ring-1 ring-green-400/30">Verified</span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 ring-1 ring-red-400/30">Rejected</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if($v->status === 'pending')
                                    <form action="{{ route('superadmin.verifications.process', $v->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="verified">
                                        <button type="submit" class="inline-flex items-center px-3 py-2 text-xs font-bold rounded-xl bg-green-50 text-green-700 hover:bg-green-500 hover:text-white transition-all shadow-sm">
                                            Verify
                                        </button>
                                    </form>
                                    <button type="button" onclick="openRejectModal({{ $v->id }})"
                                            class="inline-flex items-center px-3 py-2 text-xs font-bold rounded-xl bg-red-50 text-red-700 hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                        Reject
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                            </div>
                            <p class="text-gray-500 font-medium">Tidak ada dokumen yang menunggu verifikasi.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($verifications->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
            {{ $verifications->appends(['filter' => $filter])->links() }}
        </div>
        @endif

    </div>

</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" onclick="closeRejectModal()"></div>

    <div class="relative bg-white rounded-3xl overflow-hidden shadow-2xl transform transition-all sm:max-w-lg w-full p-8 m-4">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h3 class="text-xl font-heading font-extrabold text-gray-900" id="modal-title">Tolak Dokumen</h3>
                <p class="text-sm text-gray-500 font-medium">Provide a reason for rejection.</p>
            </div>
        </div>
        
        <form id="rejectForm" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="rejected">
            
            <div class="mb-6">
                <label for="notes" class="block text-sm font-bold text-gray-700 mb-2">Alasan Penolakan / Catatan <span class="text-red-500">*</span></label>
                <textarea name="notes" id="notes" rows="4" required
                          class="w-full border-gray-200 rounded-xl shadow-sm focus:border-red-500 focus:ring-red-500 text-sm font-medium transition-colors"
                          placeholder="Mohon perbaiki dokumen, resolusi blur..."></textarea>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button type="button" onclick="closeRejectModal()"
                        class="px-5 py-2.5 rounded-xl text-gray-600 font-bold hover:bg-gray-100 transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl shadow-[0_4px_14px_0_rgba(220,38,38,0.39)] hover:bg-red-700 hover:-translate-y-0.5 transition-all">
                    Tolak Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRejectModal(id) {
        const modal = document.getElementById('rejectModal');
        const form = document.getElementById('rejectForm');
        // Set form action based on ID
        form.action = `{{ url('superadmin/verifications') }}/${id}`;
        modal.classList.remove('hidden');
    }

    function closeRejectModal() {
        const modal = document.getElementById('rejectModal');
        modal.classList.add('hidden');
    }
</script>
@endsection
