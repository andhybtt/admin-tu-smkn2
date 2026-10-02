<div class="space-y-4">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-4">
            <div class="h-12 w-12 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600">
                <x-lucide-box class="h-6 w-6" />
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Aset & Inventaris</h2>
                <p class="text-xs text-slate-500 mt-0.5">Manajemen barang milik negara (BMN) dan sarana prasarana.</p>
            </div>
        </div>
        <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-orange-600 px-4 py-2.5 text-xs font-bold text-white shadow-lg shadow-orange-500/30 hover:bg-orange-700 transition active:scale-95">
            <x-lucide-plus class="h-4 w-4" />
            <span>Catat Aset Baru</span>
        </button>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 whitespace-nowrap">
                <thead class="border-b border-slate-200 bg-slate-50/75 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Kode Barang</th>
                        <th class="px-5 py-4">Nama Barang</th>
                        <th class="px-5 py-4">Kategori & Lokasi</th>
                        <th class="px-5 py-4">Kondisi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($records as $r)
                        <tr class="hover:bg-orange-50/30 transition group">
                            <td class="px-5 py-3 font-mono font-bold text-slate-500">{{ $r->kode_barang }}</td>
                            <td class="px-5 py-3 font-bold text-slate-800">{{ $r->nama_barang }}</td>
                            <td class="px-5 py-3">
                                <span class="font-medium text-orange-700 capitalize">{{ $r->kategori }}</span>
                                <span class="text-slate-400 mx-1">•</span>
                                <span class="text-slate-500">{{ $r->lokasi }}</span>
                            </td>
                            <td class="px-5 py-3">
                                @if($r->kondisi === 'baik')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-700 border border-emerald-100">Baik</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-2.5 py-1 text-[10px] font-bold text-rose-700 border border-rose-100">{{ ucfirst(str_replace('_', ' ', $r->kondisi)) }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-12 text-center text-slate-400">Belum ada data inventaris.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($records->hasPages())
        <div class="px-5 py-3 border-t border-slate-100 bg-slate-50">{{ $records->links(data: ['scrollTo' => false]) }}</div>
        @endif
    </div>
</div>
