<x-profile-layout title="Riwayat Pendidikan">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Riwayat Pendidikan</h3>
            <p class="text-sm text-gray-500 mb-6">Upload ijazah atau sertifikat pendidikan Anda (PDF/JPG/PNG). Maks 2MB per file.</p>

            <form action="{{ route('user.profile.education.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">

                    @php
                        $educationLevels = [
                            ['field' => 'elementary_school', 'label' => 'SD / Sederajat'],
                            ['field' => 'junior_high_school', 'label' => 'SMP / Sederajat'],
                            ['field' => 'senior_high_school', 'label' => 'SMA / Sederajat'],
                            ['field' => 'bachelor_university', 'label' => 'S1 / Diploma'],
                            ['field' => 'masters_university', 'label' => 'S2 (Magister)'],
                            ['field' => 'doctoral_university', 'label' => 'S3 (Doktoral)'],
                        ];
                    @endphp

                    @foreach($educationLevels as $level)
                        @php
                            $nameField = $level['field'] . '_name';
                            $fileField = $level['field'];
                            $pathField = $level['field'] . '_path';
                        @endphp
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
                            <div>
                                <label for="{{ $nameField }}" class="block text-sm font-medium text-gray-700 mb-1">Nama Institusi {{ $level['label'] }}</label>
                                <input type="text" name="{{ $nameField }}" id="{{ $nameField }}" value="{{ old($nameField, $education->$nameField) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                                @error($nameField) <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Ijazah {{ $level['label'] }}</label>
                                <input type="file" name="{{ $fileField }}" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                                @if($education->$pathField)
                                    <a href="{{ asset('storage/' . $education->$pathField) }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-1 inline-block">Lihat Ijazah Saat Ini</a>
                                @endif
                                @error($fileField) <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit"
                            class="inline-flex items-center px-6 py-2.5 bg-red-700 text-white text-sm font-semibold rounded-lg hover:bg-red-800 transition shadow-sm">
                        Simpan Pendidikan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-profile-layout>
