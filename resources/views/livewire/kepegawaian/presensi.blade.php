<div class="space-y-4">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-4">
            <div class="h-12 w-12 bg-teal-100 rounded-xl flex items-center justify-center text-teal-600">
                <x-lucide-calendar-clock class="h-6 w-6" />
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Presensi & e-Kinerja</h2>
                <p class="text-xs text-slate-500 mt-0.5">Rekapitulasi kehadiran dan izin pegawai (PNS/Honorer).</p>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 whitespace-nowrap">
                <thead class="border-b border-slate-200 bg-slate-50/75 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Pegawai</th>
                        <th class="px-5 py-4">Tanggal</th>
                        <th class="px-5 py-4">Masuk / Pulang</th>
                        <th class="px-5 py-4">Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($records as $r)
                        <tr class="hover:bg-teal-50/30 transition group">
                            <td class="px-5 py-3 font-bold text-slate-800">{{ $r->pegawai->nama_lengkap ?? 'Unknown' }}</td>
                            <td class="px-5 py-3 text-slate-500">{{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}</td>
                            <td class="px-5 py-3 font-mono font-bold text-slate-600">
                                {{ $r->jam_masuk ?? '--:--' }} - {{ $r->jam_pulang ?? '--:--' }}
                            </td>
                            <td class="px-5 py-3">
                                @if($r->status === 'hadir')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-teal-50 px-2.5 py-1 text-[10px] font-bold text-teal-700 border border-teal-100">Hadir</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-2.5 py-1 text-[10px] font-bold text-rose-700 border border-rose-100">{{ ucfirst($r->status) }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-12 text-center text-slate-400">Belum ada data presensi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($records->hasPages())
        <div class="px-5 py-3 border-t border-slate-100 bg-slate-50">{{ $records->links(data: ['scrollTo' => false]) }}</div>
        @endif
    </div>
</div>
