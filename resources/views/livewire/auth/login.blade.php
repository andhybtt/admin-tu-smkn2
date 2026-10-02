<div class="sm:mx-auto sm:w-full sm:max-w-md">
    <div class="flex justify-center">
        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-700 text-white shadow-lg shadow-blue-500/30">
            <x-lucide-school class="h-8 w-8 text-white" />
        </div>
    </div>
    <h2 class="mt-6 text-center text-2xl font-bold tracking-tight text-slate-900">SIM Tata Usaha</h2>
    <p class="mt-2 text-center text-sm text-slate-600">
        SMK Negeri Karanganyar
    </p>

    <div class="mt-8 bg-white py-8 px-4 shadow-sm sm:rounded-2xl sm:px-10 border border-slate-100">
        <form wire:submit="authenticate" class="space-y-6">
            <div>
                <label for="login" class="block text-sm font-medium leading-6 text-slate-900">Email atau Username</label>
                <div class="mt-2">
                    <input wire:model="login" id="login" name="login" type="text" autocomplete="username" required class="block w-full rounded-xl border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                </div>
                @error('login') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium leading-6 text-slate-900">Password</label>
                <div class="mt-2">
                    <input wire:model="password" id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-xl border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                </div>
                @error('password') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input wire:model="remember" id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                    <label for="remember-me" class="ml-3 block text-sm leading-6 text-slate-700">Ingat saya</label>
                </div>
            </div>

            <div>
                <button type="submit" class="flex w-full justify-center items-center gap-2 rounded-xl bg-blue-600 px-3 py-3 text-sm font-semibold text-white shadow-md hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition">
                    <span wire:loading.remove wire:target="authenticate">Masuk ke Sistem</span>
                    <span wire:loading wire:target="authenticate">
                        <x-lucide-loader-2 class="w-4 h-4 animate-spin" />
                    </span>
                </button>
            </div>
        </form>
        
        <div class="mt-8 pt-6 text-center text-xs text-slate-500 border-t border-slate-100 space-y-3">
            <p class="font-medium text-slate-700">Gunakan Akun Demo Berdasarkan Role:</p>
            <div class="grid grid-cols-2 gap-2 text-left bg-slate-50 p-3 rounded-lg border border-slate-100">
                <div><span class="font-bold">Subyek (Siswa):</span> <br>subyek / password</div>
                <div><span class="font-bold">Petugas TU:</span> <br>petugas / password</div>
                <div><span class="font-bold">Kepala TU:</span> <br>kepala_tu / password</div>
                <div><span class="font-bold">Kurikulum:</span> <br>kurikulum / password</div>
                <div><span class="font-bold">Kepala Sekolah:</span> <br>kepala_sekolah / password</div>
                <div><span class="font-bold">Admin:</span> <br>admin / password</div>
            </div>
        </div>
    </div>
</div>
