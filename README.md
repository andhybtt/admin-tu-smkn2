# Sistem Administrasi Tata Usaha SMKN Karanganyar

Aplikasi Web Administrasi Tata Usaha SMK Negeri Karanganyar modern dengan arsitektur **TALL Stack (Tailwind CSS, Alpine.js, Laravel 11, Livewire 3)**, **PWA (Progressive Web App)**, **Livewire SPA Mode (`wire:navigate`)**, dan **Blade Lucide Icons**.

## Fitur Utama
1. **Livewire SPA Mode**: Navigasi antar modul TU (Surat Masuk, Surat Keluar, Buku Induk, Legalisir, Kepegawaian) tanpa reload halaman browser.
2. **Mobile Friendly & PWA Ready**:
   - Web App Manifest & Service Worker untuk offline caching dan instalasi di Android/iOS/Desktop.
   - Mobile Floating Bottom Navigation Bar untuk kemudahan navigasi jempol di layar ponsel.
3. **Kamera & Scan Dokumen Fisik**:
   - `capture="environment"` untuk langsung mengaktifkan kamera belakang HP staf TU.
   - Mode Live Webcam Scanner terintegrasi (Alpine.js + Canvas) untuk laptop/PC administrasi sekolah.
4. **Blade Lucide Icons**:
   - Komponen icon SVG native `<x-lucide-... />` yang ringan tanpa overhead JavaScript pihak ketiga.

## Langkah Instalasi

1. **Ekstrak file ZIP project ke direktori web server Anda.**
2. **Jalankan composer install:**
   ```bash
   composer install
   ```
3. **Salin konfigurasi environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. **Install & build asset frontend:**
   ```bash
   npm install
   npm run build
   ```
5. **Jalankan local server:**
   ```bash
   php artisan serve
   ```
6. Buka di browser: `http://localhost:8000`

---

## 🐳 Deployment dengan Docker & Cloudflare

Proyek ini telah dilengkapi dengan kontainerisasi Docker teroptimasi (Multi-stage build, Nginx, PHP 8.2 FPM, Supervisor, MariaDB, dan Cloudflare Tunnel):

1. **Salin konfigurasi environment:**
   ```bash
   cp .env.docker.example .env
   ```
2. **Jalankan via Docker Compose:**
   ```bash
   # Mode Standar (Direct VPS / Port 8080):
   docker compose up -d --build

   # ATAU Mode Cloudflare Tunnel (Zero Port Forwarding):
   docker compose --profile tunnel up -d --build
   ```

📖 **Panduan Lengkap:** Silakan baca panduan lengkap pada [DEPLOYMENT_CLOUDFLARE.md](DEPLOYMENT_CLOUDFLARE.md).
