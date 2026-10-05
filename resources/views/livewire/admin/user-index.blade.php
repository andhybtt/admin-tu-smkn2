<div>
    @php
        $badge = [
            'admin'          => 'bg-violet-50 text-violet-700 ring-violet-200',
            'kepala_sekolah' => 'bg-amber-50 text-amber-700 ring-amber-200',
            'kepala_tu'      => 'bg-blue-50 text-blue-700 ring-blue-200',
            'kurikulum'      => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
            'petugas'        => 'bg-sky-50 text-sky-700 ring-sky-200',
            'subyek'         => 'bg-slate-100 text-slate-600 ring-slate-200',
        ];
        $totalUsers = $counts->sum();
    @endphp

    <!-- Header -->
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-slate-900">Manajemen Pengguna</h1>
            <p class="mt-0.5 text-sm text-slate-500">Kelola akun, peran, dan kata sandi seluruh pemakai sistem.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <button type="button" wire:click="downloadTemplate" id="btn-unduh-template" wire:loading.attr="disabled" wire:target="downloadTemplate"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-3.5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 transition hover:bg-slate-50 disabled:opacity-60">
                <x-lucide-file-text class="h-4 w-4" />
                Template CSV
            </button>
            <button type="button" wire:click="exportSiswa" id="btn-ekspor-siswa" wire:loading.attr="disabled" wire:target="exportSiswa"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-3.5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 transition hover:bg-slate-50 disabled:opacity-60">
                <x-lucide-download class="h-4 w-4" />
                Unduh Data Siswa
            </button>
            <button type="button" wire:click="openImport" id="btn-impor-siswa"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-3.5 py-2.5 text-sm font-bold text-white shadow-sm shadow-emerald-500/20 transition hover:bg-emerald-700 active:scale-[0.98]">
                <x-lucide-upload class="h-4 w-4" />
                Impor Siswa
            </button>
            <button type="button" wire:click="create" id="btn-tambah-pengguna"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm shadow-blue-500/20 transition hover:bg-blue-700 active:scale-[0.98]">
                <x-lucide-user-plus class="h-4 w-4" />
                Tambah Pengguna
            </button>
        </div>
    </div>

    <!-- Flash -->
    @if (session()->has('success'))
        <div x-data="{ open: true }" x-init="setTimeout(() => open = false, 5000)" x-show="open" x-transition
            class="mb-4 flex items-start gap-2 rounded-xl border border-emerald-200 bg-emerald-50 p-3 text-sm font-medium text-emerald-800">
            <x-lucide-check-circle class="mt-0.5 h-4 w-4 shrink-0" />
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-4 flex items-start gap-2 rounded-xl border border-red-200 bg-red-50 p-3 text-sm font-medium text-red-700">
            <x-lucide-alert-circle class="mt-0.5 h-4 w-4 shrink-0" />
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Statistik -->
    <div class="mb-6 grid grid-cols-2 gap-3 md:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Total Pengguna</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">{{ number_format($totalUsers, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Admin</p>
            <p class="mt-1 text-2xl font-bold text-violet-700">{{ $counts['admin'] ?? 0 }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Staf &amp; Pimpinan</p>
            <p class="mt-1 text-2xl font-bold text-blue-700">{{ $totalUsers - ($counts['admin'] ?? 0) - ($counts['subyek'] ?? 0) }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Siswa</p>
            <p class="mt-1 text-2xl font-bold text-slate-700">{{ number_format($counts['subyek'] ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Tabel -->
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-100 p-4 sm:flex-row sm:items-center">
            <div class="relative flex-1">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <x-lucide-search class="h-4 w-4" />
                </div>
                <input type="search" wire:model.live.debounce.300ms="search" id="cari-pengguna"
                    placeholder="Cari nama, username/NISN, NIS, kelas, atau email..."
                    class="block w-full rounded-lg border-0 py-2.5 pl-9 pr-3 text-sm text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600">
            </div>
            <select wire:model.live="roleFilter" id="filter-peran"
                class="block rounded-lg border-0 py-2.5 pl-3 pr-8 text-sm text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:w-52">
                <option value="">Semua Peran</option>
                @foreach ($roles as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50/70 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Pengguna</th>
                        <th class="px-4 py-3">Username / NISN</th>
                        <th class="px-4 py-3">NIS</th>
                        <th class="px-4 py-3">Peran</th>
                        <th class="px-4 py-3">Dibuat</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $user)
                        <tr wire:key="user-{{ $user->id }}" class="transition hover:bg-slate-50/60">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-xs font-bold text-blue-700">
                                        {{ strtoupper(mb_substr($user->name, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate font-semibold text-slate-800">
                                            {{ $user->name }}
                                            @if ($user->id === auth()->id())
                                                <span class="ml-1 rounded bg-emerald-50 px-1.5 py-0.5 text-[10px] font-bold text-emerald-700">Anda</span>
                                            @endif
                                        </p>
                                        <p class="truncate text-xs text-slate-400">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-mono text-xs text-slate-600">
                                {{ $user->username ?? '—' }}
                                @if($user->role === 'subyek')
                                    <span class="block text-[10px] text-slate-400 font-sans">NISN</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-mono text-xs">
                                @if ($user->siswa?->nis)
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-slate-800 bg-slate-100 px-2 py-0.5 rounded w-fit text-xs">{{ $user->siswa->nis }}</span>
                                        @if ($user->siswa->kelas_sekarang)
                                            <span class="text-[10px] text-blue-600 font-sans mt-0.5">{{ $user->siswa->kelas_sekarang }}</span>
                                        @endif
                                    </div>
                                @elseif ($user->role === 'subyek')
                                    <span class="text-amber-600 text-[11px] italic">Belum diisi</span>
                                @else
                                    <span class="text-slate-300">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-[11px] font-semibold ring-1 ring-inset {{ $badge[$user->role] ?? $badge['subyek'] }}">
                                    {{ $roles[$user->role] ?? $user->role }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-xs text-slate-500">{{ $user->created_at?->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-1.5">
                                    <button type="button" wire:click="edit({{ $user->id }})" title="Ubah / reset kata sandi"
                                        class="inline-flex items-center gap-1 rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-blue-50 hover:text-blue-700">
                                        <x-lucide-pencil class="h-3.5 w-3.5" /> Ubah
                                    </button>
                                    @if ($user->id !== auth()->id())
                                        <button type="button" wire:click="delete({{ $user->id }})"
                                            wire:confirm="Hapus pengguna {{ $user->name }}? Tindakan ini tidak dapat dibatalkan."
                                            title="Hapus pengguna"
                                            class="inline-flex items-center gap-1 rounded-lg bg-red-50 px-2.5 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-100">
                                            <x-lucide-trash-2 class="h-3.5 w-3.5" /> Hapus
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-sm text-slate-400">
                                Tidak ada pengguna yang cocok dengan pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="border-t border-slate-100 p-4">{{ $users->links() }}</div>
        @endif
    </div>

    <!-- Modal Form -->
    @if ($showForm)
        <div class="fixed inset-0 z-50 flex items-end justify-center bg-slate-900/50 p-0 backdrop-blur-sm sm:items-center sm:p-4"
            x-data x-on:keydown.escape.window="$wire.closeForm()">
            <div class="w-full max-w-lg rounded-t-2xl bg-white shadow-2xl sm:rounded-2xl" x-data="{ show: false }" wire:click.stop>
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">{{ $editingId ? 'Ubah Pengguna' : 'Tambah Pengguna' }}</h2>
                        <p class="text-xs text-slate-500">
                            {{ $editingId ? 'Kosongkan kata sandi bila tidak ingin mengubahnya.' : 'Lengkapi data akun pengguna baru.' }}
                        </p>
                    </div>
                    <button type="button" wire:click="closeForm" class="text-slate-400 hover:text-slate-600" aria-label="Tutup">
                        <x-lucide-x class="h-5 w-5" />
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4 px-5 py-5">
                    <div>
                        <label for="f-name" class="mb-1 block text-xs font-semibold text-slate-900">Nama Lengkap</label>
                        <input id="f-name" type="text" wire:model="name" autofocus
                            class="block w-full rounded-lg border-0 px-3 py-2.5 text-sm shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-blue-600">
                        @error('name') <span class="mt-1 block text-[11px] font-medium text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="f-username" class="mb-1 block text-xs font-semibold text-slate-900">
                                {{ $role === 'subyek' ? 'Username (NISN)' : 'Username' }}
                            </label>
                            <input id="f-username" type="text" wire:model="username" autocomplete="off"
                                placeholder="{{ $role === 'subyek' ? 'Nomor NISN Siswa' : 'Username pengguna' }}"
                                class="block w-full rounded-lg border-0 px-3 py-2.5 text-sm shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-blue-600">
                            @error('username') <span class="mt-1 block text-[11px] font-medium text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="f-role" class="mb-1 block text-xs font-semibold text-slate-900">Peran</label>
                            <select id="f-role" wire:model.live="role"
                                class="block w-full rounded-lg border-0 px-3 py-2.5 text-sm shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-blue-600">
                                @foreach ($roles as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('role') <span class="mt-1 block text-[11px] font-medium text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    @if ($role === 'subyek')
                        <div class="rounded-xl bg-blue-50/70 border border-blue-200/80 p-3.5 space-y-3">
                            <div class="flex items-center gap-1.5 text-blue-900 font-bold text-xs">
                                <x-lucide-graduation-cap class="w-4 h-4 text-blue-600 shrink-0" />
                                <span>Data Khusus Siswa (NIS & Kelas)</span>
                            </div>
                            <div class="grid gap-3 sm:grid-cols-2">
                                <div>
                                    <label for="f-nis" class="mb-1 block text-xs font-semibold text-slate-900">
                                        NIS <span class="text-blue-600 font-normal">(Password default siswa)</span>
                                    </label>
                                    <input id="f-nis" type="text" wire:model="nis" placeholder="Contoh: 12345001"
                                        class="block w-full rounded-lg border-0 px-3 py-2.5 text-sm shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 bg-white">
                                    @error('nis') <span class="mt-1 block text-[11px] font-medium text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="f-kelas" class="mb-1 block text-xs font-semibold text-slate-900">Kelas Sekarang</label>
                                    <input id="f-kelas" type="text" wire:model="kelas" placeholder="Contoh: XII RPL 1"
                                        class="block w-full rounded-lg border-0 px-3 py-2.5 text-sm shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 bg-white">
                                    @error('kelas') <span class="mt-1 block text-[11px] font-medium text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <p class="text-[11px] text-blue-800 leading-relaxed">
                                📌 <strong>Login Siswa:</strong> Username menggunakan <strong>NISN</strong> dan kata sandi default menggunakan <strong>NIS</strong>.
                            </p>
                        </div>
                    @endif

                    <div>
                        <label for="f-email" class="mb-1 block text-xs font-semibold text-slate-900">Email</label>
                        <input id="f-email" type="email" wire:model="email" autocomplete="off"
                            class="block w-full rounded-lg border-0 px-3 py-2.5 text-sm shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-blue-600">
                        @error('email') <span class="mt-1 block text-[11px] font-medium text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="f-password" class="mb-1 block text-xs font-semibold text-slate-900">
                            {{ $editingId ? 'Kata Sandi Baru (opsional)' : 'Kata Sandi' }}
                        </label>
                        <div class="flex gap-2">
                            <div class="relative flex-1">
                                <input id="f-password" wire:model="password" x-bind:type="show ? 'text' : 'password'" type="password" autocomplete="new-password"
                                    class="block w-full rounded-lg border-0 py-2.5 pl-3 pr-10 text-sm shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-blue-600">
                                <button type="button" x-on:click="show = !show"
                                    x-bind:aria-label="show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 transition-colors hover:text-blue-600">
                                    <x-lucide-eye x-show="!show" class="h-4 w-4" />
                                    <x-lucide-eye-off x-show="show" x-cloak class="h-4 w-4" />
                                </button>
                            </div>
                            <button type="button" wire:click="generatePassword" x-on:click="show = true"
                                class="inline-flex shrink-0 items-center gap-1.5 rounded-lg bg-slate-100 px-3 text-xs font-semibold text-slate-700 transition hover:bg-blue-50 hover:text-blue-700">
                                <x-lucide-refresh-cw class="h-3.5 w-3.5" /> Acak
                            </button>
                        </div>
                        @error('password') <span class="mt-1 block text-[11px] font-medium text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-2 border-t border-slate-100 pt-4">
                        <button type="button" wire:click="closeForm"
                            class="rounded-lg px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Batal</button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-700 active:scale-[0.98]">
                            <span wire:loading.remove wire:target="save">Simpan</span>
                            <span wire:loading wire:target="save">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal Impor Siswa -->
    @if ($showImport)
        <div class="fixed inset-0 z-50 flex items-end justify-center bg-slate-900/50 p-0 backdrop-blur-sm sm:items-center sm:p-4"
            x-data x-on:keydown.escape.window="$wire.closeImport()">
            <div class="flex max-h-[92vh] w-full max-w-xl flex-col rounded-t-2xl bg-white shadow-2xl sm:rounded-2xl"
                x-data="{ uploading: false, progress: 0 }"
                x-on:livewire-upload-start="uploading = true; progress = 0"
                x-on:livewire-upload-finish="uploading = false"
                x-on:livewire-upload-error="uploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress">
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Impor Data Siswa (CSV)</h2>
                        <p class="text-xs text-slate-500">Data siswa dan akun login dibuat sekaligus.</p>
                    </div>
                    <button type="button" wire:click="closeImport" class="text-slate-400 hover:text-slate-600" aria-label="Tutup">
                        <x-lucide-x class="h-5 w-5" />
                    </button>
                </div>

                <div class="space-y-4 overflow-y-auto px-5 py-5">
                    @if ($importResult === null)
                        <div class="rounded-xl border border-blue-100 bg-blue-50/60 p-3.5 text-xs leading-relaxed text-slate-600">
                            <p class="mb-1.5 font-bold text-blue-800">Petunjuk</p>
                            <ul class="list-disc space-y-1 pl-4">
                                <li>Unduh <button type="button" wire:click="downloadTemplate" class="font-semibold text-blue-700 underline">Template CSV</button>, isi data, lalu unggah kembali. <strong>Hapus baris contoh.</strong></li>
                                <li>Kolom: No, Nama, NISN, NIS, Kelas, Nama Orang Tua, Alamat Orang Tua, No HP Murid, No HP Orang Tua, Pekerjaan Orang Tua, Keterangan.</li>
                                <li><strong>NISN</strong>, <strong>NIS</strong>, dan <strong>Nama</strong> wajib diisi.</li>
                                <li>Akun login siswa: username = <strong>NISN</strong>, kata sandi awal = <strong>NIS</strong>.</li>
                                <li>Siswa dengan NIS yang sudah ada akan <strong>diperbarui</strong>, bukan digandakan. Kolom kosong tidak menimpa data lama.</li>
                                <li>Pemisah kolom <code>;</code> atau <code>,</code> dikenali otomatis. Simpan dari Excel sebagai <em>CSV UTF-8</em>.</li>
                            </ul>
                        </div>

                        <div>
                            <label for="file-impor" class="mb-1 block text-xs font-semibold text-slate-900">File CSV</label>
                            <input id="file-impor" type="file" wire:model="importFile" accept=".csv,.txt,text/csv"
                                class="block w-full cursor-pointer rounded-lg text-sm text-slate-600 ring-1 ring-inset ring-slate-300 file:mr-3 file:cursor-pointer file:border-0 file:bg-slate-100 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200">
                            <div x-show="uploading" x-cloak class="mt-2 h-1.5 w-full overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full rounded-full bg-emerald-500 transition-all" x-bind:style="`width: ${progress}%`"></div>
                            </div>
                            @error('importFile') <span class="mt-1 block text-[11px] font-medium text-red-500">{{ $message }}</span> @enderror
                        </div>
                    @else
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <div class="rounded-xl bg-emerald-50 p-3">
                                <p class="text-xl font-bold text-emerald-700">{{ $importResult['created'] }}</p>
                                <p class="text-[11px] font-medium text-emerald-700">Ditambahkan</p>
                            </div>
                            <div class="rounded-xl bg-blue-50 p-3">
                                <p class="text-xl font-bold text-blue-700">{{ $importResult['updated'] }}</p>
                                <p class="text-[11px] font-medium text-blue-700">Diperbarui</p>
                            </div>
                            <div class="rounded-xl {{ count($importResult['errors']) ? 'bg-red-50' : 'bg-slate-50' }} p-3">
                                <p class="text-xl font-bold {{ count($importResult['errors']) ? 'text-red-600' : 'text-slate-500' }}">{{ count($importResult['errors']) }}</p>
                                <p class="text-[11px] font-medium {{ count($importResult['errors']) ? 'text-red-600' : 'text-slate-500' }}">Gagal</p>
                            </div>
                        </div>
                        @if ($importResult['skipped'])
                            <p class="text-xs text-slate-500">{{ $importResult['skipped'] }} baris contoh dilewati.</p>
                        @endif

                        @if (count($importResult['errors']))
                            <div class="rounded-xl border border-red-100 bg-red-50/50 p-3">
                                <p class="mb-2 text-xs font-bold text-red-700">Baris yang gagal diproses</p>
                                <ul class="max-h-48 space-y-1 overflow-y-auto text-xs text-red-700">
                                    @foreach ($importResult['errors'] as $err)
                                        <li><span class="font-semibold">Baris {{ $err['line'] }}:</span> {{ $err['message'] }}</li>
                                    @endforeach
                                </ul>
                                <p class="mt-2 text-[11px] text-slate-500">Perbaiki baris tersebut lalu impor ulang. Baris yang sudah berhasil tidak akan digandakan.</p>
                            </div>
                        @endif
                    @endif
                </div>

                <div class="flex justify-end gap-2 border-t border-slate-100 px-5 py-4">
                    @if ($importResult === null)
                        <button type="button" wire:click="closeImport"
                            class="rounded-lg px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Batal</button>
                        <button type="button" wire:click="import" x-bind:disabled="uploading" wire:loading.attr="disabled" wire:target="import"
                            class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-700 active:scale-[0.98] disabled:opacity-60">
                            <x-lucide-upload class="h-4 w-4" />
                            <span wire:loading.remove wire:target="import">Mulai Impor</span>
                            <span wire:loading wire:target="import">Memproses...</span>
                        </button>
                    @else
                        <button type="button" wire:click="openImport"
                            class="rounded-lg px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Impor Lagi</button>
                        <button type="button" wire:click="closeImport"
                            class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-700">Selesai</button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
