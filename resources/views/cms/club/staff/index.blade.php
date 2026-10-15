@extends('cms.layouts.master')

@section('title', 'Manage Staff - ' . $club->name)

@section('content')

<div>
  <div class="section">
    <div class="sectionHead">
      <div>
        <h2>Manage Staff: {{ $club->name }}</h2>
      </div>
      <div class="actions" style="margin-top:-20px; justify-content:flex-end;">
        <a href="{{ route('club.index') }}" class="btn" style="background:#64748b; color:white;">
            Back to Clubs
        </a>
      </div>
    </div>

    @if (session('success'))
        <div style="color:green; margin-bottom:15px; margin-top:15px; background: #e6ffed; padding: 10px; border: 1px solid green; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div style="color:red; margin-bottom:15px; margin-top:15px; background: #ffe6e6; padding: 10px; border: 1px solid red; border-radius: 5px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('club.staff.store', $club->id) }}" method="POST">
        @csrf
        
        @php
            // Helper to get name for position
            $getName = function($pos) use ($staff) {
                return isset($staff[$pos]) && $staff[$pos]->count() > 0 ? $staff[$pos]->first()->name : '';
            };
            $idx = 0;
            
            $standardPositions = [
                'Struktur Wajib' => ['Direktur Utama', 'Administrator', 'Bendahara'],
                'Manajemen Organisasi' => [
                    'Manajemen Kerjasama, Pendidikan, Hukum, Riset dan Pengembangan',
                    'Manajemen Media Sosial dan Relasi Publik',
                    'Manajemen Pemasaran dan Branding',
                    'Manajemen Pemasalan, Pembinaan dan Event'
                ],
            ];

            $academyRoles = config('dropdown.club_academy_roles', [
                'Direktur Teknik',
                'Manajer',
                'Coach',
                'Fitness Coach',
                'Goalkeeper Coach',
                'Analis Performa'
            ]);

            $academyCategories = config('dropdown.club_academy_categories', [
                'Senior',
                'U-23',
                'U-22',
                'U-21',
                'U-20',
                'U-19',
                'U-18',
                'U-17',
                'U-16',
                'U-15',
                'U-14',
                'U-13',
                'U-12',
                'U-11',
                'U-10'
            ]);
            
            $generalPositions = config('dropdown.club_general_sports_positions', [
                'Agent (Player Agent)', 'Ahli Hukum (Olahraga)', 'Analis Performa', 'Appointed Physician', 
                'Asisten Pelatih Olahraga', 'B Sample Opening Witness', 'Chairman of Competition Management', 
                'Chaperone', 'Co-worker', 'Data Analyst', 'Direktur Teknis', 'Doping Control Official', 
                'Doping Official', 'Event Delegate', 'Event Director', 'Fasilitator Olahraga', 
                'Goalkeeper Coach', 'Head of Delegation', 'Independent Observer', 'Instruktur', 
                'Interpreter', 'Jurnalis Olahraga', 'Konsultan Industri Olahraga', 'Liaison Officer', 
                'Living Assistant', 'Manajer Stadion', 'Marshall', 'Media Officer', 'Media Publisher', 
                'Media Representative', 'Mekanik', 'Operator IT', 'Operator Pertandingan', 'Operator Skor', 
                'Pelatih Ekstrakurikuler', 'Pelatih Fisik', 'Pelatih Fisik Disabilitas', 
                'Pelatih Kelas Khusus Olahraga', 'Pelatih Kepala di Sekolah', 'Pelatih Klub Olahraga Sekolah', 
                'Pelatih Mental', 'Pelatih Olahraga', 'Pelatih Olahraga Akademi', 'Pelatih Olahraga Disabilitas', 
                'Pelatih Usia Dini', 'Penilai Parameter Tes Kondisi Fisik', 'Penyuluh', 'Petugas Keamanan', 
                'Photographer', 'Volunteer', 'Volunteer Administrasi', 'Volunteer Event', 'Volunteer Media', 
                'Volunteer Organisasi', 'Representative', 'Responsible Team Official', 'Sport Announcer', 
                'Statistician Olahraga', 'Team Guide', 'Trainer', 'Venue Director', 'Webmaster', 
                'Technical Delegates - Official', 'Technical Delegates - Match', 'Technical Director', 
                'Timekeeper', 'Venue Manager', 'Wheelchair Handball Classifier', 'Tenaga Keolahragaan'
            ]);

            $medicalPositions = config('dropdown.club_medical_sports_positions', [
                'Dokter Olahraga', 'Doping Control Officer', 'Fisiolog Olahraga', 'Fisioterapis', 
                'Medis Pertandingan', 'Medis Tim', 'Nutrisionis Olahraga', 'Perawat', 
                'Psikolog Olahraga', 'Sport Masseur', 'Tenaga Kesehatan', 'Tim Medis', 'Volunteer Medis'
            ]);
        @endphp

        <div class="form-wrapper" style="padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #fff;">
            
            {{-- Struktur Wajib & Manajemen Organisasi --}}
            @foreach($standardPositions as $group => $positions)
                <h3 style="margin-top: 20px; margin-bottom: 15px; padding-bottom: 5px; border-bottom: 2px solid #f1f5f9; color: #334155;">{{ $group }}</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                    @foreach($positions as $pos)
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600;">{{ $pos }}</label>
                            <input type="hidden" name="staff[{{ $idx }}][position]" value="{{ $pos }}">
                            <input type="text" name="staff[{{ $idx }}][name]" value="{{ old('staff.'.$idx.'.name', $getName($pos)) }}" placeholder="Name" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px;">
                        </div>
                        @php $idx++; @endphp
                    @endforeach
                </div>
            @endforeach

            <!-- Manajemen Tim dan Akademi (Dynamic Multiple with Role & Category) -->
            <h3 style="margin-top: 35px; margin-bottom: 10px; padding-bottom: 5px; border-bottom: 2px solid #f1f5f9; color: #334155;">Manajemen Tim dan Akademi</h3>
            <p style="font-size: 13px; color: #64748b; margin-top: -5px; margin-bottom: 15px;">Kelola staf pelatih, manajer, dan analis performa tim/akademi beserta kategorinya.</p>
            
            <div id="akademi-container" style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 15px;">
                @php
                    $academyStaff = $club->staff()->whereIn('position', $academyRoles)->get();
                @endphp
                @forelse($academyStaff as $aStaff)
                    <div class="akademi-row" style="display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <div class="form-group" style="flex: 2; min-width: 200px; margin: 0;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #334155;">Name</label>
                            <input type="text" name="staff[{{ $idx }}][name]" value="{{ $aStaff->name }}" placeholder="Nama Petugas" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; background: #fff;">
                        </div>
                        <div class="form-group" style="flex: 1.5; min-width: 170px; margin: 0;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #334155;">Role</label>
                            <select name="staff[{{ $idx }}][position]" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; background: #fff;">
                                @foreach($academyRoles as $role)
                                    <option value="{{ $role }}" {{ $aStaff->position == $role ? 'selected' : '' }}>{{ $role }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="flex: 1.5; min-width: 150px; margin: 0;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #334155;">Kategori</label>
                            <select name="staff[{{ $idx }}][category]" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; background: #fff;">
                                <option value="">Pilih Kategori</option>
                                @foreach($academyCategories as $cat)
                                    <option value="{{ $cat }}" {{ $aStaff->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" style="padding: 10px 15px; background: #ef4444; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;" onclick="this.closest('.akademi-row').remove()" title="Hapus Petugas">X</button>
                    </div>
                    @php $idx++; @endphp
                @empty
                    <div class="akademi-row" style="display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <div class="form-group" style="flex: 2; min-width: 200px; margin: 0;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #334155;">Name</label>
                            <input type="text" name="staff[{{ $idx }}][name]" value="" placeholder="Nama Petugas" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; background: #fff;">
                        </div>
                        <div class="form-group" style="flex: 1.5; min-width: 170px; margin: 0;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #334155;">Role</label>
                            <select name="staff[{{ $idx }}][position]" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; background: #fff;">
                                @foreach($academyRoles as $role)
                                    <option value="{{ $role }}">{{ $role }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="flex: 1.5; min-width: 150px; margin: 0;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #334155;">Kategori</label>
                            <select name="staff[{{ $idx }}][category]" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; background: #fff;">
                                <option value="">Pilih Kategori</option>
                                @foreach($academyCategories as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" style="padding: 10px 15px; background: #ef4444; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;" onclick="this.closest('.akademi-row').remove()" title="Hapus Petugas">X</button>
                    </div>
                    @php $idx++; @endphp
                @endforelse
            </div>
            <button type="button" class="btn primary" onclick="addAkademiPetugas()" style="background:#4f46e5; color:white; border:none; padding:8px 15px; border-radius:5px; cursor:pointer; font-weight: 600;">+ Tambah Petugas</button>

            <!-- Tenaga Keolahragaan: Umum (Dynamic Dropdown) -->
            <h3 style="margin-top: 35px; margin-bottom: 15px; padding-bottom: 5px; border-bottom: 2px solid #f1f5f9; color: #334155;">Tenaga Keolahragaan: Umum</h3>
            <div id="umum-container" style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 15px;">
                @php
                    // Get all staff whose position is in the general sports list
                    $umumStaff = $club->staff()->whereIn('position', $generalPositions)->get();
                @endphp
                @foreach($umumStaff as $uStaff)
                    <div class="umum-row" style="display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <div class="form-group" style="flex: 2; min-width: 200px; margin:0;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Name</label>
                            <input type="text" name="staff[{{ $idx }}][name]" value="{{ $uStaff->name }}" placeholder="Name" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; background: #fff;">
                        </div>
                        <div class="form-group" style="flex: 2; min-width: 200px; margin:0;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Position</label>
                            <select name="staff[{{ $idx }}][position]" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; background: #fff;">
                                @foreach($generalPositions as $gPos)
                                    <option value="{{ $gPos }}" {{ $uStaff->position == $gPos ? 'selected' : '' }}>{{ $gPos }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" style="padding: 10px 15px; background: #ef4444; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;" onclick="this.closest('.umum-row').remove()" title="Hapus">X</button>
                    </div>
                    @php $idx++; @endphp
                @endforeach
            </div>
            <button type="button" class="btn primary" onclick="addUmum()" style="background:#3b82f6; color:white; border:none; padding:8px 15px; border-radius:5px; cursor:pointer;">+ Tambah Tenaga Umum</button>

            <!-- Tenaga Keolahragaan: Kesehatan (Dynamic Dropdown) -->
            <h3 style="margin-top: 40px; margin-bottom: 15px; padding-bottom: 5px; border-bottom: 2px solid #f1f5f9; color: #334155;">Tenaga Keolahragaan: Kesehatan</h3>
            <div id="kesehatan-container" style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 15px;">
                @php
                    // Get all staff whose position is in the medical list
                    $kesehatanStaff = $club->staff()->whereIn('position', $medicalPositions)->get();
                @endphp
                @foreach($kesehatanStaff as $kStaff)
                    <div class="kesehatan-row" style="display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <div class="form-group" style="flex: 2; min-width: 200px; margin:0;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Name</label>
                            <input type="text" name="staff[{{ $idx }}][name]" value="{{ $kStaff->name }}" placeholder="Name" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; background: #fff;">
                        </div>
                        <div class="form-group" style="flex: 2; min-width: 200px; margin:0;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Position</label>
                            <select name="staff[{{ $idx }}][position]" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; background: #fff;">
                                @foreach($medicalPositions as $mPos)
                                    <option value="{{ $mPos }}" {{ $kStaff->position == $mPos ? 'selected' : '' }}>{{ $mPos }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" style="padding: 10px 15px; background: #ef4444; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;" onclick="this.closest('.kesehatan-row').remove()" title="Hapus">X</button>
                    </div>
                    @php $idx++; @endphp
                @endforeach
            </div>
            <button type="button" class="btn primary" onclick="addKesehatan()" style="background:#10b981; color:white; border:none; padding:8px 15px; border-radius:5px; cursor:pointer;">+ Tambah Tenaga Kesehatan</button>

            <div style="margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                <button type="submit" class="btn primary" style="width: 100%; font-size: 16px; padding: 12px; cursor: pointer;">Save All Staff</button>
            </div>
        </div>
    </form>
  </div>
</div>

<script>
    let globalIdx = {{ $idx + 100 }}; // Offset to avoid overlapping indexes

    function addAkademiPetugas() {
        const container = document.getElementById('akademi-container');
        const row = document.createElement('div');
        row.className = 'akademi-row';
        row.style.display = 'flex';
        row.style.flexWrap = 'wrap';
        row.style.gap = '15px';
        row.style.alignItems = 'flex-end';
        row.style.background = '#f8fafc';
        row.style.padding = '15px';
        row.style.borderRadius = '8px';
        row.style.border = '1px solid #e2e8f0';

        let roleOptions = '';
        const roles = {!! json_encode($academyRoles) !!};
        roles.forEach(r => {
            roleOptions += `<option value="${r}">${r}</option>`;
        });

        let catOptions = '<option value="">Pilih Kategori</option>';
        const categories = {!! json_encode($academyCategories) !!};
        categories.forEach(c => {
            catOptions += `<option value="${c}">${c}</option>`;
        });

        row.innerHTML = `
            <div class="form-group" style="flex: 2; min-width: 200px; margin: 0;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #334155;">Name</label>
                <input type="text" name="staff[${globalIdx}][name]" value="" placeholder="Nama Petugas" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; background: #fff;">
            </div>
            <div class="form-group" style="flex: 1.5; min-width: 170px; margin: 0;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #334155;">Role</label>
                <select name="staff[${globalIdx}][position]" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; background: #fff;">
                    ${roleOptions}
                </select>
            </div>
            <div class="form-group" style="flex: 1.5; min-width: 150px; margin: 0;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 13px; color: #334155;">Kategori</label>
                <select name="staff[${globalIdx}][category]" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; background: #fff;">
                    ${catOptions}
                </select>
            </div>
            <button type="button" style="padding: 10px 15px; background: #ef4444; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;" onclick="this.closest('.akademi-row').remove()" title="Hapus Petugas">X</button>
        `;
        container.appendChild(row);
        globalIdx++;
    }

    function addUmum() {
        const container = document.getElementById('umum-container');
        const row = document.createElement('div');
        row.className = 'umum-row';
        row.style.display = 'flex';
        row.style.flexWrap = 'wrap';
        row.style.gap = '15px';
        row.style.alignItems = 'flex-end';
        row.style.background = '#f8fafc';
        row.style.padding = '15px';
        row.style.borderRadius = '8px';
        row.style.border = '1px solid #e2e8f0';
        
        let options = '';
        const genPos = {!! json_encode($generalPositions) !!};
        genPos.forEach(p => {
            options += `<option value="${p}">${p}</option>`;
        });

        row.innerHTML = `
            <div class="form-group" style="flex: 2; min-width: 200px; margin:0;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Name</label>
                <input type="text" name="staff[${globalIdx}][name]" value="" placeholder="Name" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; background: #fff;">
            </div>
            <div class="form-group" style="flex: 2; min-width: 200px; margin:0;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Position</label>
                <select name="staff[${globalIdx}][position]" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; background: #fff;">
                    ${options}
                </select>
            </div>
            <button type="button" style="padding: 10px 15px; background: #ef4444; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;" onclick="this.closest('.umum-row').remove()" title="Hapus">X</button>
        `;
        container.appendChild(row);
        globalIdx++;
    }

    function addKesehatan() {
        const container = document.getElementById('kesehatan-container');
        const row = document.createElement('div');
        row.className = 'kesehatan-row';
        row.style.display = 'flex';
        row.style.flexWrap = 'wrap';
        row.style.gap = '15px';
        row.style.alignItems = 'flex-end';
        row.style.background = '#f8fafc';
        row.style.padding = '15px';
        row.style.borderRadius = '8px';
        row.style.border = '1px solid #e2e8f0';
        
        let options = '';
        const medPos = {!! json_encode($medicalPositions) !!};
        medPos.forEach(p => {
            options += `<option value="${p}">${p}</option>`;
        });

        row.innerHTML = `
            <div class="form-group" style="flex: 2; min-width: 200px; margin:0;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Name</label>
                <input type="text" name="staff[${globalIdx}][name]" value="" placeholder="Name" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; background: #fff;">
            </div>
            <div class="form-group" style="flex: 2; min-width: 200px; margin:0;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Position</label>
                <select name="staff[${globalIdx}][position]" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; background: #fff;">
                    ${options}
                </select>
            </div>
            <button type="button" style="padding: 10px 15px; background: #ef4444; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;" onclick="this.closest('.kesehatan-row').remove()" title="Hapus">X</button>
        `;
        container.appendChild(row);
        globalIdx++;
    }
</script>

@endsection
