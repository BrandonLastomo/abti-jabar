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
                'Manajemen Tim dan Akademi' => [
                    'Direktur Teknik', 'Manajer', 'Coach', 'Fitness Coach', 'Goalkeeper Coach'
                ]
            ];
            
            $medicalPositions = [
                'Dokter Olahraga', 'Doping Control Officer', 'Fisiolog Olahraga', 'Fisioterapis', 
                'Medis Pertandingan', 'Medis Tim', 'Nutrisionis Olahraga', 'Perawat', 
                'Psikolog Olahraga', 'Sport Masseur', 'Tenaga Kesehatan', 'Tim Medis', 'Volunteer Medis'
            ];
        @endphp

        <div class="form-wrapper" style="padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #fff;">
            
            @foreach($standardPositions as $group => $positions)
                <h3 style="margin-top: 20px; margin-bottom: 15px; padding-bottom: 5px; border-bottom: 2px solid #f1f5f9; color: #334155;">{{ $group }}</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    @foreach($positions as $pos)
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600;">{{ $pos }}</label>
                            <input type="hidden" name="staff[{{ $idx }}][position]" value="{{ $pos }}">
                            <input type="text" name="staff[{{ $idx }}][name]" value="{{ old('staff.'.$idx.'.name', $getName($pos)) }}" placeholder="Name" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                        @php $idx++; @endphp
                    @endforeach
                </div>
            @endforeach

            <!-- Pelatih Mental (Dynamic Multiple) -->
            <h3 style="margin-top: 30px; margin-bottom: 15px; padding-bottom: 5px; border-bottom: 2px solid #f1f5f9; color: #334155;">Pelatih Mental</h3>
            <div id="pelatih-mental-container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                @php
                    $mentalStaff = isset($staff['Pelatih Mental']) ? $staff['Pelatih Mental'] : collect([]);
                @endphp
                @foreach($mentalStaff as $mStaff)
                    <div class="form-group mental-row">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Pelatih Mental <span style="color:red; cursor:pointer;" onclick="this.closest('.mental-row').remove()">[Remove]</span></label>
                        <input type="hidden" name="staff[{{ $idx }}][position]" value="Pelatih Mental">
                        <input type="text" name="staff[{{ $idx }}][name]" value="{{ $mStaff->name }}" placeholder="Name" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>
                    @php $idx++; @endphp
                @endforeach
            </div>
            <button type="button" class="btn primary" onclick="addPelatihMental()" style="background:#3b82f6; color:white; border:none; padding:8px 15px; border-radius:5px; cursor:pointer;">+ Tambah Pelatih Mental</button>

            <!-- Tenaga Keolahragaan: Kesehatan (Dynamic Dropdown) -->
            <h3 style="margin-top: 40px; margin-bottom: 15px; padding-bottom: 5px; border-bottom: 2px solid #f1f5f9; color: #334155;">Tenaga Keolahragaan: Kesehatan</h3>
            <div id="kesehatan-container" style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 15px;">
                @php
                    // Get all staff whose position is in the medical list
                    $kesehatanStaff = $club->staff()->whereIn('position', $medicalPositions)->get();
                @endphp
                @foreach($kesehatanStaff as $kStaff)
                    <div class="kesehatan-row" style="display: flex; gap: 15px; align-items: flex-end;">
                        <div class="form-group" style="flex: 1; margin:0;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Name</label>
                            <input type="text" name="staff[{{ $idx }}][name]" value="{{ $kStaff->name }}" placeholder="Name" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                        <div class="form-group" style="flex: 1; margin:0;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Position</label>
                            <select name="staff[{{ $idx }}][position]" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                                @foreach($medicalPositions as $mPos)
                                    <option value="{{ $mPos }}" {{ $kStaff->position == $mPos ? 'selected' : '' }}>{{ $mPos }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" style="padding: 10px 15px; background: #ef4444; color: white; border: none; border-radius: 5px; cursor: pointer;" onclick="this.closest('.kesehatan-row').remove()">X</button>
                    </div>
                    @php $idx++; @endphp
                @endforeach
            </div>
            <button type="button" class="btn primary" onclick="addKesehatan()" style="background:#10b981; color:white; border:none; padding:8px 15px; border-radius:5px; cursor:pointer;">+ Tambah Tenaga Kesehatan</button>

            <div style="margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                <button type="submit" class="btn primary" style="width: 100%; font-size: 16px; padding: 12px;">Save All Staff</button>
            </div>
        </div>
    </form>
  </div>
</div>

<script>
    let globalIdx = {{ $idx + 100 }}; // Offset to avoid overlapping indexes

    function addPelatihMental() {
        const container = document.getElementById('pelatih-mental-container');
        const row = document.createElement('div');
        row.className = 'form-group mental-row';
        row.innerHTML = `
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Pelatih Mental <span style="color:red; cursor:pointer;" onclick="this.closest('.mental-row').remove()">[Remove]</span></label>
            <input type="hidden" name="staff[${globalIdx}][position]" value="Pelatih Mental">
            <input type="text" name="staff[${globalIdx}][name]" value="" placeholder="Name" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        `;
        container.appendChild(row);
        globalIdx++;
    }

    function addKesehatan() {
        const container = document.getElementById('kesehatan-container');
        const row = document.createElement('div');
        row.className = 'kesehatan-row';
        row.style.display = 'flex';
        row.style.gap = '15px';
        row.style.alignItems = 'flex-end';
        
        let options = '';
        const medPos = {!! json_encode($medicalPositions) !!};
        medPos.forEach(p => {
            options += `<option value="${p}">${p}</option>`;
        });

        row.innerHTML = `
            <div class="form-group" style="flex: 1; margin:0;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Name</label>
                <input type="text" name="staff[${globalIdx}][name]" value="" placeholder="Name" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            <div class="form-group" style="flex: 1; margin:0;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Position</label>
                <select name="staff[${globalIdx}][position]" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    ${options}
                </select>
            </div>
            <button type="button" style="padding: 10px 15px; background: #ef4444; color: white; border: none; border-radius: 5px; cursor: pointer;" onclick="this.closest('.kesehatan-row').remove()">X</button>
        `;
        container.appendChild(row);
        globalIdx++;
    }
</script>

@endsection
