<x-profile-layout title="Dokumen Identitas">
    <div class="bg-white/90 backdrop-blur-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl transition-all">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Dokumen Identitas</h3>
            <p class="text-sm text-gray-500 mb-6">Upload dokumen identitas resmi Anda. File maksimal 2MB per dokumen (PDF/JPG/PNG).</p>

            <form action="{{ route('user.profile.identity.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">

                    {{-- Foto Profil --}}
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <label class="block text-sm font-bold text-gray-900 mb-2">Pas Foto Resmi</label>
                        <div class="flex items-center gap-4">
                            <div id="photoPreviewContainer">
                                @if($identity->photo_path)
                                    <img id="profilePreview" src="{{ asset('storage/' . $identity->photo_path) }}" alt="Foto" class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md">
                                @else
                                    <img id="profilePreview" src="#" alt="Foto" class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md hidden">
                                    <div id="profileSvg" class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-400">
                                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <input type="file" id="photoInput" name="photo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                                @error('photo') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- NIK / KTP --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
                        <div>
                            <label for="national_id_number" class="block text-sm font-bold text-gray-700 mb-1">Nomor Induk Kependudukan (NIK)</label>
                            <input type="text" name="national_id_number" id="national_id_number" value="{{ old('national_id_number', $identity->national_id_number) }}" class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                            @error('national_id_number') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Upload KTP</label>
                            <input type="file" name="national_id" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                            @if($identity->national_id_path)
                                <a href="{{ asset('storage/' . $identity->national_id_path) }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-1 inline-block">Lihat Dokumen Saat Ini</a>
                            @endif
                            @error('national_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- KK --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
                        <div>
                            <label for="family_card_number" class="block text-sm font-bold text-gray-700 mb-1">Nomor Kartu Keluarga (KK)</label>
                            <input type="text" name="family_card_number" id="family_card_number" value="{{ old('family_card_number', $identity->family_card_number) }}" class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                            @error('family_card_number') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Upload Kartu Keluarga</label>
                            <input type="file" name="family_card" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                            @if($identity->family_card_path)
                                <a href="{{ asset('storage/' . $identity->family_card_path) }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-1 inline-block">Lihat Dokumen Saat Ini</a>
                            @endif
                            @error('family_card') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Akta Kelahiran --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
                        <div>
                            <label for="birth_certificate_number" class="block text-sm font-bold text-gray-700 mb-1">Nomor Akta Kelahiran</label>
                            <input type="text" name="birth_certificate_number" id="birth_certificate_number" value="{{ old('birth_certificate_number', $identity->birth_certificate_number) }}" class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                            @error('birth_certificate_number') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Upload Akta Kelahiran</label>
                            <input type="file" name="birth_certificate" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                            @if($identity->birth_certificate_path)
                                <a href="{{ asset('storage/' . $identity->birth_certificate_path) }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-1 inline-block">Lihat Dokumen Saat Ini</a>
                            @endif
                            @error('birth_certificate') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    
                    {{-- KIA --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
                        <div>
                            <label for="child_identity_card_number" class="block text-sm font-bold text-gray-700 mb-1">Nomor Kartu Identitas Anak (KIA) <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="text" name="child_identity_card_number" id="child_identity_card_number" value="{{ old('child_identity_card_number', $identity->child_identity_card_number) }}" class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                            @error('child_identity_card_number') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Upload KIA</label>
                            <input type="file" name="child_identity" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                            @if($identity->child_identity_path)
                                <a href="{{ asset('storage/' . $identity->child_identity_path) }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-1 inline-block">Lihat Dokumen Saat Ini</a>
                            @endif
                            @error('child_identity') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    
                    {{-- BPJS --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
                        <div>
                            <label for="bpjs_number" class="block text-sm font-bold text-gray-700 mb-1">Nomor BPJS</label>
                            <input type="text" name="bpjs_number" id="bpjs_number" value="{{ old('bpjs_number', $identity->bpjs_number) }}" class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                            @error('bpjs_number') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Upload BPJS</label>
                            <input type="file" name="bpjs" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                            @if($identity->bpjs_path)
                                <a href="{{ asset('storage/' . $identity->bpjs_path) }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-1 inline-block">Lihat Dokumen Saat Ini</a>
                            @endif
                            @error('bpjs') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    
                    {{-- Asuransi Pribadi --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
                        <div>
                            <label for="private_insurance_number" class="block text-sm font-bold text-gray-700 mb-1">Nomor Asuransi Pribadi <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="text" name="private_insurance_number" id="private_insurance_number" value="{{ old('private_insurance_number', $identity->private_insurance_number) }}" class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                            @error('private_insurance_number') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Upload Asuransi Pribadi</label>
                            <input type="file" name="private_insurance" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                            @if($identity->private_insurance_path)
                                <a href="{{ asset('storage/' . $identity->private_insurance_path) }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-1 inline-block">Lihat Dokumen Saat Ini</a>
                            @endif
                            @error('private_insurance') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    
                    {{-- Pakta Integritas U16 --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
                        <div>
                            <label for="under_16_integrity_pact_name" class="block text-sm font-bold text-gray-700 mb-1">Nama Pakta Integritas U-16 <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="text" name="under_16_integrity_pact_name" id="under_16_integrity_pact_name" value="{{ old('under_16_integrity_pact_name', $identity->under_16_integrity_pact_name) }}" class="w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors text-sm">
                            @error('under_16_integrity_pact_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Upload Pakta Integritas U-16</label>
                            <input type="file" name="under_16_integrity_pact" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                            @if($identity->under_16_integrity_pact_path)
                                <a href="{{ asset('storage/' . $identity->under_16_integrity_pact_path) }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-1 inline-block">Lihat Dokumen Saat Ini</a>
                            @endif
                            @error('under_16_integrity_pact') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit"
                            class="inline-flex items-center px-6 py-2.5 bg-red-700 text-white text-sm font-semibold rounded-lg hover:bg-red-800 transition shadow-sm">
                        Simpan Dokumen Identitas
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const photoInput = document.getElementById('photoInput');
            const profilePreview = document.getElementById('profilePreview');
            const profileSvg = document.getElementById('profileSvg');

            photoInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        profilePreview.src = e.target.result;
                        profilePreview.classList.remove('hidden');
                        if (profileSvg) {
                            profileSvg.classList.add('hidden');
                        }
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</x-profile-layout>
