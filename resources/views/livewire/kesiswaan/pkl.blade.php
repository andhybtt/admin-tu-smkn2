<div class="space-y-4">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-4">
            <div class="h-12 w-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600">
                <x-lucide-briefcase class="h-6 w-6" />
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Administrasi PKL</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pendaftaran, asuransi magang, dan pengawasan Prakerin.</p>
            </div>
        </div>
        <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-xs font-bold text-white shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 transition active:scale-95">
            <x-lucide-building class="h-4 w-4" />
            <span>Daftar PKL Baru</span>
        </button>
    </div>

    <!-- Data Table -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 whitespace-nowrap">
                <thead class="border-b border-slate-200 bg-slate-50/75 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Siswa / Jurusan</th>
                        <th class="px-5 py-4">Instansi / DUDI</th>
                        <th class="px-5 py-4">Durasi Pelaksanaan</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($records as $r)
                        <tr class="hover:bg-indigo-50/30 transition group">
                            <td class="px-5 py-3">
                                <p class="font-bold text-slate-800">{{ $r->siswa->nama_lengkap ?? 'Siswa Terhapus' }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $r->siswa->kompetensi_keahlian ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-3">
                                <p class="font-bold text-indigo-700">{{ $r->nama_dudi }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5 truncate max-w-[200px]">{{ $r->alamat_dudi ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-3 text-slate-500">
                                {{ \Carbon\Carbon::parse($r->tanggal_mulai)->format('d M') }} - 
                                {{ $r->tanggal_selesai ? \Carbon\Carbon::parse($r->tanggal_selesai)->format('d M Y') : 'Berjalan' }}
                            </td>
                            <td class="px-5 py-3">
                                @if($r->status === 'pengajuan')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-bold text-amber-700 border border-amber-100">
                                        <x-lucide-clock class="h-3 w-3" /> Pengajuan
                                    </span>
                                @elseif($r->status === 'selesai')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-700 border border-emerald-100">
                                        <x-lucide-check-circle class="h-3 w-3" /> Selesai
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-1 text-[10px] font-bold text-blue-700 border border-blue-100">
                                        <x-lucide-activity class="h-3 w-3" /> {{ ucfirst(str_replace('_', ' ', $r->status)) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                <button class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                                    <x-lucide-eye class="h-4 w-4" />
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <x-lucide-building class="h-10 w-10 text-slate-200 mb-3" />
                                    <p class="font-medium text-slate-500 text-sm">Belum ada pengajuan PKL.</p>
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
