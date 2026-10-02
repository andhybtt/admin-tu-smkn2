<div class="space-y-4">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-4">
            <div class="h-12 w-12 bg-sky-100 rounded-xl flex items-center justify-center text-sky-600">
                <x-lucide-plane class="h-6 w-6" />
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Perjalanan Dinas (SPT)</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pengajuan dan penerbitan Surat Perintah Tugas (SPT).</p>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 whitespace-nowrap">
                <thead class="border-b border-slate-200 bg-slate-50/75 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Pegawai Ditugaskan</th>
                        <th class="px-5 py-4">Tujuan & Agenda</th>
                        <th class="px-5 py-4">Periode</th>
                        <th class="px-5 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($records as $r)
                        <tr class="hover:bg-sky-50/30 transition group">
                            <td class="px-5 py-3 font-bold text-slate-800">{{ $r->pegawai->nama_lengkap ?? 'Unknown' }}</td>
                            <td class="px-5 py-3">
                                <p class="font-bold text-sky-700">{{ $r->tujuan }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $r->agenda }}</p>
                            </td>
                            <td class="px-5 py-3 text-slate-500">
                                {{ \Carbon\Carbon::parse($r->tanggal_berangkat)->format('d M') }} - 
                                {{ \Carbon\Carbon::parse($r->tanggal_kembali)->format('d M Y') }}
                            </td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold text-slate-700 border border-slate-200">{{ ucfirst($r->status) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-12 text-center text-slate-400">Belum ada SPT.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($records->hasPages())
        <div class="px-5 py-3 border-t border-slate-100 bg-slate-50">{{ $records->links(data: ['scrollTo' => false]) }}</div>
        @endif
    </div>
</div>
