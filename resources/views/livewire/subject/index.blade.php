<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="bg-gradient-to-r from-indigo-600 to-blue-500 rounded-xl shadow-lg p-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="bg-white w-12 h-12 flex items-center justify-center rounded-full shadow-md shrink-0">
                    <i class="fas fa-book-open fa-fw text-indigo-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="text-xl sm:text-2xl font-bold text-white tracking-wide">DATA MATA PELAJARAN</h3>
                </div>
            </div>
            <button wire:click="openModal()"
                class="w-full sm:w-auto inline-flex items-center justify-center bg-white text-indigo-600 font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-indigo-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                <span>Tambah Mata Pelajaran</span>
            </button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 mt-6 relative">
        @include('livewire.loading', ['target' => 'store, openModal, closeModal'])
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
            <input type="text" wire:model.live="search" placeholder="Cari Mata Pelajaran..."
                class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full">
        </div>

        <div class="grid grid-cols-1 gap-4 md:hidden overflow-x-auto">
            @forelse($subjects as $subject)
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 shadow-sm">
                <div class="flex justify-between items-start gap-3">
                    <div class="space-y-1">
                        <p class="font-bold text-gray-800 text-lg">{{ $subject['name'] ?? 'N/A' }}</p>
                    </div>
                    <div class="flex gap-2 shrink-0">
                        <button wire:click="openModal({{ $subject['id'] }})"
                            class="w-9 h-9 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg flex items-center justify-center shadow-md transition-transform hover:scale-110">
                            <i class="fas fa-pen text-sm"></i>
                        </button>
                        <button wire:click="confirmDelete({{ $subject['id'] }})"
                            class="w-9 h-9 bg-red-600 hover:bg-red-700 text-white rounded-lg flex items-center justify-center shadow-md transition-transform hover:scale-110">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-200 grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Jumlah Jam</p>
                        <p class="font-medium text-gray-700">{{ $subject['hours'] ?? 0 }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Kode Mata Pelajaran</p>
                        <p class="font-medium text-gray-700">{{ $subject['code'] ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-1 py-12 text-center text-gray-500">
                <div class="flex flex-col items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-3" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span>Tidak ada data loket yang ditemukan.</span>
                </div>
            </div>
            @endforelse
        </div>

        <div class="hidden md:block w-full overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
            <table class="min-w-full table-auto divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            No.
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Mata Pelajaran
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kode Mata Pelajaran
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jam</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($subjects as $subject)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">{{
                            $subject['name'] ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $subject['code'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $subject['hours'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button wire:click="openModal({{ $subject['id'] }})"
                                    class="w-9 h-9 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg flex items-center justify-center shadow-md transition-transform hover:scale-110">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button wire:click="confirmDelete({{ $subject['id'] }})"
                                    class="w-9 h-9 bg-red-600 hover:bg-red-700 text-white rounded-lg flex items-center justify-center shadow-md transition-transform hover:scale-110">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span>Tidak ada data guru yang ditemukan.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex flex-wrap items-center justify-center sm:justify-end gap-2">
            <button wire:click="goToPage(1)" @if($currentPage==1) disabled @endif
                class="px-3 py-1 border rounded {{ $currentPage==1 ? 'bg-gray-200 cursor-not-allowed' : 'bg-white hover:bg-gray-100' }}">
                Awal
            </button>

            <button wire:click="goToPage({{ $currentPage - 1 }})" @if($currentPage==1) disabled @endif
                class="px-3 py-1 border rounded {{ $currentPage==1 ? 'bg-gray-200 cursor-not-allowed' : 'bg-white hover:bg-gray-100' }}">
                Sebelumnya
            </button>

            @php
            $start = max($currentPage - 2, 1);
            $end = min($currentPage + 2, $lastPage);
            @endphp

            @for ($i = $start; $i <= $end; $i++) <button wire:click="goToPage({{ $i }})"
                class="px-3 py-1 border rounded {{ $currentPage==$i ? 'bg-indigo-600 text-white' : 'bg-white hover:bg-gray-100' }}">
                {{ $i }}
                </button>
                @endfor

                <button wire:click="goToPage({{ $currentPage + 1 }})" @if($currentPage==$lastPage) disabled @endif
                    class="px-3 py-1 border rounded {{ $currentPage==$lastPage ? 'bg-gray-200 cursor-not-allowed' : 'bg-white hover:bg-gray-100' }}">
                    Berikutnya
                </button>

                <button wire:click="goToPage({{ $lastPage }})" @if($currentPage==$lastPage) disabled @endif
                    class="px-3 py-1 border rounded {{ $currentPage==$lastPage ? 'bg-gray-200 cursor-not-allowed' : 'bg-white hover:bg-gray-100' }}">
                    Akhir
                </button>
        </div>
    </div>
    <div x-show="$wire.isModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
        <div @click.away="$wire.closeModal()"
            class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4 overflow-hidden">
            <form wire:submit.prevent="store">
                <div class="bg-gradient-to-r from-indigo-600 to-blue-500 px-6 py-4">
                    <h3 class="text-lg font-bold text-white">
                        {{ $subjectId ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran' }}
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Mata Pelajaran</label>
                        <input wire:model="name" type="text" id="name" placeholder="Masukkan nama mata pelajaran"
                            class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700">Kode Mata Pelajaran</label>
                        <input wire:model="code" type="text" id="code" placeholder="Contoh: MATH101"
                            class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('code') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="hours" class="block text-sm font-medium text-gray-700">Jumlah Jam</label>
                        <input wire:model="hours" type="number" id="hours" placeholder="Contoh: 40"
                            class="mt-1 px-3 py-2 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('hours') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">
                    <button type="button" wire:click="closeModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        {{ $subjectId ? 'Simpan Perubahan' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="$wire.isDeleteModalOpen" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">

        <div @click.away="$wire.closeDeleteModal()"
            class="bg-white rounded-lg shadow-xl w-full max-w-xl mx-4 overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-red-700 to-red-500 px-6 py-4 flex items-center gap-3">
                <div class="bg-white p-2 rounded-full shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01M12 5a7 7 0 100 14a7 7 0 000-14z" />
                    </svg>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-white">
                    Konfirmasi Hapus
                </h3>
            </div>

            <!-- Body -->
            <div class="p-6 text-center">
                <svg class="mx-auto mb-4 text-red-500 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h3 class="mb-5 text-base sm:text-lg font-normal text-gray-600">
                    Apakah Anda yakin ingin menghapus data ini?
                </h3>
                <div class="flex justify-center gap-3">
                    <button wire:click="delete" type="button"
                        class="text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 shadow-md transition">
                        <span wire:loading.remove wire:target="delete">Ya, Hapus</span>
                        <span wire:loading wire:target="delete">Menghapus...</span>
                    </button>
                    <button wire:click="closeDeleteModal" type="button"
                        class="text-gray-600 bg-white hover:bg-gray-100 rounded-lg border border-gray-300 text-sm font-medium px-5 py-2.5 shadow-sm transition">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div>
        @if (session()->has('success') || session()->has('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:translate-x-full"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transform transition ease-in duration-300"
            x-transition:leave-start="opacity-100 sm:translate-x-0"
            x-transition:leave-end="opacity-0 sm:translate-x-full"
            class="fixed top-5 inset-x-4 sm:inset-auto sm:right-5 sm:top-5 z-50 w-auto sm:max-w-sm">

            <div class="flex items-start gap-3 px-4 py-3 rounded-xl shadow-lg relative overflow-hidden
            {{ session()->has('success') 
                ? 'bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500' 
                : 'bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500' }}">

                <!-- Icon -->
                <div class="mt-1 shrink-0">
                    @if (session()->has('success'))
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 
                                11-18 0 9 9 0 0118 0z" />
                    </svg>
                    @endif
                    @if (session()->has('error'))
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
                        {{ session()->has('success') ? 'Berhasil!' : 'Gagal!' }}
                    </p>
                    <p class="text-sm text-gray-600 break-words">
                        {{ session('success') ?? session('error') }}
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
</div>