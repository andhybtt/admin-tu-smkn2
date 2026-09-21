<div class="space-y-4">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Agenda Surat Keluar</h2>
            <p class="text-xs text-slate-500">Penomoran dan pengarsipan surat dinas keluar sekolah.</p>
        </div>
        <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-4 py-2.5 text-xs font-bold text-white shadow hover:bg-blue-800 transition">
            <x-lucide-plus class="h-4 w-4" />
            <span>Buat Surat Keluar</span>
        </button>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-left text-xs text-slate-600">
            <thead class="border-b border-slate-100 bg-slate-50/75 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-4 py-3">Nomor Surat</th>
                    <th class="px-4 py-3">Tujuan</th>
                    <th class="px-4 py-3">Tanggal Kirim</th>
                    <th class="px-4 py-3">Perihal</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($suratKeluarList as $sk)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-4 py-3 font-semibold text-blue-700">{{ $sk['nomor_surat'] }}</td>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $sk['tujuan'] }}</td>
                        <td class="px-4 py-3">{{ $sk['tanggal_kirim'] }}</td>
                        <td class="px-4 py-3">{{ $sk['perihal'] }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $sk['status'] === 'Terkirim' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $sk['status'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button class="p-1.5 text-slate-400 hover:text-blue-600 rounded-lg hover:bg-slate-100 transition">
                                <x-lucide-printer class="h-4 w-4" />
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
