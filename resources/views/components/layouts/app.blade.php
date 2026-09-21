<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#1d4ed8">

    <title>{{ $title ?? 'Sistem Tata Usaha' }} — SMKN Karanganyar</title>

    <!-- PWA Manifest & App Icons -->
    <link rel="manifest" href="/manifest.webmanifest">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">

    <!-- Tailwind & Livewire Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="flex h-full flex-col font-sans text-slate-800 selection:bg-blue-600 selection:text-white" x-data="{ sidebarOpen: false }">

    <div class="flex flex-1 overflow-hidden">
        <!-- Sidebar Desktop & Mobile Off-canvas Drawer -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col border-r border-slate-200 bg-white transition-transform duration-200 ease-in-out lg:static lg:translate-x-0"
        >
            <!-- Brand Header -->
            <div class="flex h-16 shrink-0 items-center justify-between border-b border-slate-100 px-5">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-700 text-white shadow-md shadow-blue-500/20">
                        <x-lucide-school class="h-5 w-5" />
                    </div>
                    <div>
                        <h1 class="text-xs font-bold uppercase tracking-wider text-blue-900 leading-tight">TU SMKN Karanganyar</h1>
                        <p class="text-[10px] text-slate-400 font-medium">Sistem Administrasi Sekolah</p>
                    </div>
                </div>
                <!-- Tombol Tutup Sidebar Mobile -->
                <button @click="sidebarOpen = false" class="text-slate-400 hover:text-slate-600 lg:hidden" aria-label="Tutup Menu">
                    <x-lucide-x class="h-5 w-5" />
                </button>
            </div>

            <!-- Navigasi Menu SPA dengan wire:navigate.hover -->
            <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4 text-sm font-medium">
                <a href="{{ route('dashboard') }}" 
                   wire:navigate.hover
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                    <x-lucide-layout-dashboard class="h-5 w-5" />
                    <span>Dashboard</span>
                </a>

                <div class="pt-4 pb-1">
                    <p class="px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">Persuratan & Arsip</p>
                </div>

                <a href="{{ route('persuratan.masuk') }}" 
                   wire:navigate.hover
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('persuratan.masuk*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                    <x-lucide-inbox class="h-5 w-5" />
                    <span>Surat Masuk</span>
                </a>

                <a href="{{ route('persuratan.keluar') }}" 
                   wire:navigate.hover
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('persuratan.keluar*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                    <x-lucide-send class="h-5 w-5" />
                    <span>Surat Keluar</span>
                </a>

                <div class="pt-4 pb-1">
                    <p class="px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">Administrasi Sekolah</p>
                </div>

                <a href="{{ route('kesiswaan.buku-induk') }}" 
                   wire:navigate.hover
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('kesiswaan.buku-induk*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                    <x-lucide-graduation-cap class="h-5 w-5" />
                    <span>Buku Induk Siswa</span>
                </a>

                <a href="{{ route('kepegawaian.index') }}" 
                   wire:navigate.hover
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('kepegawaian.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                    <x-lucide-briefcase class="h-5 w-5" />
                    <span>Data Guru & Pegawai</span>
                </a>

                <a href="{{ route('kesiswaan.legalisir') }}" 
                   wire:navigate.hover
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs('kesiswaan.legalisir*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                    <x-lucide-award class="h-5 w-5" />
                    <span>Legalisir Ijazah</span>
                </a>
            </nav>

            <!-- Profil Staf TU -->
            <div class="border-t border-slate-100 p-3">
                <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-2.5 border border-slate-100">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-700 font-bold text-xs">
                        TU
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-xs font-semibold text-slate-800">Petugas Tata Usaha</p>
                        <p class="truncate text-[10px] text-slate-400">SMKN Karanganyar</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Backdrop Mobile Drawer -->
        <div 
            x-show="sidebarOpen" 
            @click="sidebarOpen = false" 
            x-cloak 
            class="fixed inset-0 z-30 bg-slate-900/40 backdrop-blur-sm lg:hidden"
        ></div>

        <!-- Area Konten Utama -->
        <div class="flex flex-1 flex-col overflow-hidden">
            <!-- Header Atas -->
            <header class="flex h-16 shrink-0 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="text-slate-600 hover:text-slate-900 lg:hidden" aria-label="Buka Menu">
                        <x-lucide-menu class="h-6 w-6" />
                    </button>
                    <div class="font-bold text-slate-800 text-sm sm:text-base">
                        Sistem Informasi Tata Usaha
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 border border-emerald-200/50">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Livewire SPA
                    </span>
                </div>
            </header>

            <!-- Slot Konten Utama -->
            <main class="flex-1 overflow-y-auto p-4 pb-24 lg:pb-6 sm:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Mobile Bottom Bar (PWA Fast Access) -->
    <nav class="fixed bottom-0 inset-x-0 z-20 flex h-16 items-center justify-around border-t border-slate-200 bg-white/95 px-2 backdrop-blur-md lg:hidden shadow-lg">
        <a href="{{ route('dashboard') }}" wire:navigate.hover class="flex flex-col items-center gap-1 text-[10px] {{ request()->routeIs('dashboard') ? 'text-blue-600 font-bold' : 'text-slate-500' }}">
            <x-lucide-layout-dashboard class="h-5 w-5" />
            <span>Beranda</span>
        </a>
        <a href="{{ route('persuratan.masuk') }}" wire:navigate.hover class="flex flex-col items-center gap-1 text-[10px] {{ request()->routeIs('persuratan.masuk*') ? 'text-blue-600 font-bold' : 'text-slate-500' }}">
            <x-lucide-inbox class="h-5 w-5" />
            <span>Surat Masuk</span>
        </a>
        <a href="{{ route('persuratan.masuk.create') }}" wire:navigate.hover class="flex flex-col items-center gap-1 -mt-4 text-[10px] text-white">
            <div class="flex h-11 w-11 items-center justify-center rounded-full bg-blue-600 shadow-lg shadow-blue-500/40 active:scale-95 transition">
                <x-lucide-camera class="h-5 w-5 text-white" />
            </div>
            <span class="text-slate-700 font-medium text-[9px]">Scan Surat</span>
        </a>
        <a href="{{ route('kesiswaan.buku-induk') }}" wire:navigate.hover class="flex flex-col items-center gap-1 text-[10px] {{ request()->routeIs('kesiswaan.buku-induk*') ? 'text-blue-600 font-bold' : 'text-slate-500' }}">
            <x-lucide-graduation-cap class="h-5 w-5" />
            <span>Buku Induk</span>
        </a>
        <a href="{{ route('kesiswaan.legalisir') }}" wire:navigate.hover class="flex flex-col items-center gap-1 text-[10px] {{ request()->routeIs('kesiswaan.legalisir*') ? 'text-blue-600 font-bold' : 'text-slate-500' }}">
            <x-lucide-award class="h-5 w-5" />
            <span>Legalisir</span>
        </a>
    </nav>

    @livewireScripts
</body>
</html>
