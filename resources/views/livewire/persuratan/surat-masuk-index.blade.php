<div class="space-y-4">
    <!-- Header Halaman -->
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Agenda Surat Masuk</h2>
            <p class="text-xs text-slate-500">Pencatatan, pengarsipan, dan disposisi surat dinas/instansi.</p>
        </div>
        <a href="{{ route('persuratan.masuk.create') }}" wire:navigate.hover class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-4 py-2.5 text-xs font-bold text-white shadow hover:bg-blue-800 transition active:scale-95">
            <x-lucide-plus class="h-4 w-4" />
            <span>Catat Surat Baru</span>
        </a>
    </div>

    <!-- Alert Notifikasi Flash -->
    @if (session()->has('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-3 text-xs text-emerald-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <x-lucide-check-circle-2 class="h-4 w-4 text-emerald-600" />
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Toolbar Pencarian Real-time -->
    <div class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <x-lucide-search class="h-4 w-4" />
            </span>
            <input 
                type="search" 
                wire:model.live.debounce.300ms="search" 
                placeholder="Cari nomor surat, pengirim, atau isi ringkas perihal..."
                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-9 pr-4 text-xs placeholder-slate-400 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600"
            >
        </div>
    </div>

    <!-- Tabel Responsif -->
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="border-b border-slate-100 bg-slate-50/75 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-4 py-3">No. Agenda</th>
                        <th class="px-4 py-3">No. & Tanggal Surat</th>
                        <th class="px-4 py-3">Pengirim</th>
                        <th class="px-4 py-3">Perihal Ringkas</th>
                        <th class="px-4 py-3">Status Disposisi</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($daftarSurat as $surat)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-4 py-3 font-semibold text-slate-800 whitespace-nowrap">{{ $surat['nomor_agenda'] }}</td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-blue-700">{{ $surat['nomor_surat'] }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">Diterima: {{ $surat['tanggal_terima'] }}</p>
                            </td>
                            <td class="px-4 py-3 font-medium text-slate-700">{{ $surat['pengirim'] }}</td>
                            <td class="px-4 py-3 max-w-xs truncate">{{ $surat['perihal'] }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($surat['status_disposisi'] === 'Sudah Disposisi')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold text-emerald-700">
                                        <x-lucide-check class="h-3 w-3" /> Disposisi Selesai
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-0.5 text-[10px] font-semibold text-amber-700">
                                        <x-lucide-clock class="h-3 w-3" /> Belum Disposisi
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1">
                                    <button class="p-1.5 text-slate-400 hover:text-blue-600 rounded-lg hover:bg-slate-100 transition" title="Lihat Detail">
                                        <x-lucide-eye class="h-4 w-4" />
                                    </button>
                                    <button class="p-1.5 text-slate-400 hover:text-indigo-600 rounded-lg hover:bg-slate-100 transition" title="Cetak Disposisi">
                                        <x-lucide-printer class="h-4 w-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <x-lucide-inbox class="h-8 w-8 text-slate-300" />
                                    <p class="text-xs">Tidak ada data surat masuk yang cocok.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
