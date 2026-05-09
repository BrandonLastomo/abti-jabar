@extends('cms.layouts.master')
@section('content')

<div class="cms-page">
    <div class="cms-page__header">
        <h1 class="cms-page__title">Manajemen Livestream</h1>
        <a href="{{ route('live.create') }}" class="btn btn-primary">
            + Tambah Livestream
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-wrapper">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Tanggal & Waktu</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($live as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->title }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}
                            pukul {{ $item->time }}
                        </td>
                        <td>
                            @if($item->is_live)
                                <span class="badge badge-live">🔴 LIVE</span>
                            @else
                                <span class="badge badge-off">Tidak Live</span>
                            @endif
                        </td>
                        <td class="cms-table__actions">
                            {{-- Toggle Live --}}
                            <form action="{{ route('cms.live.toggle', $item) }}" method="POST" style="display:inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn {{ $item->is_live ? 'btn-warning' : 'btn-success' }} btn-sm">
                                    {{ $item->is_live ? 'Matikan' : 'Aktifkan' }}
                                </button>
                            </form>

                            {{-- Edit --}}
                            <a href="{{ route('cms.live.edit', $item) }}" class="btn btn-secondary btn-sm">
                                Edit
                            </a>

                            {{-- Hapus --}}
                            <form action="{{ route('cms.live.destroy', $item) }}" method="POST"
                                  style="display:inline"
                                  onsubmit="return confirm('Hapus livestream ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;">Belum ada data livestream.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="cms-pagination">
        {{ $live->links() }}
    </div>
</div>

@endsection