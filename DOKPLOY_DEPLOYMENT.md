# 🚀 Panduan Deployment Dokploy: SIM TU SMKN Karanganyar

Panduan ini mendokumentasikan langkah demi langkah untuk melakukan deployment aplikasi **Sistem Informasi Tata Usaha SMKN Karanganyar** pada platform **Dokploy** (Docker PaaS) dengan arsitektur **Dual-Network Anti-Konflik IP**.

---

## 🛡️ Arsitektur & Keunggulan Dual-Network

```
                      [ Internet / Browser ]
                                |
                   [ Cloudflare CDN & SSL / Tunnel ]
                                |
                      [ VPS Host: Dokploy ]
                                |
                     [ Traefik Reverse Proxy ]
                                |
                   (dokploy-network: port 80)
                                |
                    +-----------------------+
                    |      tu_smkn_app      |
                    | (PHP 8.2 Apache + TU) |
                    +-----------------------+
                                |
               (tu_smkn_internal_network - PRIVAT)
                                |
                    +-----------------------+
                    |      db_tu_smkn       |
                    | (MariaDB 10.11 LTS)   |
                    +-----------------------+
```

### Mengapa Arsitektur Ini 100% Bebas Konflik DNS/IP di Dokploy?
Pada server Dokploy dengan banyak project, jika beberapa container sama-sama menggunakan service `db` di `dokploy-network`, DNS internal Docker akan melakukan *round-robin* sehingga aplikasi bisa salah menyambung ke database project lain.

Arsitektur ini mengatasi masalah tersebut secara total:
1. **Network Privat (`tu_internal_net`)**: Service database **HANYA** berada di network privat internal ini. Database tidak pernah diekspos ke `dokploy-network`.
2. **Hostname Unik (`db_tu_smkn`)**: Hostname database diberi nama spesifik `db_tu_smkn` (bukan sekadar `db`), menjamin DNS resolver tidak akan pernah tertukar dengan database project mana pun di server Anda.
3. **Multi-Stage Asset Build**: Vite & Tailwind CSS di-compile secara otomatis pada stage Node.js 20, menghasilkan direktori `/public/build` yang siap saji tanpa perlu kompilasi manual di server.
4. **Auto-Link & Permisi**: Skrip entrypoint otomatis menjalankan `php artisan storage:link`, migrasi database aman, pembuatan `APP_KEY`, dan caching produksi.

---

## 📋 Langkah-Langkah Deployment di Dashboard Dokploy

### Langkah 1: Buat Project & Service di Dokploy
1. Buka dashboard Dokploy Anda.
2. Masuk ke menu **Projects** > Pilih atau buat project baru (misal: `SMKN Karanganyar`).
3. Klik tombol **Create Service** dan pilih tipe **Compose**.
4. Beri nama service, misalnya: `tu-administrasi`.

---

### Langkah 2: Hubungkan Repositori atau Paste Compose
Pada tab **General** di service Compose Dokploy:
- **Opsi A (Git Repository - Direkomendasikan)**:
  - Hubungkan ke repository Git proyek ini (GitHub/GitLab).
  - Branch: `main` (atau branch deployment Anda).
  - Compose Path: `docker-compose.yml`.
- **Opsi B (Raw Compose)**:
  - Salin isi dari berkas [docker-compose.yml](file:///c:/xampp/htdocs/tu-smkn-karanganyar/docker-compose.yml) langsung ke editor Compose Dokploy.

---

### Langkah 3: Konfigurasi Environment Variables
Buka tab **Environment** pada service di Dokploy, lalu salin dan sesuaikan isi dari file [.env.docker.example](file:///c:/xampp/htdocs/tu-smkn-karanganyar/.env.docker.example):

```env
APP_NAME="SIM TU SMKN Karanganyar"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu.smkn-karanganyar.sch.id
APP_KEY=base64:3f0UvDNDuH8ZJ1o22FepB12F0U4Q3wA5X7yB9zC1dE8=
APP_TIMEZONE=Asia/Jakarta
APP_LOCALE=id
APP_FALLBACK_LOCALE=id

# Kredensial Database (Aman terisolasi ke service db_tu_smkn)
DB_CONNECTION=mysql
DB_HOST=db_tu_smkn
DB_PORT=3306
DB_DATABASE=tu_smkn_karanganyar
DB_USERNAME=tu_user
DB_PASSWORD=GantiPasswordDatabaseKuat123!
DB_ROOT_PASSWORD=GantiPasswordRootKuat123!

# Session, Cache & Filesystem
SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_STORE=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=public
```

> **Tips Generate APP_KEY**: Jika Anda ingin membuat kunci aplikasi baru, Anda bisa mengosongkan `APP_KEY` dan entrypoint container akan otomatis membuatnya saat pertama kali dijalankan.

---

### Langkah 4: Atur Domain & Routing Traefik Dokploy
1. Buka tab **Domains** di service Dokploy.
2. Klik **Add Domain**:
   - **Domain**: `tu.smkn-karanganyar.sch.id`
   - **Service**: Pilih service **`app`** (bukan database).
   - **Container Port**: `80`
   - **HTTPS**: Aktifkan Let's Encrypt / Certificate Manager Dokploy (jika menggunakan direct VPS) atau gunakan Cloudflare SSL.
3. Simpan konfigurasi domain.

---

### Langkah 5: Klik Deploy!
1. Klik tombol **Deploy** di pojok kanan atas dashboard Dokploy.
2. Dokploy akan otomatis:
   - Menjalankan build Docker multi-stage (compile Vite frontend -> build PHP 8.2 Apache).
   - Menjalankan MariaDB 10.11 di network privat `tu_smkn_internal_network`.
   - Menunggu database siap, lalu otomatis menjalankan migrasi dan `storage:link`.
   - Menghubungkan Traefik Dokploy ke port 80 service `app`.

---

## 🌐 Integrasi dengan Cloudflare

### Opsi 1: Cloudflare DNS Proxy (Paling Umum di Dokploy)
1. Di dashboard Cloudflare DNS:
   - Buat **A Record**: `tu` diarahkan ke **IP Publik VPS Dokploy**.
   - Pastikan status proxy aktif (**Awan Oranye / Proxied**).
2. Di menu **SSL/TLS** Cloudflare:
   - Pilih mode **Full** atau **Full (Strict)** (karena Traefik Dokploy sudah menyediakan sertifikat SSL).
3. Apache pada container sudah dilengkapi konfigurasi `SetEnvIf X-Forwarded-Proto "https" HTTPS=on` dan Laravel `trustProxies(at: '*')`, sehingga URL asset CSS/JS Livewire akan otomatis berskema `https://` tanpa error *Mixed Content*.

### Opsi 2: Cloudflare Tunnel (Zero Port Forwarding)
Jika VPS Dokploy berada di belakang NAT / Mikrotik sekolah tanpa IP publik:
1. Di Cloudflare Zero Trust > Tunnels > Public Hostname:
   - Service Type: `HTTP`
   - URL: `app:80` (jika tunnel berada di network dokploy) atau `localhost:80` (jika diarahkan ke Traefik).

---

## 🛠️ Perintah Operasional & Troubleshooting

Untuk menjalankan perintah artisan atau database di Dokploy:

### 1. Masuk ke Terminal Container Aplikasi
Di tab **Terminal** Dokploy atau via SSH VPS:
```bash
docker exec -it tu_smkn_app bash
```

### 2. Menjalankan Artisan Manual
```bash
# Menjalankan migrasi manual jika ada skrip baru
docker exec -it tu_smkn_app php artisan migrate --force

# Membersihkan dan me-refresh cache optimasi
docker exec -it tu_smkn_app php artisan optimize:clear
docker exec -it tu_smkn_app php artisan optimize
```

### 3. Backup Database MariaDB
```bash
docker exec tu_smkn_db mysqldump -u tu_user -pPasswordDatabaseTu123! tu_smkn_karanganyar > backup_tu_$(date +%F).sql
```

### 4. Restore Database MariaDB
```bash
docker exec -i tu_smkn_db mysql -u tu_user -pPasswordDatabaseTu123! tu_smkn_karanganyar < backup_tu.sql
```
