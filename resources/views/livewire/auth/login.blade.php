<div class="h-screen flex w-full bg-white font-sans overflow-hidden">
    
    <!-- Left Panel: Brand & Welcome (Hidden on Mobile) -->
    <div class="hidden lg:flex lg:w-1/2 bg-blue-700 relative overflow-hidden flex-col justify-between p-10 xl:p-16">
        <!-- Abstract Background Pattern -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-20 pointer-events-none">
            <svg class="absolute -top-24 -left-24 w-96 h-96 text-white" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
            <svg class="absolute bottom-[-10%] right-[-5%] w-[40rem] h-[40rem] text-blue-900" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"></circle></svg>
        </div>

        <div class="relative z-10 flex items-center gap-3">
            <div class="bg-white p-2 rounded-xl shadow-lg">
                <x-lucide-school class="h-6 w-6 text-blue-700" />
            </div>
            <span class="text-white font-bold text-lg tracking-wide">SMKN Karanganyar</span>
        </div>

        <div class="relative z-10">
            <h1 class="text-4xl xl:text-5xl font-extrabold text-white leading-tight mb-3">
                Sistem Informasi<br>Administrasi TU
            </h1>
            <p class="text-blue-100 text-base max-w-sm">
                Layanan administrasi sekolah terpadu, cepat, dan transparan untuk seluruh warga sekolah.
            </p>
        </div>

        <div class="relative z-10 flex items-center gap-4 text-blue-200 text-xs font-medium">
            <div class="flex items-center gap-1.5"><x-lucide-check-circle class="w-3.5 h-3.5" /> <span>Efisien</span></div>
            <div class="flex items-center gap-1.5"><x-lucide-check-circle class="w-3.5 h-3.5" /> <span>Real-time</span></div>
            <div class="flex items-center gap-1.5"><x-lucide-check-circle class="w-3.5 h-3.5" /> <span>Akurat</span></div>
        </div>
    </div>

    <!-- Right Panel: Login Form -->
    <div class="w-full lg:w-1/2 h-full flex flex-col justify-center items-center p-6 relative overflow-y-auto lg:overflow-hidden">
        <!-- Mobile Logo -->
        <div class="absolute top-6 left-6 lg:hidden flex items-center gap-2">
            <div class="bg-blue-600 p-1.5 rounded-lg shadow-md">
                <x-lucide-school class="h-5 w-5 text-white" />
            </div>
            <span class="text-slate-800 font-bold text-base">SIM TU</span>
        </div>

        <div class="w-full max-w-sm space-y-6">
            <div class="text-center lg:text-left">
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Selamat Datang 👋</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Silakan masuk ke akun Anda.
                </p>
            </div>

            <form wire:submit="authenticate" class="space-y-4">
                @if (session()->has('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-3 flex items-start gap-2">
                        <x-lucide-alert-circle class="w-4 h-4 text-red-500 shrink-0 mt-0.5" />
                        <p class="text-xs text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                @endif

                <div class="space-y-3.5">
                    <!-- Username Input -->
                    <div>
                        <label for="login" class="block text-xs font-semibold leading-6 text-slate-900 mb-1">Username / Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <x-lucide-user class="h-4 w-4" />
                            </div>
                            <input wire:model="login" id="login" type="text" required autofocus
                                class="block w-full pl-9 pr-3 py-2.5 rounded-lg border-0 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 transition-all"
                                placeholder="Masukkan username">
                        </div>
                        @error('login') <span class="text-red-500 text-[11px] font-medium mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-xs font-semibold leading-6 text-slate-900 mb-1">Kata Sandi</label>
                        <div class="relative" x-data="{ show: false }">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <x-lucide-lock class="h-4 w-4" />
                            </div>
                            <input wire:model="password" id="password" x-bind:type="show ? 'text' : 'password'" type="password" required
                                class="block w-full pl-9 pr-10 py-2.5 rounded-lg border-0 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 transition-all"
                                placeholder="••••••••">
                            <button type="button" x-on:click="show = !show"
                                x-bind:aria-label="show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                                x-bind:title="show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-blue-600 focus:outline-none focus-visible:text-blue-600 transition-colors">
                                <x-lucide-eye x-show="!show" class="h-4 w-4" />
                                <x-lucide-eye-off x-show="show" x-cloak class="h-4 w-4" />
                            </button>
                        </div>
                        @error('password') <span class="text-red-500 text-[11px] font-medium mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Remember Me & Submit -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <div class="relative flex items-center">
                            <input wire:model="remember" type="checkbox" class="peer sr-only">
                            <div class="w-4 h-4 border border-slate-300 rounded bg-white peer-checked:bg-blue-600 peer-checked:border-blue-600 transition-all"></div>
                            <x-lucide-check class="absolute inset-0 w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none scale-75 peer-checked:scale-100" />
                        </div>
                        <span class="text-xs text-slate-600 font-medium select-none">Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full flex justify-center items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all active:scale-[0.98]">
                    <span wire:loading.remove wire:target="authenticate" class="flex items-center gap-2">
                        Masuk ke Sistem <x-lucide-arrow-right class="w-4 h-4" />
                    </span>
                    <span wire:loading wire:target="authenticate" class="flex items-center gap-2">
                        <x-lucide-refresh-cw class="w-4 h-4 animate-spin" /> Memproses...
                    </span>
                </button>
            </form>

            
            <!-- Footer -->
            <p class="text-center text-[10px] text-slate-400">
                &copy; {{ date('Y') }} SMK Negeri Karanganyar
            </p>
        </div>
    </div>
</div>
