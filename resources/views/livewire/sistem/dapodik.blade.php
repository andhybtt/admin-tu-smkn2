<div class="space-y-4">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-4">
            <div class="h-12 w-12 bg-cyan-100 rounded-xl flex items-center justify-center text-cyan-600">
                <x-lucide-database class="h-6 w-6" />
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Data Pokok (Dapodik)</h2>
                <p class="text-xs text-slate-500 mt-0.5">Monitoring riwayat sinkronisasi data dengan server pusat Kemdikbud.</p>
            </div>
        </div>
        <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-cyan-600 px-4 py-2.5 text-xs font-bold text-white shadow-lg shadow-cyan-500/30 hover:bg-cyan-700 transition active:scale-95">
            <x-lucide-refresh-cw class="h-4 w-4" />
            <span>Mulai Sinkronisasi</span>
        </button>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 whitespace-nowrap">
                <thead class="border-b border-slate-200 bg-slate-50/75 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Jenis Sinkronisasi</th>
                        <th class="px-5 py-4">Waktu Eksekusi</th>
                        <th class="px-5 py-4">Jumlah Data</th>
                        <th class="px-5 py-4">Status Akhir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($records as $r)
                        <tr class="hover:bg-cyan-50/30 transition group">
                            <td class="px-5 py-3 font-bold text-slate-800">{{ $r->jenis_sinkronisasi }}</td>
                            <td class="px-5 py-3 text-slate-500 font-mono">{{ \Carbon\Carbon::parse($r->tanggal_sinkron)->format('d M Y - H:i:s') }}</td>
                            <td class="px-5 py-3 font-bold text-slate-700">{{ number_format($r->jumlah_data) }} Record</td>
                            <td class="px-5 py-3">
                                @if($r->status === 'berhasil')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-700 border border-emerald-100"><x-lucide-check class="h-3 w-3"/> Berhasil</span>
                                @elseif($r->status === 'proses')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-bold text-amber-700 border border-amber-100"><x-lucide-loader class="h-3 w-3 animate-spin"/> Proses</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-2.5 py-1 text-[10px] font-bold text-rose-700 border border-rose-100"><x-lucide-x class="h-3 w-3"/> Gagal</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-12 text-center text-slate-400">Belum ada riwayat sinkronisasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($records->hasPages())
        <div class="px-5 py-3 border-t border-slate-100 bg-slate-50">{{ $records->links(data: ['scrollTo' => false]) }}</div>
        @endif
    </div>
</div>
