<div class="min-h-screen flex w-full bg-white sm:bg-slate-50 font-sans">
    
    <!-- Left Panel: Brand & Welcome (Hidden on Mobile) -->
    <div class="hidden lg:flex lg:w-1/2 bg-blue-700 relative overflow-hidden flex-col justify-between p-12">
        <!-- Abstract Background Pattern -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-20 pointer-events-none">
            <svg class="absolute -top-24 -left-24 w-96 h-96 text-white" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
            <svg class="absolute bottom-[-10%] right-[-5%] w-[40rem] h-[40rem] text-blue-900" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
        </div>

        <div class="relative z-10 flex items-center gap-3">
            <div class="bg-white p-2.5 rounded-xl shadow-lg">
                <x-lucide-school class="h-8 w-8 text-blue-700" />
            </div>
            <span class="text-white font-bold text-xl tracking-wide">SMKN Karanganyar</span>
        </div>

        <div class="relative z-10 mb-10">
            <h1 class="text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-4">
                Sistem Informasi<br>Administrasi TU
            </h1>
            <p class="text-blue-100 text-lg max-w-md">
                Layanan administrasi sekolah terpadu, cepat, dan transparan untuk seluruh warga sekolah.
            </p>
        </div>

        <div class="relative z-10 flex items-center gap-4 text-blue-200 text-sm font-medium">
            <div class="flex items-center gap-1.5"><x-lucide-check-circle class="w-4 h-4" /> <span>Efisien</span></div>
            <div class="flex items-center gap-1.5"><x-lucide-check-circle class="w-4 h-4" /> <span>Real-time</span></div>
            <div class="flex items-center gap-1.5"><x-lucide-check-circle class="w-4 h-4" /> <span>Akurat</span></div>
        </div>
    </div>

    <!-- Right Panel: Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative">
        <!-- Mobile Logo (Hidden on Desktop) -->
        <div class="absolute top-8 left-6 sm:left-12 lg:hidden flex items-center gap-3">
            <div class="bg-blue-600 p-2 rounded-xl shadow-md">
                <x-lucide-school class="h-6 w-6 text-white" />
            </div>
            <span class="text-slate-800 font-bold text-lg">SIM TU</span>
        </div>

        <div class="w-full max-w-md space-y-8 mt-12 lg:mt-0">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900">Selamat Datang 👋</h2>
                <p class="mt-2 text-sm text-slate-500">
                    Silakan masuk ke akun Anda untuk melanjutkan.
                </p>
            </div>

            <form wire:submit="authenticate" class="space-y-6">
                @if (session()->has('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg flex items-start gap-3">
                        <x-lucide-alert-circle class="w-5 h-5 text-red-500 shrink-0 mt-0.5" />
                        <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                @endif

                <div class="space-y-5">
                    <!-- Username Input -->
                    <div>
                        <label for="login" class="block text-sm font-semibold leading-6 text-slate-900 mb-1.5">Username / Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <x-lucide-user class="h-5 w-5" />
                            </div>
                            <input wire:model="login" id="login" type="text" required autofocus
                                class="block w-full pl-11 pr-4 py-3 rounded-xl border-0 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 transition-all"
                                placeholder="Masukkan username">
                        </div>
                        @error('login') <span class="text-red-500 text-xs font-medium mt-1.5 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-semibold leading-6 text-slate-900 mb-1.5">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <x-lucide-lock class="h-5 w-5" />
                            </div>
                            <input wire:model="password" id="password" type="password" required
                                class="block w-full pl-11 pr-4 py-3 rounded-xl border-0 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 transition-all"
                                placeholder="••••••••">
                        </div>
                        @error('password') <span class="text-red-500 text-xs font-medium mt-1.5 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <div class="relative flex items-center">
                            <input wire:model="remember" type="checkbox" class="peer sr-only">
                            <div class="w-5 h-5 border border-slate-300 rounded bg-white peer-checked:bg-blue-600 peer-checked:border-blue-600 transition-all"></div>
                            <x-lucide-check class="absolute inset-0 w-5 h-5 text-white opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none scale-75 peer-checked:scale-100" />
                        </div>
                        <span class="text-sm text-slate-600 font-medium select-none">Ingat saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full flex justify-center items-center gap-2 rounded-xl bg-blue-600 px-4 py-3.5 text-sm font-bold text-white shadow-md hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all active:scale-[0.98]">
                    <span wire:loading.remove wire:target="authenticate" class="flex items-center gap-2">
                        Masuk ke Sistem <x-lucide-arrow-right class="w-4 h-4" />
                    </span>
                    <span wire:loading wire:target="authenticate" class="flex items-center gap-2">
                        <x-lucide-refresh-cw class="w-5 h-5 animate-spin" /> Memproses...
                    </span>
                </button>
            </form>

            <!-- Role Credentials Helper (For Development) -->
            <div class="mt-10 bg-blue-50/50 rounded-2xl p-5 border border-blue-100">
                <h3 class="font-bold text-blue-900 mb-3 text-xs uppercase tracking-wider flex items-center gap-2">
                    <x-lucide-info class="w-4 h-4 text-blue-600" /> Info Akun Demo
                </h3>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div class="bg-white p-2.5 rounded-lg border border-blue-50 shadow-sm">
                        <span class="block text-[10px] uppercase text-slate-400 mb-0.5">Siswa</span>
                        <span class="font-bold text-slate-700">subyek</span>
                    </div>
                    <div class="bg-white p-2.5 rounded-lg border border-blue-50 shadow-sm">
                        <span class="block text-[10px] uppercase text-slate-400 mb-0.5">Staf TU</span>
                        <span class="font-bold text-slate-700">petugas</span>
                    </div>
                    <div class="bg-white p-2.5 rounded-lg border border-blue-50 shadow-sm">
                        <span class="block text-[10px] uppercase text-slate-400 mb-0.5">Ka. TU</span>
                        <span class="font-bold text-slate-700">kepala_tu</span>
                    </div>
                    <div class="bg-white p-2.5 rounded-lg border border-blue-50 shadow-sm">
                        <span class="block text-[10px] uppercase text-slate-400 mb-0.5">Kurikulum</span>
                        <span class="font-bold text-slate-700">kurikulum</span>
                    </div>
                    <div class="bg-white p-2.5 rounded-lg border border-blue-50 shadow-sm col-span-2 text-center">
                        <span class="block text-[10px] uppercase text-slate-400 mb-0.5">Kepala Sekolah / Admin</span>
                        <span class="font-bold text-slate-700">kepala_sekolah / admin</span>
                    </div>
                </div>
                <p class="text-[11px] text-center mt-4 text-slate-500">Password: <strong class="text-slate-800 bg-white px-1.5 py-0.5 rounded border border-slate-200">password</strong></p>
            </div>
            
            <!-- Footer -->
            <p class="text-center text-xs text-slate-400 mt-8">
                &copy; {{ date('Y') }} SMK Negeri Karanganyar. All rights reserved.
            </p>
        </div>
    </div>
</div>
