@extends('cms.layouts.master')

@section('title', 'Manajemen User')

@section('content')
<div class="section">
    <div class="sectionHead">
        <div>
            <h2>Manajemen User</h2>
            <p>Kelola data pengguna, admin, dan superadmin.</p>
        </div>
        <div class="actions" style="margin-top:-20px; justify-content:flex-end;">
            <a href="{{ route('users.create') }}" class="btn primary">Tambah User</a>
        </div>
    </div>

    <div class="bignews-wrapper" style="padding: 20px; background: var(--surface); border-radius: var(--radius); width: 100%;">
        {{-- Filter & Search --}}
        <form action="{{ route('users.index') }}" method="GET" style="display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap;">
            <div style="flex:1; min-width:200px;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." style="width:100%; padding:10px; border:1px solid #ddd; border-radius:5px;">
            </div>
            <div>
                <select name="role" style="padding:10px; border:1px solid #ddd; border-radius:5px;" onchange="this.form.submit()">
                    <option value="all" {{ $roleFilter === 'all' ? 'selected' : '' }}>Semua Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ $roleFilter === $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn primary" style="padding:10px 15px;">Cari</button>
        </form>

        {{-- Table --}}
        <div class="table-wrapper">
            <table class="custom-table" style="width: 100%; text-align: left; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #eee;">
                        <th style="padding: 10px;">Nama</th>
                        <th style="padding: 10px;">Email</th>
                        <th style="padding: 10px;">Role</th>
                        <th style="padding: 10px;">Tanggal Daftar</th>
                        <th style="padding: 10px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 10px; font-weight: 600;">{{ $u->name }}</td>
                            <td style="padding: 10px; color: var(--muted);">{{ $u->email }}</td>
                            <td style="padding: 10px;">
                                @php $userRole = $u->getRoleNames()->first() ?? '-'; @endphp
                                <span style="display: inline-block; padding: 3px 8px; border-radius: 12px; font-size: 12px; font-weight: bold;
                                    background: {{ $userRole === 'superadmin' ? '#fee2e2' : ($userRole === 'admin' ? '#e0e7ff' : '#dcfce3') }};
                                    color: {{ $userRole === 'superadmin' ? '#991b1b' : ($userRole === 'admin' ? '#3730a3' : '#166534') }};">
                                    {{ ucfirst($userRole) }}
                                </span>
                            </td>
                            <td style="padding: 10px; color: var(--muted);">{{ $u->created_at->format('d/m/Y') }}</td>
                            <td style="padding: 10px; text-align: right;">
                                <div style="display: flex; gap: 5px; justify-content: flex-end;">
                                    <a href="{{ route('users.show', $u->id) }}" class="btn" style="padding: 5px 10px; font-size: 12px; background: #f3f4f6; color: #374151; border: 1px solid #d1d5db;">View</a>
                                    <a href="{{ route('users.edit', $u->id) }}" class="btn" style="padding: 5px 10px; font-size: 12px; background: #e0e7ff; color: #4f46e5; border: 1px solid #c7d2fe;">Edit</a>
                                    @if($u->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')" style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn" style="padding: 5px 10px; font-size: 12px; background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; cursor: pointer;">Hapus</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 20px; text-align: center; color: var(--muted);">Tidak ada user ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $users->appends(['role' => $roleFilter, 'search' => $search])->links() }}
        </div>
    </div>
</div>
@endsection
