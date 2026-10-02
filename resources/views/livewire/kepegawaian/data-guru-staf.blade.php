<div class="space-y-4">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-4">
            <div class="h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                <x-lucide-user-check class="h-6 w-6" />
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Data Pegawai & Karier</h2>
                <p class="text-xs text-slate-500 mt-0.5">Manajemen profil, golongan, dan status Guru & Tenaga Kependidikan.</p>
            </div>
        </div>
        <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-bold text-white shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition active:scale-95">
            <x-lucide-user-plus class="h-4 w-4" />
            <span>Tambah Pegawai</span>
        </button>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 whitespace-nowrap">
                <thead class="border-b border-slate-200 bg-slate-50/75 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Nama Lengkap & NIP</th>
                        <th class="px-5 py-4">Jabatan</th>
                        <th class="px-5 py-4">Status & Golongan</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($records as $r)
                        <tr class="hover:bg-blue-50/30 transition group">
                            <td class="px-5 py-3">
                                <p class="font-bold text-slate-800">{{ $r->nama_lengkap }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $r->nip ?? 'Belum ada NIP' }}</p>
                            </td>
                            <td class="px-5 py-3 text-slate-700 font-medium">{{ $r->jabatan }}</td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-700 border border-emerald-100 uppercase">
                                    {{ $r->status_pegawai }}
                                </span>
                                @if($r->golongan)
                                    <span class="text-[10px] text-slate-500 ml-2">Gol. {{ $r->golongan }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                <button class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition"><x-lucide-eye class="h-4 w-4" /></button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-12 text-center text-slate-400">Belum ada data pegawai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($records->hasPages())
        <div class="px-5 py-3 border-t border-slate-100 bg-slate-50">{{ $records->links(data: ['scrollTo' => false]) }}</div>
        @endif
    </div>
</div>
