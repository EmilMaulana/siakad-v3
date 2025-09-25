<div>
    @if (session()->has('successMessage') || session()->has('errorMessage'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
        x-transition:enter="transform transition ease-out duration-300"
        x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:translate-x-full"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transform transition ease-in duration-300"
        x-transition:leave-start="opacity-100 sm:translate-x-0" x-transition:leave-end="opacity-0 sm:translate-x-full"
        class="fixed top-5 inset-x-4 sm:inset-auto sm:right-5 sm:top-5 z-50 w-auto sm:max-w-sm">

        <div class="flex items-start gap-3 px-4 py-3 rounded-xl shadow-lg relative overflow-hidden
            {{ session()->has('successMessage') 
                ? 'bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500' 
                : 'bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500' }}">

            <!-- Icon -->
            <div class="mt-1 shrink-0">
                @if (session()->has('successMessage'))
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 
                                11-18 0 9 9 0 0118 0z" />
                </svg>
                @endif
                @if (session()->has('errorMessage'))
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856
                                c1.54 0 2.502-1.667 1.732-3L13.732 4
                                c-.77-1.333-2.694-1.333-3.464 0L3.34 
                                16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                @endif
            </div>

            <!-- Isi Pesan -->
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-gray-800">
                    {{ session()->has('successMessage') ? 'Berhasil!' : 'Gagal!' }}
                </p>
                <p class="text-sm text-gray-600 break-words">
                    {{ session('successMessage') ?? session('errorMessage') }}
                </p>
            </div>

            <!-- Tombol Close -->
            <button @click="show = false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    @endif
</div>