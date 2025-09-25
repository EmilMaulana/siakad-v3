<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'SISTEM INFORMASI AKADEMIK' }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <!-- Trix Editor (jika diperlukan) -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

</head>

<body class="bg-slate-100 text-gray-800 overflow-x-hidden">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="w-64 bg-white shadow-lg fixed inset-y-0 left-0 z-50 transform -translate-x-full md:translate-x-0 overflow-hidden">
            <!-- Logo -->
            <div class="flex items-center justify-center h-20 bg-indigo-600 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-10 w-10 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15l4.5-4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-xl font-extrabold text-white logo-text">Antree</span>
            </div>

            <!-- Navigasi -->
            <nav class="flex-1 px-4 py-6 overflow-y-auto">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center p-3 rounded-lg transition duration-200 {{ request()->routeIs('dashboard') ? 'text-indigo-600 bg-indigo-50 hover:bg-indigo-100' : 'text-gray-700 hover:bg-gray-100 hover:text-indigo-600' }}">
                            <i class="fas fa-home fa-fw mr-3 text-md"></i>
                            <span class="font-medium nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('academic-year.index') }}"
                            class="flex items-center p-3 rounded-lg transition duration-200 {{ request()->routeIs('academic-year.index') ? 'text-indigo-600 bg-indigo-50 hover:bg-indigo-100' : 'text-gray-700 hover:bg-gray-100 hover:text-indigo-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span class="font-medium nav-text">Tahun Akademik</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('major.index') }}"
                            class="flex items-center p-3 rounded-lg transition duration-200 {{ request()->routeIs('major.index') ? 'text-indigo-600 bg-indigo-50 hover:bg-indigo-100' : 'text-gray-700 hover:bg-gray-100 hover:text-indigo-600' }}">
                            <i class="fas fa-book fa-fw mr-3 text-md"></i>
                            <span class="font-medium nav-text">Jurusan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('teacher.index') }}"
                            class="flex items-center p-3 rounded-lg transition duration-200 {{ request()->routeIs('teacher.index') ? 'text-indigo-600 bg-indigo-50 hover:bg-indigo-100' : 'text-gray-700 hover:bg-gray-100 hover:text-indigo-600' }}">
                            <i class="fas fa-chalkboard-teacher fa-fw mr-3 text-md"></i>
                            <span class="font-medium nav-text">Data Guru</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('subject.index') }}"
                            class="flex items-center p-3 rounded-lg transition duration-200 {{ request()->routeIs('subject.index') ? 'text-indigo-600 bg-indigo-50 hover:bg-indigo-100' : 'text-gray-700 hover:bg-gray-100 hover:text-indigo-600' }}">
                            <i class="fas fa-book-open fa-fw mr-3 text-md"></i>
                            <span class="font-medium nav-text">Mata Pelajaran</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('class.index') }}"
                            class="flex items-center p-3 rounded-lg transition duration-200 {{ request()->routeIs('class.index') ? 'text-indigo-600 bg-indigo-50 hover:bg-indigo-100' : 'text-gray-700 hover:bg-gray-100 hover:text-indigo-600' }}">
                            <i class="fas fa-school fa-fw mr-3 text-md"></i>
                            <span class="font-medium nav-text">Data Kelas</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Tombol Collapse -->
            <div class="p-4 border-t border-gray-200 hidden md:block">
                <button id="collapse-btn"
                    class="w-full flex items-center justify-center p-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-indigo-600">
                    <i id="collapse-icon" class="fas fa-chevron-left transition-transform duration-300"></i>
                </button>
            </div>
        </aside>

        <!-- Konten Utama -->
        <div id="main-content" class="flex-1 flex flex-col md:ml-64">
            <!-- Header -->
            <header
                class="flex items-center justify-between h-20 bg-white shadow-md px-6 z-40 fixed top-0 left-0 right-0">
                <div class="flex items-center">
                    <button id="sidebar-toggle" class="text-gray-500 focus:outline-none focus:text-gray-700 md:hidden">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="relative group">
                    </div>
                    @php
                    $user = session('user');
                    $name = $user['name'] ?? 'Guest';

                    $initials = collect(explode(' ', $name))
                    ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                    ->join('');
                    @endphp

                    <div class="flex items-center space-x-4">
                        <div class="relative group">
                            <button class="flex items-center text-gray-600 hover:text-indigo-600 focus:outline-none">
                                <img src="https://placehold.co/40x40/e2e8f0/334155?text={{ $initials }}"
                                    alt="User Avatar" class="w-10 h-10 rounded-full border-2 border-indigo-500" />
                                <span class="ml-2 font-medium hidden sm:block">
                                    {{ $name }}
                                </span>
                                <i class="fas fa-chevron-down ml-2 text-sm"></i>
                            </button>

                            <div
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform scale-95 group-hover:scale-100 origin-top-right">
                                {{-- <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profil</a>
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Pengaturan</a> --}}
                                {{-- <div class="border-t border-gray-200 my-1"></div> --}}
                                {{-- <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Keluar</a> --}}

                                <livewire:auth.logout />
                            </div>
                        </div>
                    </div>

                </div>
            </header>

            <main class="flex-1 p-6 bg-slate-100 pt-24">

                <livewire:alert />

                {{ $slot }}
            </main>

            <footer class="bg-white text-center p-4 text-sm text-gray-500 mt-auto">
                &copy; 2025 Wanara Digital Indonesia. Hak Cipta Dilindungi.
            </footer>
        </div>
    </div>

    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const mainHeader = document.getElementById('main-header');
            const collapseBtn = document.getElementById('collapse-btn');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const collapseIcon = document.getElementById('collapse-icon');
            const navTexts = document.querySelectorAll('.nav-text');
            const logoText = document.querySelector('.logo-text');

            if (collapseBtn) {
                collapseBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('collapsed');
                    
                    if (sidebar.classList.contains('collapsed')) {
                        mainContent.classList.remove('md:ml-64');
                        mainContent.classList.add('md:ml-20');
                        mainHeader.classList.remove('md:left-64');
                        mainHeader.classList.add('md:left-20');
                    } else {
                        mainContent.classList.remove('md:ml-20');
                        mainContent.classList.add('md:ml-64');
                        mainHeader.classList.remove('md:left-20');
                        mainHeader.classList.add('md:left-64');
                    }
                });
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.remove('-translate-x-full');
                    sidebarOverlay.classList.remove('hidden');
                });
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                });
            }

            const alerts = document.querySelectorAll('#success-alert, #error-alert');
        
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.style.display = 'none', 500);
                }, 3000);
        
                const closeButton = alert.querySelector('.close-alert-btn');
                if (closeButton) {
                    closeButton.addEventListener('click', () => {
                        alert.style.opacity = '0';
                        setTimeout(() => alert.style.display = 'none', 500);
                    });
                }
            });
        });
    </script>
</body>

</html>