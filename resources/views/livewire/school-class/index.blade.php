<div>
    {{-- Stop trying to control. --}}
    <div class="bg-gradient-to-r from-indigo-600 to-blue-500 rounded-xl shadow-lg p-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="bg-white w-12 h-12 flex items-center justify-center rounded-full shadow-md shrink-0">
                    <i class="fas fa-school fa-fw text-indigo-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="text-xl sm:text-2xl font-bold text-white tracking-wide">
                        DATA KELAS
                    </h3>
                </div>
            </div>

            <button wire:click="openModal()"
                class="w-full sm:w-auto inline-flex items-center justify-center bg-white text-indigo-600 font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-indigo-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                <span>Tambah Kelas</span>
            </button>
        </div>
    </div>
</div>