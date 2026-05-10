@extends('cms.layouts.master')

@section('title', 'Detail User')

@section('content')
<style>
    .bignews-wrapper { padding: 20px; background: var(--surface); border-radius: var(--radius); width: 100%; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 5px; }
    .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background: #f9f9f9; }
</style>

<div class="section">
    <div class="sectionHead">
        <div>
            <h2>Detail User</h2>
        </div>
    </div>

    <div class="bignews-wrapper">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group" style="grid-column: span 2;">
                <label>Nama</label>
                <input type="text" value="{{ $user->name }}" readonly>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" value="{{ $user->email }}" readonly>
            </div>
            <div class="form-group">
                <label>Role</label>
                <input type="text" value="{{ ucfirst($user->getRoleNames()->first() ?? '-') }}" readonly>
            </div>
            <div class="form-group">
                <label>Tanggal Bergabung</label>
                <input type="text" value="{{ $user->created_at->format('d M Y, H:i') }}" readonly>
            </div>
        </div>
        
        <h3 style="margin-top: 30px; margin-bottom: 10px; font-size: 18px;">Dokumen Uploaded</h3>
        <div class="table-wrapper">
            <table class="custom-table" style="width: 100%; text-align: left; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #eee;">
                        <th style="padding: 10px;">Nama File</th>
                        <th style="padding: 10px;">Status</th>
                        <th style="padding: 10px;">Tgl Upload</th>
                        <th style="padding: 10px;">Diverifikasi Oleh</th>
                        <th style="padding: 10px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($user->documents as $doc)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">{{ $doc->file_name }}</td>
                        <td style="padding: 10px;">
                            @if($doc->status === 'pending')
                                <span style="color: #b45309;">Pending</span>
                            @elseif($doc->status === 'verified')
                                <span style="color: #15803d;">Verified</span>
                            @else
                                <span style="color: #b91c1c;">Rejected</span>
                            @endif
                        </td>
                        <td style="padding: 10px;">{{ $doc->created_at->format('d/m/Y') }}</td>
                        <td style="padding: 10px;">{{ $doc->verifier ? $doc->verifier->name : '-' }}</td>
                        <td style="padding: 10px;">
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" style="color: #2563eb; font-size: 14px;">Lihat File</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 10px; text-align: center; color: #6b7280;">Tidak ada dokumen.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <a href="{{ route('users.index') }}" class="btn" style="padding: 10px 15px; background: #e5e7eb; color: #374151; border-radius: 5px; text-decoration: none;">Kembali</a>
            <a href="{{ route('users.edit', $user->id) }}" class="btn primary" style="padding: 10px 15px;">Edit User</a>
        </div>
    </div>
</div>
@endsection
