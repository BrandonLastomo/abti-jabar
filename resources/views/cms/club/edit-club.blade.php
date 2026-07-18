@extends('cms.layouts.master')

@section('title', 'Edit Club / Profile Tim')

@section('content')
<div class="section">
    <div class="sectionHead">
        <h2>Edit Club / Profile Tim</h2>
    </div>

    <div class="sectionBody">
        <form action="{{ route('club.update', $club->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div style="color:red; margin-bottom:15px; margin-top:15px; background: #fff2f2; padding: 10px; border: 1px solid red; border-radius: 5px;">
                    <ul style="margin:0; padding-left:20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="field">
                <label>Category <span style="color:red;">*</span></label>
                <select name="category" required>
                    <option value="">-- Pilih Category --</option>
                    <option value="indoor" {{ old('category', $club->category) == 'indoor' ? 'selected' : '' }}>Westjava Indoor</option>
                    <option value="beach" {{ old('category', $club->category) == 'beach' ? 'selected' : '' }}>Westjava Beach</option>
                    <option value="wheelchair" {{ old('category', $club->category) == 'wheelchair' ? 'selected' : '' }}>Westjava Wheelchair</option>
                </select>
            </div>

            <div class="field">
                <label>Subcategory <span style="color:red;">*</span></label>
                <select name="subcategory" required>
                    <option value="">-- Pilih Subcategory --</option>
                    <option value="Senior putra" {{ old('subcategory', $club->subcategory) == 'Senior putra' ? 'selected' : '' }}>Senior putra</option>
                    <option value="Senior putri" {{ old('subcategory', $club->subcategory) == 'Senior putri' ? 'selected' : '' }}>Senior putri</option>
                    <option value="U-21 putra" {{ old('subcategory', $club->subcategory) == 'U-21 putra' ? 'selected' : '' }}>U-21 putra</option>
                    <option value="U-21 putri" {{ old('subcategory', $club->subcategory) == 'U-21 putri' ? 'selected' : '' }}>U-21 putri</option>
                    <option value="U-17 putra" {{ old('subcategory', $club->subcategory) == 'U-17 putra' ? 'selected' : '' }}>U-17 putra</option>
                    <option value="U-17 putri" {{ old('subcategory', $club->subcategory) == 'U-17 putri' ? 'selected' : '' }}>U-17 putri</option>
                    <option value="U-15 putra" {{ old('subcategory', $club->subcategory) == 'U-15 putra' ? 'selected' : '' }}>U-15 putra</option>
                    <option value="U-15 putri" {{ old('subcategory', $club->subcategory) == 'U-15 putri' ? 'selected' : '' }}>U-15 putri</option>
                    <option value="Lihat Semua Tim" {{ old('subcategory', $club->subcategory) == 'Lihat Semua Tim' ? 'selected' : '' }}>Lihat Semua Tim (Wheelchair)</option>
                </select>
            </div>

            <div class="field">
                <label>Nama Club / Tim <span style="color:red;">*</span></label>
                <input type="text" name="name" value="{{ old('name', $club->name) }}" required>
            </div>

            <div class="field">
                <label>Status Club</label>
                <select name="club_status">
                    <option value="">-- Pilih Status --</option>
                    <option value="amatir" {{ old('club_status', $club->club_status) == 'amatir' ? 'selected' : '' }}>Amatir</option>
                    <option value="profesional" {{ old('club_status', $club->club_status) == 'profesional' ? 'selected' : '' }}>Profesional</option>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="field">
                    <label>Logo (Maks 2MB)</label>
                    @if($club->logo)
                        <div style="margin-bottom: 10px;">
                            <img src="{{ asset('storage/' . $club->logo) }}" alt="Logo" style="max-height: 80px; border-radius: 4px;">
                        </div>
                    @endif
                    <div style="display:flex; align-items:center; gap:10px;">
                        <label class="btn-upload">
                            Change File
                            <input type="file" name="logo" id="logo-input" accept="image/*,.svg" hidden>
                        </label>
                        <span id="logo-name" style="font-size:14px; color:#555;">No file chosen</span>
                    </div>
                </div>

                <div class="field">
                    <label>Picture / Foto Tim (Maks 2MB)</label>
                    @if($club->picture)
                        <div style="margin-bottom: 10px;">
                            <img src="{{ asset('storage/' . $club->picture) }}" alt="Picture" style="max-height: 80px; border-radius: 4px;">
                        </div>
                    @endif
                    <div style="display:flex; align-items:center; gap:10px;">
                        <label class="btn-upload">
                            Change File
                            <input type="file" name="picture" id="picture-input" accept="image/*,.svg" hidden>
                        </label>
                        <span id="picture-name" style="font-size:14px; color:#555;">No file chosen</span>
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $club->email) }}">
                </div>
                <div class="field">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $club->phone) }}">
                </div>
            </div>

            <div class="field">
                <label>Website</label>
                <input type="text" name="website" value="{{ old('website', $club->website) }}">
            </div>

            <div class="field">
                <label>Pengcab Address</label>
                <input type="text" name="pengcab_address" value="{{ old('pengcab_address', $club->pengcab_address) }}">
            </div>

            <div class="field">
                <label>Office Address</label>
                <input type="text" name="office_address" value="{{ old('office_address', $club->office_address) }}">
            </div>

            <div class="field">
                <label>Office Address Complete (Alamat Lengkap Kantor)</label>
                <textarea name="office_address_complete" rows="3">{{ old('office_address_complete', $club->office_address_complete) }}</textarea>
            </div>

            <div class="field">
                <label>Venue Address</label>
                <input type="text" name="venue_address" value="{{ old('venue_address', $club->venue_address) }}">
            </div>

            <div class="field">
                <label>Venue Address Complete (Alamat Lengkap Venue)</label>
                <textarea name="venue_address_complete" rows="3">{{ old('venue_address_complete', $club->venue_address_complete) }}</textarea>
            </div>

            <div class="actions" style="margin-top: 20px;">
                <a href="{{ route('club.index') }}" class="btn btn-edit">Kembali</a>
                <button type="submit" class="btn primary">Update Club</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById("logo-input").addEventListener("change", function () {
        const file = this.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('File terlalu besar! Maksimal 2MB.');
                this.value = '';
                document.getElementById("logo-name").textContent = "No file chosen";
                return;
            }
            document.getElementById("logo-name").textContent = file.name;
        } else {
            document.getElementById("logo-name").textContent = "No file chosen";
        }
    });

    document.getElementById("picture-input").addEventListener("change", function () {
        const file = this.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('File terlalu besar! Maksimal 2MB.');
                this.value = '';
                document.getElementById("picture-name").textContent = "No file chosen";
                return;
            }
            document.getElementById("picture-name").textContent = file.name;
        } else {
            document.getElementById("picture-name").textContent = "No file chosen";
        }
    });
</script>
@endsection

