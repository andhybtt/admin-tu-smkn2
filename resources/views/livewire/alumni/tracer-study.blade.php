<div class="space-y-4">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-4">
            <div class="h-12 w-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600">
                <x-lucide-graduation-cap class="h-6 w-6" />
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Tracer Study & BKK</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pelacakan karir lulusan (Bekerja, Kuliah, Wirausaha).</p>
            </div>
        </div>
        <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-purple-600 px-4 py-2.5 text-xs font-bold text-white shadow-lg shadow-purple-500/30 hover:bg-purple-700 transition active:scale-95">
            <x-lucide-radar class="h-4 w-4" />
            <span>Update Data Lulusan</span>
        </button>
    </div>

    <!-- Data Table -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 whitespace-nowrap">
                <thead class="border-b border-slate-200 bg-slate-50/75 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Identitas Alumni</th>
                        <th class="px-5 py-4">Tahun Lulus</th>
                        <th class="px-5 py-4">Status & Karir</th>
                        <th class="px-5 py-4">Kontak (Update Terakhir)</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($records as $r)
                        <tr class="hover:bg-purple-50/30 transition group">
                            <td class="px-5 py-3">
                                <p class="font-bold text-slate-800">{{ $r->siswa->nama_lengkap ?? 'Alumni Terhapus' }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">NISN: {{ $r->siswa->nisn ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-3 font-semibold text-slate-700">
                                Lulusan {{ $r->tahun_lulus }}
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex flex-col gap-1">
                                    <span class="inline-flex w-fit items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold text-slate-700 border border-slate-200">
                                        <x-lucide-briefcase class="h-3 w-3" /> {{ ucfirst(str_replace('_', ' ', $r->status_alumni)) }}
                                    </span>
                                    @if($r->nama_instansi)
                                        <p class="text-[10px] text-purple-700 font-medium">{{ $r->nama_instansi }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-3 text-slate-500">
                                {{ $r->kontak_terbaru ?? '-' }}
                            </td>
                            <td class="px-5 py-3 text-right">
                                <button class="p-1.5 text-slate-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition">
                                    <x-lucide-edit class="h-4 w-4" />
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <x-lucide-search class="h-10 w-10 text-slate-200 mb-3" />
                                    <p class="font-medium text-slate-500 text-sm">Belum ada data tracer study terekam.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($records->hasPages())
        <div class="px-5 py-3 border-t border-slate-100 bg-slate-50">
            {{ $records->links(data: ['scrollTo' => false]) }}
        </div>
        @endif
    </div>
</div>
