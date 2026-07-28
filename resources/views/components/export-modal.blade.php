<!-- resources/views/components/export-modal.blade.php -->
<div x-data="{ exportOpen: false }" @open-export-modal.window="exportOpen = true" class="relative z-[100]">
    <!-- Background backdrop -->
    <div x-show="exportOpen" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" 
         style="display: none;"></div>

    <div x-show="exportOpen" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="fixed inset-0 z-10 overflow-y-auto" 
         style="display: none;">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div @click.away="exportOpen = false" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <form action="{{ route('export.mydata') }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-xl font-bold leading-6 text-gray-900" id="modal-title">Export My Data</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-4">Pilih data apa saja yang ingin Anda unduh dalam format Excel (.xlsx).</p>
                                    
                                    <div class="space-y-3">
                                        <label class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors">
                                            <input type="checkbox" name="exports[]" value="profile" class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500" checked>
                                            <span class="ml-3 font-semibold text-gray-700">Profil Umum</span>
                                        </label>
                                        <label class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors">
                                            <input type="checkbox" name="exports[]" value="identity" class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500" checked>
                                            <span class="ml-3 font-semibold text-gray-700">Dokumen Identitas (Data)</span>
                                        </label>
                                        <label class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors">
                                            <input type="checkbox" name="exports[]" value="education" class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500" checked>
                                            <span class="ml-3 font-semibold text-gray-700">Dokumen Pendidikan (Data)</span>
                                        </label>
                                        <label class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors">
                                            <input type="checkbox" name="exports[]" value="team_experience" class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500" checked>
                                            <span class="ml-3 font-semibold text-gray-700">Pengalaman Tim</span>
                                        </label>
                                        <label class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors">
                                            <input type="checkbox" name="exports[]" value="event_experience" class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500" checked>
                                            <span class="ml-3 font-semibold text-gray-700">Pengalaman Event</span>
                                        </label>
                                        <label class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors">
                                            <input type="checkbox" name="exports[]" value="certifications" class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500" checked>
                                            <span class="ml-3 font-semibold text-gray-700">Sertifikasi</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="submit" @click="setTimeout(() => exportOpen = false, 500)" class="inline-flex w-full justify-center rounded-xl bg-green-600 px-3 py-2 text-sm font-bold text-white shadow-sm hover:bg-green-500 sm:ml-3 sm:w-auto">Unduh Excel</button>
                        <button type="button" @click="exportOpen = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
