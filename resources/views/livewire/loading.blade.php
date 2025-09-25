<div wire:loading.flex wire:target="{{ $target }}"
    class="absolute inset-0 bg-white bg-opacity-70 z-10 flex items-center justify-center rounded-xl">
    <div class="flex flex-col items-center">
        <svg class="animate-spin h-6 w-6 text-indigo-600 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
            </path>
        </svg>
        <span>Sedang memuat data...</span>
    </div>
</div>