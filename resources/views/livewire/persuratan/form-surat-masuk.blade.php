<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('persuratan.masuk') }}" wire:navigate.hover class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition">
                <x-lucide-arrow-left class="w-5 h-5" />
            </a>
            <div>
                <h2 class="text-lg font-bold text-slate-900">Registrasi Surat Masuk</h2>
                <p class="text-xs text-slate-500">Tata Usaha SMK Negeri Karanganyar</p>
            </div>
        </div>
        <div class="text-right hidden sm:block">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                <x-lucide-hash class="w-3.5 h-3.5" /> Agenda: {{ $nomor_agenda }}
            </span>
        </div>
    </div>

    <form wire:submit="simpanSurat" class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-7 shadow-sm space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Agenda TU</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <x-lucide-hash class="w-4 h-4" />
                    </span>
                    <input type="text" wire:model="nomor_agenda" readonly class="w-full bg-slate-50 text-slate-600 pl-9 pr-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none cursor-not-allowed">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori Surat <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <x-lucide-tag class="w-4 h-4" />
                    </span>
                    <select wire:model="kategori" class="w-full pl-9 pr-3 py-2 text-xs border border-slate-200 rounded-xl focus:ring-1 focus:ring-blue-600 focus:border-blue-600 bg-white">
                        <option value="Dinas">Surat Dinas / Pemerintah</option>
                        <option value="Undangan">Undangan Rapat / Acara</option>
                        <option value="Pemberitahuan">Surat Pemberitahuan</option>
                        <option value="Permohonan">Permohonan Izin / PKL</option>
                        <option value="Lainnya">Lain-lain</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Surat Asli <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <x-lucide-file-text class="w-4 h-4" />
                    </span>
                    <input type="text" wire:model="nomor_surat" placeholder="Contoh: 421.5/123/DISDIK/2026" class="w-full pl-9 pr-3 py-2 text-xs border border-slate-200 rounded-xl focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                </div>
                @error('nomor_surat') <span class="text-red-500 text-[11px]">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Derajat Urgensi</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <x-lucide-alert-circle class="w-4 h-4" />
                    </span>
                    <select wire:model="derajat" class="w-full pl-9 pr-3 py-2 text-xs border border-slate-200 rounded-xl focus:ring-1 focus:ring-blue-600 focus:border-blue-600 bg-white">
                        <option value="Biasa">Biasa</option>
                        <option value="Penting">Penting</option>
                        <option value="Segera">Segera / Mendesak</option>
                        <option value="Rahasia">Rahasia</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Surat <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <x-lucide-calendar class="w-4 h-4" />
                    </span>
                    <input type="date" wire:model="tanggal_surat" class="w-full pl-9 pr-3 py-2 text-xs border border-slate-200 rounded-xl focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Diterima TU <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <x-lucide-clock class="w-4 h-4" />
                    </span>
                    <input type="date" wire:model="tanggal_terima" class="w-full pl-9 pr-3 py-2 text-xs border border-slate-200 rounded-xl focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                </div>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1">Pengirim / Instansi Asal <span class="text-red-500">*</span></label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <x-lucide-building class="w-4 h-4" />
                </span>
                <input type="text" wire:model="pengirim" placeholder="Contoh: Balai Besar Pengembangan Penjaminan Mutu Pendidikan Vokasi" class="w-full pl-9 pr-3 py-2 text-xs border border-slate-200 rounded-xl focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
            </div>
            @error('pengirim') <span class="text-red-500 text-[11px]">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1">Perihal / Isi Ringkas <span class="text-red-500">*</span></label>
            <textarea rows="3" wire:model="perihal" placeholder="Jelaskan ringkasan surat secara singkat..." class="w-full p-3 text-xs border border-slate-200 rounded-xl focus:ring-1 focus:ring-blue-600 focus:border-blue-600"></textarea>
            @error('perihal') <span class="text-red-500 text-[11px]">{{ $message }}</span> @enderror
        </div>

        <!-- Bagian Scan Kamera & Berkas -->
        <div class="border-t border-slate-100 pt-5" x-data="scannerModal()">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2 flex items-center gap-2">
                <x-lucide-camera class="w-4 h-4 text-blue-600" />
                Lampiran Berkas / Scan Fisik Surat
            </label>

            @if($file_dokumen || $scanned_image_base64)
                <div class="p-4 bg-blue-50/60 border border-blue-200 rounded-xl flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-blue-600 text-white rounded-lg">
                            <x-lucide-file-check class="w-5 h-5" />
                        </div>
                        <div>
                            @if($file_dokumen)
                                <p class="text-xs font-semibold text-slate-800">{{ $file_dokumen->getClientOriginalName() }}</p>
                                <p class="text-[10px] text-slate-500">{{ round($file_dokumen->getSize() / 1024, 1) }} KB</p>
                            @elseif($scanned_image_base64)
                                <p class="text-xs font-semibold text-slate-800">Scan Kamera Berhasil Diambil</p>
                                <p class="text-[10px] text-emerald-600 font-medium">Siap diarsipkan ke server</p>
                            @endif
                        </div>
                    </div>
                    <button type="button" wire:click="hapusFile" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus Berkas">
                        <x-lucide-trash-2 class="w-4 h-4" />
                    </button>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="flex flex-col items-center justify-center p-5 border-2 border-dashed border-slate-200 hover:border-blue-500 bg-slate-50/50 hover:bg-blue-50/30 rounded-xl cursor-pointer transition text-center group">
                        <div class="p-2.5 rounded-full bg-blue-100 text-blue-600 group-hover:scale-110 transition">
                            <x-lucide-camera class="w-5 h-5" />
                        </div>
                        <span class="mt-2 text-xs font-semibold text-slate-700">Foto Kamera Belakang</span>
                        <span class="text-[10px] text-slate-400">Langsung di HP Petugas TU</span>
                        <input type="file" wire:model="file_dokumen" accept="image/*" capture="environment" class="hidden">
                    </label>

                    <button type="button" @click="openScanner()" class="flex flex-col items-center justify-center p-5 border-2 border-dashed border-slate-200 hover:border-indigo-500 bg-slate-50/50 hover:bg-indigo-50/30 rounded-xl transition text-center group">
                        <div class="p-2.5 rounded-full bg-indigo-100 text-indigo-600 group-hover:scale-110 transition">
                            <x-lucide-scan-line class="w-5 h-5" />
                        </div>
                        <span class="mt-2 text-xs font-semibold text-slate-700">Buka Live Scanner</span>
                        <span class="text-[10px] text-slate-400">Webcam laptop / scanner PC</span>
                    </button>
                </div>

                <div class="mt-3 text-center">
                    <label class="inline-flex items-center gap-1.5 text-xs text-blue-600 hover:underline cursor-pointer">
                        <x-lucide-upload class="w-3.5 h-3.5" />
                        <span>Pilih file PDF atau foto dari penyimpanan</span>
                        <input type="file" wire:model="file_dokumen" accept=".pdf,image/*" class="hidden">
                    </label>
                </div>
            @endif

            <div wire:loading wire:target="file_dokumen" class="mt-2 text-xs text-blue-600 flex items-center gap-2">
                <x-lucide-loader-2 class="w-4 h-4 animate-spin" /> Memproses dokumen...
            </div>

            <!-- Modal Webcam Scanner -->
            <div x-show="showScanner" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm p-4">
                <div class="bg-white rounded-2xl max-w-md w-full overflow-hidden shadow-2xl flex flex-col">
                    <div class="flex items-center justify-between p-4 border-b border-slate-100">
                        <div class="flex items-center gap-2 font-bold text-sm text-slate-800">
                            <x-lucide-camera class="w-4 h-4 text-blue-600" />
                            <span>Scan Dokumen Fisik</span>
                        </div>
                        <button type="button" @click="closeScanner()" class="text-slate-400 hover:text-slate-600">
                            <x-lucide-x class="w-5 h-5" />
                        </button>
                    </div>

                    <div class="relative bg-black aspect-4/3 flex items-center justify-center overflow-hidden">
                        <video x-ref="videoElement" autoplay playsinline class="w-full h-full object-cover"></video>
                        <canvas x-ref="canvasElement" class="hidden"></canvas>
                        
                        <div class="absolute inset-6 border-2 border-dashed border-white/50 rounded-lg pointer-events-none flex items-center justify-center">
                            <span class="text-white/75 text-[11px] bg-black/40 px-2.5 py-1 rounded">Sejajarkan lembar surat</span>
                        </div>
                    </div>

                    <div class="p-4 bg-slate-50 flex items-center justify-between">
                        <button type="button" @click="closeScanner()" class="px-4 py-2 text-xs text-slate-600 hover:bg-slate-200 rounded-lg">
                            Batal
                        </button>
                        <button type="button" @click="capturePhoto()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-xl shadow-md transition active:scale-95">
                            <x-lucide-aperture class="w-4 h-4" />
                            <span>Jepret Foto</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
            <a href="{{ route('persuratan.masuk') }}" wire:navigate.hover class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                Batal
            </a>
            <button type="submit" wire:loading.attr="disabled" class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-700 hover:bg-blue-800 disabled:opacity-50 text-white text-xs font-semibold rounded-xl shadow transition active:scale-95">
                <x-lucide-save class="w-4 h-4" />
                <span wire:loading.remove wire:target="simpanSurat">Simpan ke Arsip</span>
                <span wire:loading wire:target="simpanSurat">Menyimpan...</span>
            </button>
        </div>
    </form>
</div>

<script>
    function scannerModal() {
        return {
            showScanner: false,
            stream: null,

            async openScanner() {
                this.showScanner = true;
                try {
                    this.stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: { ideal: "environment" }, width: { ideal: 1920 }, height: { ideal: 1080 } },
                        audio: false
                    });
                    this.$refs.videoElement.srcObject = this.stream;
                } catch (err) {
                    alert('Tidak dapat mengaktifkan kamera: ' + err.message);
                    this.closeScanner();
                }
            },

            closeScanner() {
                if (this.stream) {
                    this.stream.getTracks().forEach(track => track.stop());
                    this.stream = null;
                }
                this.showScanner = false;
            },

            capturePhoto() {
                const video = this.$refs.videoElement;
                const canvas = this.$refs.canvasElement;
                canvas.width = video.videoWidth || 1280;
                canvas.height = video.videoHeight || 720;
                
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                
                const base64Image = canvas.toDataURL('image/jpeg', 0.85);
                @this.call('handleScannedImage', base64Image);
                this.closeScanner();
            }
        }
    }
</script>
