<div class="space-y-4">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-4">
            <div class="h-12 w-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600">
                <x-lucide-handshake class="h-6 w-6" />
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Akreditasi & MoU DUDI</h2>
                <p class="text-xs text-slate-500 mt-0.5">Manajemen kerja sama institusi dan mitra Dunia Usaha/Industri.</p>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 whitespace-nowrap">
                <thead class="border-b border-slate-200 bg-slate-50/75 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Instansi / Mitra</th>
                        <th class="px-5 py-4">Fokus Kerjasama</th>
                        <th class="px-5 py-4">Masa Berlaku</th>
                        <th class="px-5 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($records as $r)
                        <tr class="hover:bg-indigo-50/30 transition group">
                            <td class="px-5 py-3 font-bold text-slate-800">{{ $r->nama_instansi }}</td>
                            <td class="px-5 py-3 uppercase font-semibold text-indigo-700">{{ $r->jenis_kerjasama }}</td>
                            <td class="px-5 py-3 text-slate-500">
                                S/d {{ \Carbon\Carbon::parse($r->masa_berlaku)->format('d M Y') }}
                            </td>
                            <td class="px-5 py-3">
                                @if($r->status_aktif)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-700 border border-emerald-100">Aktif</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold text-slate-500 border border-slate-200">Kedaluwarsa</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-12 text-center text-slate-400">Belum ada MoU tercatat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($records->hasPages())
        <div class="px-5 py-3 border-t border-slate-100 bg-slate-50">{{ $records->links(data: ['scrollTo' => false]) }}</div>
        @endif
    </div>
</div>
