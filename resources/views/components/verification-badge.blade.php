@props(['model', 'field'])

@php
    $vStatus = $model ? $model->getDocumentVerification($field) : null;
@endphp

@if($vStatus)
    <div class="mt-2">
        @if($vStatus->status === 'verified')
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Verified
            </span>
        @elseif($vStatus->status === 'rejected')
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                Rejected
            </span>
            @if($vStatus->notes)
                <div class="mt-1 text-xs text-red-600 bg-red-50 p-2 rounded border border-red-100">
                    <strong>Alasan penolakan:</strong> {{ $vStatus->notes }}
                </div>
            @endif
        @else
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                <svg class="w-3 h-3 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Pending Verification
            </span>
        @endif
    </div>
@endif
