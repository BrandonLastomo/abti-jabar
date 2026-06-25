@extends('cms.layouts.master')

@section('title', 'General Settings')

@section('content')
<form action="{{ route('settings.update') }}" method="POST">
    @csrf
    <div class="section">
        <div class="sectionHead" style="margin-left: -20px;margin-bottom: 20px;">
            <div>
                <h2>General Settings</h2>
                <p>Konfigurasi pengaturan umum website.</p>
            </div>
            <div class="pill">Settings</div>
        </div>

        @if(session('success'))
            <div class="note" style="background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.3); color: #065f46; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="sectionBody">
            <div class="field" style="margin-bottom: 20px;">
                <div class="labelRow">
                    <label>Transfer/Mutation Proposal Status</label>
                </div>
                <div style="margin-top: 10px;">
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="checkbox" name="mutation_open" value="1" {{ $mutation_open == '1' ? 'checked' : '' }} style="width: auto; height: 18px; width: 18px;">
                        <span style="font-size: 14px; font-weight: normal;">Buka Pendaftaran Transfer/Mutasi Atlet</span>
                    </label>
                    <p class="hint" style="margin-top: 8px;">Centang untuk membuka form mutasi bagi atlet di halaman profil mereka. Hapus centang untuk menutup.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-footer" style="margin-top: 30px; display: flex; justify-content: flex-end;">
        <button type="submit" class="btn-save" style="padding: 12px 40px; border-radius: 8px; font-weight: 600; background-color: #d92128; color: white; border: none; cursor: pointer;">Save Settings</button>
    </div>
</form>
@endsection
