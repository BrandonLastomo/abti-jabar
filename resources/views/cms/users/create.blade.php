@extends('cms.layouts.master')

@section('title', 'Tambah User')

@section('content')
<style>
    .bignews-wrapper { padding: 20px; background: var(--surface); border-radius: var(--radius); width: 100%; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 5px; }
    .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
    .error-text { color: red; font-size: 12px; margin-top: 5px; }
</style>

<div class="section">
    <div class="sectionHead">
        <div>
            <h2>Tambah User Baru</h2>
        </div>
    </div>

    <div class="bignews-wrapper">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group" style="grid-column: span 2;">
                    <label>Nama Lengkap <span style="color:red">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                    @error('name') <div class="error-text">{{ $message }}</div> @enderror
                </div>
                
                <div class="form-group">
                    <label>Email <span style="color:red">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                    @error('email') <div class="error-text">{{ $message }}</div> @enderror
                </div>
                
                <div class="form-group">
                    <label>Role <span style="color:red">*</span></label>
                    <select name="role" required>
                        <option value="">-- Pilih Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                    @error('role') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label>Password <span style="color:red">*</span></label>
                    <input type="password" name="password" required minlength="8">
                    <small style="color:#6b7280;">Minimal 8 karakter.</small>
                    @error('password') <div class="error-text">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <a href="{{ route('users.index') }}" class="btn" style="padding: 10px 15px; background: #e5e7eb; color: #374151; border-radius: 5px; text-decoration: none;">Batal</a>
                <button type="submit" class="btn primary" style="padding: 10px 15px; border: none; cursor: pointer;">Simpan User</button>
            </div>
        </form>
    </div>
</div>
@endsection
