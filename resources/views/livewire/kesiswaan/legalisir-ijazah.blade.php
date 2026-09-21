<div class="space-y-4">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Layanan Legalisir Ijazah Alumni</h2>
            <p class="text-xs text-slate-500">Verifikasi berkas ijazah, transkrip, dan pencatatan tanda tangan legalisir kepala sekolah.</p>
        </div>
        <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-4 py-2.5 text-xs font-bold text-white shadow hover:bg-blue-800 transition">
            <x-lucide-file-plus class="h-4 w-4" />
            <span>Permohonan Baru</span>
        </button>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-left text-xs text-slate-600">
            <thead class="border-b border-slate-100 bg-slate-50/75 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-4 py-3">No. Pengajuan</th>
                    <th class="px-4 py-3">Nama Alumni</th>
                    <th class="px-4 py-3">Lulusan</th>
                    <th class="px-4 py-3">Jenis Dokumen</th>
                    <th class="px-4 py-3">Jumlah</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($antrianLegalisir as $item)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-4 py-3 font-semibold text-slate-800">{{ $item['nomor_permohonan'] }}</td>
                        <td class="px-4 py-3 font-medium text-blue-700">{{ $item['nama_alumni'] }}</td>
                        <td class="px-4 py-3">{{ $item['tahun_lulus'] }}</td>
                        <td class="px-4 py-3">{{ $item['dokumen'] }}</td>
                        <td class="px-4 py-3">{{ $item['jumlah'] }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $item['status'] === 'Siap Diambil' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                {{ $item['status'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button class="p-1.5 text-slate-400 hover:text-blue-600 rounded-lg hover:bg-slate-100 transition">
                                <x-lucide-badge-check class="h-4 w-4" />
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
