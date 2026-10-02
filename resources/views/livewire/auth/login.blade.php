<div class="min-h-screen flex items-center justify-center bg-slate-900 relative overflow-hidden px-4 w-full">
    <!-- Animated Background Gradients -->
    <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] bg-blue-600 rounded-full mix-blend-screen filter blur-[100px] opacity-40 animate-pulse"></div>
    <div class="absolute bottom-[-20%] right-[-10%] w-[600px] h-[600px] bg-indigo-600 rounded-full mix-blend-screen filter blur-[120px] opacity-40 animate-pulse" style="animation-delay: 2s;"></div>

    <div class="relative w-full max-w-md z-10">
        <!-- Glass Card -->
        <div class="bg-slate-800/40 backdrop-blur-2xl border border-white/10 rounded-3xl p-8 sm:p-10 shadow-2xl">
            <!-- Logo & Brand -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-lg shadow-blue-500/30 mb-5 border border-white/20">
                    <x-lucide-school class="w-8 h-8" />
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">SIM Tata Usaha</h1>
                <p class="text-blue-200 text-sm mt-2 font-medium">SMK Negeri Karanganyar</p>
            </div>

            <!-- Login Form -->
            <form wire:submit="authenticate" class="space-y-5">
                @if (session()->has('error'))
                    <div class="bg-red-500/20 border border-red-500/50 text-red-100 px-4 py-3 rounded-xl text-sm text-center backdrop-blur-sm animate-pulse">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="space-y-4">
                    <!-- Input Email/Username -->
                    <div>
                        <label for="login" class="block text-sm font-medium text-blue-100 mb-1.5 ml-1">Username / Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-400 transition-colors">
                                <x-lucide-user class="h-5 w-5" />
                            </div>
                            <input wire:model="login" id="login" type="text" required autofocus
                                class="block w-full pl-11 pr-4 py-3.5 bg-slate-900/50 border border-white/10 rounded-xl text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-slate-900/80 transition-all outline-none"
                                placeholder="Masukkan username">
                        </div>
                        @error('login') <span class="text-red-400 text-xs mt-1.5 block ml-1 font-medium">{{ $message }}</span> @enderror
                    </div>

                    <!-- Input Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-blue-100 mb-1.5 ml-1">Kata Sandi</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-400 transition-colors">
                                <x-lucide-lock class="h-5 w-5" />
                            </div>
                            <input wire:model="password" id="password" type="password" required
                                class="block w-full pl-11 pr-4 py-3.5 bg-slate-900/50 border border-white/10 rounded-xl text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-slate-900/80 transition-all outline-none"
                                placeholder="••••••••">
                        </div>
                        @error('password') <span class="text-red-400 text-xs mt-1.5 block ml-1 font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <div class="relative flex items-center">
                            <input wire:model="remember" type="checkbox" class="peer sr-only">
                            <div class="w-5 h-5 border-2 border-slate-500 rounded bg-transparent peer-checked:bg-blue-500 peer-checked:border-blue-500 transition-all"></div>
                            <x-lucide-check class="absolute inset-0 w-5 h-5 text-white opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none scale-75 peer-checked:scale-100" />
                        </div>
                        <span class="text-sm text-slate-300 group-hover:text-white transition-colors">Ingat saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full relative overflow-hidden group bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:from-blue-500 hover:to-indigo-500 transition-all active:scale-[0.98] mt-2 border border-white/10">
                    <span class="relative flex items-center justify-center gap-2" wire:loading.remove wire:target="authenticate">
                        Masuk ke Sistem <x-lucide-arrow-right class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                    </span>
                    <span class="relative flex items-center justify-center gap-2" wire:loading wire:target="authenticate">
                        <x-lucide-refresh-cw class="w-5 h-5 animate-spin" /> Memproses...
                    </span>
                </button>
            </form>
        </div>

        <!-- Role Credentials Helper (For Development) -->
        <div class="mt-8 bg-slate-800/30 backdrop-blur-md border border-white/5 rounded-2xl p-5 text-sm text-slate-300 shadow-xl">
            <h3 class="font-bold text-white mb-4 text-center flex items-center justify-center gap-2 text-xs uppercase tracking-widest">
                <x-lucide-info class="w-4 h-4 text-blue-400" /> Panduan Akses Demo
            </h3>
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-slate-900/50 p-3 rounded-xl border border-white/5 hover:border-white/10 transition-colors cursor-default text-center">
                    <span class="block text-[10px] uppercase tracking-wider text-blue-400 mb-1">Siswa</span>
                    <span class="font-mono text-white text-xs font-semibold">subyek</span>
                </div>
                <div class="bg-slate-900/50 p-3 rounded-xl border border-white/5 hover:border-white/10 transition-colors cursor-default text-center">
                    <span class="block text-[10px] uppercase tracking-wider text-blue-400 mb-1">Staf TU</span>
                    <span class="font-mono text-white text-xs font-semibold">petugas</span>
                </div>
                <div class="bg-slate-900/50 p-3 rounded-xl border border-white/5 hover:border-white/10 transition-colors cursor-default text-center">
                    <span class="block text-[10px] uppercase tracking-wider text-blue-400 mb-1">Kepala TU</span>
                    <span class="font-mono text-white text-xs font-semibold">kepala_tu</span>
                </div>
                <div class="bg-slate-900/50 p-3 rounded-xl border border-white/5 hover:border-white/10 transition-colors cursor-default text-center">
                    <span class="block text-[10px] uppercase tracking-wider text-blue-400 mb-1">Kurikulum</span>
                    <span class="font-mono text-white text-xs font-semibold">kurikulum</span>
                </div>
                <div class="bg-slate-900/50 p-3 rounded-xl border border-white/5 hover:border-white/10 transition-colors cursor-default text-center col-span-2">
                    <span class="block text-[10px] uppercase tracking-wider text-blue-400 mb-1">Kepala Sekolah / Admin</span>
                    <span class="font-mono text-white text-xs font-semibold block">kepala_sekolah / admin</span>
                </div>
            </div>
            <p class="text-[11px] text-center mt-4 text-slate-400 font-medium">Semua akun menggunakan password: <strong class="text-white bg-slate-700/50 px-2 py-0.5 rounded ml-1 font-mono">password</strong></p>
        </div>
    </div>
</div>
