<div class="space-y-4">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-4">
            <div class="h-12 w-12 bg-green-100 rounded-xl flex items-center justify-center text-green-600">
                <x-lucide-calculator class="h-6 w-6" />
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Keuangan (RKAS/BOS)</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pemantauan pencairan dana Bantuan Operasional Sekolah.</p>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 whitespace-nowrap">
                <thead class="border-b border-slate-200 bg-slate-50/75 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Tahun / Tahap</th>
                        <th class="px-5 py-4">Nominal Dana</th>
                        <th class="px-5 py-4">Tanggal Pencairan</th>
                        <th class="px-5 py-4">Status Laporan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($records as $r)
                        <tr class="hover:bg-green-50/30 transition group">
                            <td class="px-5 py-3 font-bold text-slate-800">BOS {{ $r->tahun_anggaran }} <span class="text-slate-400 font-normal">| Tahap {{ $r->tahap }}</span></td>
                            <td class="px-5 py-3 font-mono font-bold text-green-700">Rp {{ number_format($r->jumlah_dana, 0, ',', '.') }}</td>
                            <td class="px-5 py-3 text-slate-500">{{ $r->tanggal_pencairan ? \Carbon\Carbon::parse($r->tanggal_pencairan)->format('d F Y') : '-' }}</td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold text-slate-700 border border-slate-200">{{ ucfirst($r->status_pencairan) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-12 text-center text-slate-400">Belum ada data pencairan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($records->hasPages())
        <div class="px-5 py-3 border-t border-slate-100 bg-slate-50">{{ $records->links(data: ['scrollTo' => false]) }}</div>
        @endif
    </div>
</div>
