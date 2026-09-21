<div class="space-y-4">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Buku Induk Peserta Didik</h2>
            <p class="text-xs text-slate-500">Pencarian identitas siswa, nomor induk siswa nasional, dan riwayat studi.</p>
        </div>
        <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-4 py-2.5 text-xs font-bold text-white shadow hover:bg-blue-800 transition">
            <x-lucide-user-plus class="h-4 w-4" />
            <span>Tambah Data Siswa</span>
        </button>
    </div>

    <div class="relative">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
            <x-lucide-search class="h-4 w-4" />
        </span>
        <input 
            type="search" 
            wire:model.live.debounce.300ms="search" 
            placeholder="Ketik NISN atau Nama lengkap siswa..." 
            class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-9 pr-4 text-xs placeholder-slate-400 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600"
        >
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-left text-xs text-slate-600">
            <thead class="border-b border-slate-100 bg-slate-50/75 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-4 py-3">NISN</th>
                    <th class="px-4 py-3">Nama Lengkap</th>
                    <th class="px-4 py-3">Kelas</th>
                    <th class="px-4 py-3">Konsentrasi Keahlian</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($siswaList as $s)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-4 py-3 font-semibold text-slate-800">{{ $s['nisn'] }}</td>
                        <td class="px-4 py-3 font-medium text-blue-700">{{ $s['nama'] }}</td>
                        <td class="px-4 py-3">{{ $s['kelas'] }}</td>
                        <td class="px-4 py-3">{{ $s['jurusan'] }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold text-emerald-700">
                                {{ $s['status'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button class="p-1.5 text-slate-400 hover:text-blue-600 rounded-lg hover:bg-slate-100 transition" title="Lihat Profil Induk">
                                <x-lucide-eye class="h-4 w-4" />
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
