<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        {{-- Card Login --}}
        <div class="p-8 space-y-8 bg-white rounded-xl shadow-lg w-full max-w-md">
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center w-16 h-16 bg-indigo-600 rounded-full shadow-md mb-4">
                    <i class="fas fa-lock text-3xl text-white"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mt-4">
                    SISTEM INFORMASI AKADEMIK
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Masukkan kredensial Anda untuk melanjutkan
                </p>
            </div>

            <form wire:submit.prevent="login" class="mt-8 space-y-6">
                {{-- Input Email --}}
                <div>
                    <label for="email" class="sr-only">Email</label>
                    <input id="email" wire:model="email" type="email" required autofocus autocomplete="username"
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Alamat Email">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Input Password --}}
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" wire:model="password" type="password" required autocomplete="current-password"
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Password">
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Ingat Saya --}}
                <div class="flex items-center">
                    <input id="remember_me" wire:model="remember" type="checkbox"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                        Ingat saya
                    </label>
                </div>

                {{-- Tombol Login --}}
                <div>
                    <button type="submit" wire:loading.attr="disabled"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-70 disabled:cursor-not-allowed">
                        <span wire:loading.remove>
                            <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                        </span>
                        <span wire:loading.flex class="items-center">
                            <svg class="animate-spin h-5 w-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4l3.5-3.5L12 0v4a8 8 0 00-8 8h4z"></path>
                            </svg>
                            Loading...
                        </span>
                    </button>
                </div>
            </form>

            {{-- Link ke Register --}}
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>