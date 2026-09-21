<div class="space-y-4">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Data Pendidik & Tenaga Kependidikan</h2>
            <p class="text-xs text-slate-500">Database kepegawaian, NIP, pangkat, dan jabatan staf SMKN Karanganyar.</p>
        </div>
        <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-4 py-2.5 text-xs font-bold text-white shadow hover:bg-blue-800 transition">
            <x-lucide-user-plus class="h-4 w-4" />
            <span>Tambah Pegawai</span>
        </button>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-left text-xs text-slate-600">
            <thead class="border-b border-slate-100 bg-slate-50/75 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-4 py-3">NIP / NUPTK</th>
                    <th class="px-4 py-3">Nama Lengkap</th>
                    <th class="px-4 py-3">Tugas / Jabatan</th>
                    <th class="px-4 py-3">Status Kepegawaian</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($pegawaiList as $p)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-4 py-3 font-semibold text-slate-800">{{ $p['nip'] }}</td>
                        <td class="px-4 py-3 font-medium text-blue-700">{{ $p['nama'] }}</td>
                        <td class="px-4 py-3">{{ $p['jabatan'] }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2 py-0.5 text-[10px] font-semibold text-blue-700">
                                {{ $p['status'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button class="p-1.5 text-slate-400 hover:text-blue-600 rounded-lg hover:bg-slate-100 transition">
                                <x-lucide-edit class="h-4 w-4" />
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
