<div class="space-y-4">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-4">
            <div class="h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                <x-lucide-book-open class="h-6 w-6" />
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Buku Induk Siswa</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pengelolaan data induk peserta didik dan mutasi sekolah.</p>
            </div>
        </div>
        <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-bold text-white shadow-lg shadow-blue-500/30 hover:bg-blue-700 hover:shadow-blue-500/40 transition active:scale-95">
            <x-lucide-plus-circle class="h-4 w-4" />
            <span>Tambah Siswa Baru</span>
        </button>
    </div>

    <!-- Filters & Search -->
    <div class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <x-lucide-search class="h-4 w-4" />
            </span>
            <input 
                type="search" 
                wire:model.live.debounce.300ms="search" 
                placeholder="Cari berdasarkan Nama, NIS, atau NISN..." 
                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-xs placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-sm"
            >
        </div>
        <div class="sm:w-48 relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <x-lucide-filter class="h-4 w-4" />
            </span>
            <select wire:model.live="filterStatus" class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-9 pr-8 text-xs text-slate-600 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-sm appearance-none cursor-pointer">
                <option value="">Semua Status</option>
                <option value="aktif">Status: Aktif</option>
                <option value="lulus">Status: Lulus</option>
                <option value="pindah">Status: Mutasi Pindah</option>
                <option value="keluar">Status: Keluar (DO)</option>
            </select>
        </div>
    </div>

    <!-- Data Table -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 whitespace-nowrap">
                <thead class="border-b border-slate-200 bg-slate-50/75 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Nomor Induk</th>
                        <th class="px-5 py-4">Identitas Siswa</th>
                        <th class="px-5 py-4">Rombel / Jurusan</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($siswas as $siswa)
                        <tr class="hover:bg-blue-50/30 transition group">
                            <td class="px-5 py-3">
                                <p class="font-bold text-slate-800">{{ $siswa->nis }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">NISN: {{ $siswa->nisn ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 shrink-0 border border-slate-200">
                                        <x-lucide-user class="h-4 w-4" />
                                    </div>
                                    <div>
                                        <p class="font-bold text-blue-700 group-hover:text-blue-800 transition">{{ $siswa->nama_lengkap }}</p>
                                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') : '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                <p class="font-bold text-slate-700">{{ $siswa->kelas_sekarang ?? 'Belum ada kelas' }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $siswa->kompetensi_keahlian ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-3">
                                @if($siswa->status === 'aktif')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-700 border border-emerald-100">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Aktif
                                    </span>
                                @elseif($siswa->status === 'lulus')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-1 text-[10px] font-bold text-blue-700 border border-blue-100">
                                        <x-lucide-graduation-cap class="h-3 w-3" /> Lulus
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-2.5 py-1 text-[10px] font-bold text-rose-700 border border-rose-100">
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> {{ ucfirst($siswa->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition">
                                    <button class="p-1.5 text-blue-500 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition" title="Lihat Profil">
                                        <x-lucide-eye class="h-4 w-4" />
                                    </button>
                                    <button class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition" title="Edit Data">
                                        <x-lucide-edit class="h-4 w-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <x-lucide-folder-search class="h-10 w-10 text-slate-200 mb-3" />
                                    <p class="font-medium text-slate-500 text-sm">Tidak ada data siswa ditemukan.</p>
                                    <p class="text-xs mt-1">Gunakan kata kunci pencarian yang lain.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($siswas->hasPages())
        <div class="px-5 py-3 border-t border-slate-100 bg-slate-50">
            {{ $siswas->links(data: ['scrollTo' => false]) }}
        </div>
        @endif
    </div>
</div>
