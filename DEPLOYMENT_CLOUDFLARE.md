# 🚀 Panduan Deployment Docker & Cloudflare: TU SMKN Karanganyar

Dokumen ini berisi panduan lengkap untuk melakukan deployment aplikasi **Sistem Administrasi Tata Usaha SMKN Karanganyar** menggunakan **Docker Compose** dan dihubungkan ke jaringan **Cloudflare**.

---

## 📋 Daftar Isi
1. [Arsitektur & Keunggulan](#1-arsitektur--keunggulan)
2. [Prasyarat Server](#2-prasyarat-server)
3. [Metode 1: Cloudflare Tunnel (Paling Direkomendasikan)](#3-metode-1-cloudflare-tunnel-paling-direkomendasikan)
4. [Metode 2: Direct VPS + Cloudflare DNS Proxy](#4-metode-2-direct-vps--cloudflare-dns-proxy)
5. [Manajemen & Perintah Operasional](#5-manajemen--perintah-operasional)
6. [Backup & Restore Database](#6-backup--restore-database)
7. [Tips Optimasi & Troubleshooting Livewire](#7-tips-optimasi--troubleshooting-livewire)

---

## 1. Arsitektur & Keunggulan

Konfigurasi ini dirancang menggunakan standar *Production-Grade*:

- **Multi-Stage Dockerfile**: Kompilasi asset Vite (Tailwind CSS & JavaScript) dilakukan di container terpisah (Node 20), lalu hasil build disalin ke runtime PHP 8.2 FPM + Nginx berbasis Alpine Linux yang sangat ringan (< 150MB).
- **Auto-Restorasi Real IP Cloudflare**: Nginx dan Laravel telah dikonfigurasi dengan blok IP resmi Cloudflare dan header `CF-Connecting-IP`, sehingga IP staf/pengunjung asli tercatat di log audit keamanan.
- **Dukungan Scan & Upload Fisik**: Nginx, PHP, dan Livewire disetel mendukung upload dokumen hingga **50 MB**.
- **Persistent Volume**: Berkas arsip digital TU di `/storage/app/public` dan data MariaDB tersimpan aman di Docker Volume independen (`tu_smkn_app_storage` dan `tu_smkn_db_data`).

---

## 2. Prasyarat Server

Di server produksi (VPS Ubuntu/Debian, AlmaLinux, atau Mini PC / Server Sekolah), pastikan telah terinstall:
- **Docker Engine** (versi 24.0+)
- **Docker Compose** (versi 2.20+)
- Akun Cloudflare aktif dengan domain sekolah (misal: `smkn-karanganyar.sch.id`).

---

## 3. Metode 1: Cloudflare Tunnel (Paling Direkomendasikan)

> **Kenapa Cloudflare Tunnel?**
> - **Zero Port Forwarding**: Server tidak perlu IP publik statis dan tidak perlu membuka port `80` atau `443` di firewall/mikrotik sekolah.
> - **Otomatis HTTPS / SSL**: Sertifikat SSL dikelola penuh oleh Cloudflare secara gratis dan selalu auto-renew.
> - **Anti-DDoS & WAF**: Lalu lintas serangan diblokir di edge network Cloudflare sebelum mencapai server Anda.

### Langkah-langkah Setup:

#### Langkah 1: Buat Tunnel di Cloudflare Zero Trust
1. Buka dashboard Cloudflare: [https://one.dash.cloudflare.com](https://one.dash.cloudflare.com)
2. Masuk ke menu **Networks** > **Tunnels**.
3. Klik tombol **Add a tunnel**, pilih opsi **Cloudflare (cloudflared)**, lalu klik **Next**.
4. Beri nama tunnel, misalnya: `tu-smkn-karanganyar`. Klik **Save tunnel**.
5. Pada bagian *Install and run a connector*, pilih tab **Docker**.
6. Anda akan melihat perintah yang berisi token panjang setelah parameter `--token`, contohnya:
   ```text
   eyJhIjoiYmNkZWY...xyz123
   ```
   *Salin token tersebut.*

#### Langkah 2: Konfigurasi Public Hostname di Dashboard Cloudflare
1. Pada halaman konfigurasi tunnel yang sama, buka tab **Public Hostname**.
2. Klik **Add a public hostname**:
   - **Subdomain**: `tu` (atau `administrasi`)
   - **Domain**: `smkn-karanganyar.sch.id`
   - **Service Type**: `HTTP`
   - **URL**: `app:80`  *(Catatan: gunakan nama service `app:80`, bukan localhost)*
3. Klik **Save hostname**.

#### Langkah 3: Konfigurasi File `.env` di Server
1. Clone / upload source code proyek ini ke server Anda:
   ```bash
   cd /var/www/tu-smkn-karanganyar
   ```
2. Salin template `.env.docker.example` menjadi `.env`:
   ```bash
   cp .env.docker.example .env
   ```
3. Edit file `.env`:
   ```bash
   nano .env
   ```
   Sesuaikan isian penting berikut:
   ```ini
   APP_URL=https://tu.smkn-karanganyar.sch.id
   FORCE_HTTPS=true
   DB_PASSWORD=GantiDenganPasswordDatabaseRahasia123!
   DB_ROOT_PASSWORD=GantiDenganPasswordRootRahasia123!

   # Tempelkan token yang Anda salin pada Langkah 1 di sini:
   CLOUDFLARE_TUNNEL_TOKEN=eyJhIjoiYmNkZWY...xyz123
   ```

#### Langkah 4: Jalankan Container dengan Profil Tunnel
Jalankan perintah berikut:
```bash
docker compose --profile tunnel up -d --build
```

Aplikasi TU SMKN Karanganyar Anda sekarang langsung aktif secara aman di `https://tu.smkn-karanganyar.sch.id`!

---

## 4. Metode 2: Direct VPS + Cloudflare DNS Proxy

Jika Anda memiliki VPS dengan IP Publik statis dan menggunakan DNS Cloudflare biasa (Awan Oranye):

### Langkah-langkah:
1. Di DNS Management Cloudflare:
   - Buat **A Record**: `tu` mengarah ke IP Publik VPS Anda.
   - Pastikan status **Proxy Status** aktif (**Proxied / Awan Oranye**).
2. Di menu **SSL/TLS** Cloudflare:
   - Jika Nginx container di-map ke port 80 HTTP, pilih mode **Flexible** (Browser ke Cloudflare HTTPS, Cloudflare ke VPS HTTP).
   - Atau gunakan reverse proxy induk VPS (Caddy/Traefik/Nginx host) dengan mode **Full (Strict)**.
3. Di file `.env` server:
   ```ini
   APP_PORT=8080   # Port yang akan dibuka di VPS
   APP_URL=https://tu.smkn-karanganyar.sch.id
   FORCE_HTTPS=true
   ```
4. Jalankan container:
   ```bash
   docker compose up -d --build
   ```

---

## 5. Manajemen & Perintah Operasional

Berikut rangkuman perintah yang sering digunakan untuk pemeliharaan server:

### Memeriksa Status Container
```bash
docker compose ps
```

### Melihat Log Real-Time Aplikasi
```bash
# Log aplikasi web dan Nginx
docker compose logs -f app

# Log Cloudflare Tunnel
docker compose logs -f cloudflared

# Log Database
docker compose logs -f db
```

### Menjalankan Perintah Artisan
```bash
# Masuk ke container app
docker compose exec app sh

# Menjalankan migrasi manual
docker compose exec app php artisan migrate

# Membersihkan cache aplikasi
docker compose exec app php artisan optimize:clear
docker compose exec app php artisan optimize
```

### Restart atau Update Versi Baru
```bash
# Tarik perubahan kode terbaru dari Git
git pull origin main

# Rebuild dan jalankan ulang container
docker compose up -d --build
```

---

## 6. Backup & Restore Database

Data database MariaDB tersimpan di volume `tu_smkn_db_data`. Untuk membuat backup berkala:

### Backup (Dump SQL)
```bash
docker compose exec db mysqldump -u tu_user -p tu_smkn_karanganyar > backup_tu_$(date +%F).sql
```
*(Masukkan password database saat diminta)*

### Restore
```bash
docker compose exec -T db mysql -u tu_user -p tu_smkn_karanganyar < backup_tu_2026-09-21.sql
```

---

## 7. Tips Optimasi & Troubleshooting Livewire

### 1. Livewire SPA & Mixed Content
Jika aset atau permintaan AJAX Livewire dicegah karena pesan "Mixed Content" (HTTP vs HTTPS), pastikan:
- Variabel `.env` memiliki `FORCE_HTTPS=true` dan `APP_URL=https://...`
- Berkas `AppServiceProvider.php` yang disertakan dalam repositori ini sudah otomatis memaksakan skema HTTPS saat mendeteksi header dari Cloudflare.

### 2. Header Real IP Pengunjung
Semua IP pengunjung asli diteruskan oleh Cloudflare melalui header `CF-Connecting-IP`.
Berkas `docker/nginx/cloudflare.conf` dan `bootstrap/app.php` (`$middleware->trustProxies(at: '*');`) sudah mengonfigurasi Laravel agar `request()->ip()` menghasilkan alamat IP asli pengguna, bukan IP server Cloudflare.

### 3. Batas Ukuran Upload
Cloudflare Free Plan memiliki batas maksimal 100 MB per HTTP POST request.
Nginx dan PHP di container ini telah disetel pada batas aman **50 MB** (`client_max_body_size 50M;` dan `upload_max_filesize = 50M;`), sangat memadai untuk file PDF surat dinas dan foto kamera scan dokumen beresolusi tinggi.
