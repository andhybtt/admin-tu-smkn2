<div class="space-y-6">
    <!-- Banner Sambutan -->
    <div class="rounded-2xl bg-gradient-to-r from-blue-700 to-indigo-800 p-6 text-white shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1 text-xs font-medium backdrop-blur-sm">
                <x-lucide-school class="h-3.5 w-3.5" /> SMKN Karanganyar
            </span>
            <h2 class="mt-2 text-xl sm:text-2xl font-bold">Halo, Staf Tata Usaha</h2>
            <p class="text-xs sm:text-sm text-blue-100 mt-1">Kelola administrasi persuratan, data siswa, buku induk, dan legalisir secara terpusat.</p>
        </div>
        <div>
            <a href="{{ route('persuratan.masuk.create') }}" wire:navigate.hover class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-xs font-bold text-blue-800 shadow hover:bg-blue-50 transition active:scale-95">
                <x-lucide-plus class="h-4 w-4" />
                <span>Registrasi & Scan Surat</span>
            </a>
        </div>
    </div>

    <!-- Statistik Ringkas -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-slate-500">Surat Masuk</span>
                <span class="rounded-lg bg-blue-50 p-2 text-blue-600">
                    <x-lucide-inbox class="h-4 w-4" />
                </span>
            </div>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $totalSuratMasuk }}</p>
            <p class="text-[11px] text-amber-600 mt-1 font-medium">{{ $pendingDisposisi }} menunggu disposisi</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-slate-500">Surat Keluar</span>
                <span class="rounded-lg bg-emerald-50 p-2 text-emerald-600">
                    <x-lucide-send class="h-4 w-4" />
                </span>
            </div>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $totalSuratKeluar }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Tahun ajaran aktif</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-slate-500">Buku Induk Siswa</span>
                <span class="rounded-lg bg-purple-50 p-2 text-purple-600">
                    <x-lucide-graduation-cap class="h-4 w-4" />
                </span>
            </div>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ number_format($totalSiswaAktif, 0, ',', '.') }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Total siswa terdata</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-slate-500">Guru & Karyawan</span>
                <span class="rounded-lg bg-amber-50 p-2 text-amber-600">
                    <x-lucide-users class="h-4 w-4" />
                </span>
            </div>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $totalGuruPegawai }}</p>
            <p class="text-[11px] text-slate-400 mt-1">PNS & P3K & GTT/PTT</p>
        </div>
    </div>

    <!-- Pintasan Cepat Menu TU -->
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <h3 class="text-sm font-bold text-slate-800 mb-4">Akses Cepat Administrasi TU</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <a href="{{ route('persuratan.masuk.create') }}" wire:navigate.hover class="flex flex-col items-center justify-center p-4 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-blue-50/50 hover:border-blue-200 transition group text-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-700 group-hover:scale-110 transition">
                    <x-lucide-camera class="h-5 w-5" />
                </div>
                <span class="mt-2 text-xs font-bold text-slate-700">Scan Surat Masuk</span>
                <span class="text-[10px] text-slate-400">Kamera HP / Upload</span>
            </a>

            <a href="{{ route('persuratan.masuk') }}" wire:navigate.hover class="flex flex-col items-center justify-center p-4 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-emerald-50/50 hover:border-emerald-200 transition group text-center">
                <div class="p-3 rounded-full bg-emerald-100 text-emerald-700 group-hover:scale-110 transition">
                    <x-lucide-file-text class="h-5 w-5" />
                </div>
                <span class="mt-2 text-xs font-bold text-slate-700">Agenda Disposisi</span>
                <span class="text-[10px] text-slate-400">Lembar disposisi kepala</span>
            </a>

            <a href="{{ route('kesiswaan.buku-induk') }}" wire:navigate.hover class="flex flex-col items-center justify-center p-4 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-purple-50/50 hover:border-purple-200 transition group text-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-700 group-hover:scale-110 transition">
                    <x-lucide-user-check class="h-5 w-5" />
                </div>
                <span class="mt-2 text-xs font-bold text-slate-700">Pencarian Siswa</span>
                <span class="text-[10px] text-slate-400">NISN & riwayat mutasi</span>
            </a>

            <a href="{{ route('kesiswaan.legalisir') }}" wire:navigate.hover class="flex flex-col items-center justify-center p-4 rounded-xl border border-slate-100 bg-slate-50/60 hover:bg-amber-50/50 hover:border-amber-200 transition group text-center">
                <div class="p-3 rounded-full bg-amber-100 text-amber-700 group-hover:scale-110 transition">
                    <x-lucide-award class="h-5 w-5" />
                </div>
                <span class="mt-2 text-xs font-bold text-slate-700">Layanan Legalisir</span>
                <span class="text-[10px] text-slate-400">Arsip Ijazah & Akreditasi</span>
            </a>
        </div>
    </div>
</div>
