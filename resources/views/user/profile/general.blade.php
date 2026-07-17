<x-profile-layout title="Profil Umum">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Informasi Profil Umum</h3>
            <p class="text-sm text-gray-500 mb-6">Lengkapi data diri Anda sesuai dengan kartu identitas yang berlaku.</p>

            <form action="{{ route('user.profile.general.update') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $profile->phone) }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                        @error('phone')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                        <select name="gender" id="gender" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="laki-laki" {{ old('gender', $profile->gender) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="perempuan" {{ old('gender', $profile->gender) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="birth_regency" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir (Kabupaten / Kota)</label>
                        <select name="birth_regency" id="birth_regency" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                            <option value="">Pilih Kab / Kota</option>
                            @foreach(config('dropdown.birth_regencies') as $reg)
                                <option value="{{ $reg }}" {{ old('birth_regency', $profile->birth_regency) == $reg ? 'selected' : '' }}>{{ $reg }}</option>
                            @endforeach
                        </select>
                        @error('birth_regency')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="birth_province" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir (Provinsi)</label>
                        <select name="birth_province" id="birth_province" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                            <option value="">Pilih Provinsi</option>
                            @foreach(config('dropdown.provinces') as $prov)
                                <option value="{{ $prov }}" {{ old('birth_province', $profile->birth_province) == $prov ? 'selected' : '' }}>{{ $prov }}</option>
                            @endforeach
                        </select>
                        @error('birth_province')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                        <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $profile->birth_date) }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                        @error('birth_date')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="address_by_id" class="block text-sm font-medium text-gray-700 mb-1">Alamat Sesuai KTP</label>
                        <textarea name="address_by_id" id="address_by_id" rows="3"
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">{{ old('address_by_id', $profile->address_by_id) }}</textarea>
                        @error('address_by_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="current_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Domisili Sekarang (Bila Berbeda)</label>
                        <textarea name="current_address" id="current_address" rows="3"
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">{{ old('current_address', $profile->current_address) }}</textarea>
                        @error('current_address')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="branch_board_regency" class="block text-sm font-medium text-gray-700 mb-1">Pengurus Cabang (Pengcab) / Kab / Kota</label>
                        <select name="branch_board_regency" id="branch_board_regency" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                            <option value="">Pilih Kab / Kota</option>
                            @foreach(config('dropdown.other_regencies') as $reg)
                                <option value="{{ $reg }}" {{ old('branch_board_regency', $profile->branch_board_regency) == $reg ? 'selected' : '' }}>{{ $reg }}</option>
                            @endforeach
                        </select>
                        @error('branch_board_regency')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="branch_board_province" class="block text-sm font-medium text-gray-700 mb-1">Pengurus Provinsi (Pengprov)</label>
                        <select name="branch_board_province" id="branch_board_province" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                            <option value="">Pilih Provinsi</option>
                            @foreach(config('dropdown.provinces') as $prov)
                                <option value="{{ $prov }}" {{ old('branch_board_province', $profile->branch_board_province) == $prov ? 'selected' : '' }}>{{ $prov }}</option>
                            @endforeach
                        </select>
                        @error('branch_board_province')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center px-6 py-2.5 bg-red-700 text-white text-sm font-semibold rounded-lg hover:bg-red-800 transition shadow-sm">
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-profile-layout>
