#!/bin/bash
set -e

echo "=================================================="
echo "🚀 Memulai SIM TU SMKN Karanganyar (Dokploy / Docker)"
echo "=================================================="

cd /var/www/html

# 1. Pastikan direktori storage dan cache dibuat dan berizin 775
mkdir -p storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/logs \
         storage/app/public \
         bootstrap/cache

touch storage/logs/laravel.log

chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 2. Buat symlink storage jika belum ada (agar arsip file dapat diakses)
if [ ! -L /var/www/html/public/storage ]; then
    echo "🔗 Menghubungkan storage publik (php artisan storage:link)..."
    php artisan storage:link || true
fi

# 3. Generate APP_KEY jika belum ada di environment
if [ -z "$APP_KEY" ]; then
    echo "🔑 APP_KEY belum terdeteksi, menghasilkan application key baru..."
    php artisan key:generate --force --no-interaction
fi

# 4. Tunggu koneksi database jika DB_HOST dikonfigurasi
if [ -n "$DB_HOST" ] && [ "$DB_HOST" != "127.0.0.1" ]; then
    echo "⏳ Menunggu database di $DB_HOST:${DB_PORT:-3306} siap..."
    max_retries=30
    counter=0
    until php -r "
        \$h = getenv('DB_HOST') ?: 'db_tu_smkn';
        \$p = getenv('DB_PORT') ?: '3306';
        \$d = getenv('DB_DATABASE') ?: 'tu_smkn_karanganyar';
        \$u = getenv('DB_USERNAME') ?: 'tu_user';
        \$w = getenv('DB_PASSWORD') ?: '';
        try {
            new PDO(\"mysql:host=\$h;port=\$p;dbname=\$d\", \$u, \$w, [PDO::ATTR_TIMEOUT => 3]);
            exit(0);
        } catch (\Exception \$e) {
            echo \$e->getMessage();
            exit(1);
        }
    " > /tmp/db_err.txt 2>&1; do
        sleep 2
        counter=$((counter + 1))
        if [ $counter -ge $max_retries ]; then
            echo "⚠️ Peringatan: Tidak dapat terhubung ke database setelah $max_retries percobaan."
            if [ -f /tmp/db_err.txt ]; then
                echo "   Detail error: $(cat /tmp/db_err.txt)"
            fi
            echo "   Melanjutkan startup..."
            break
        fi
    done
    if [ $counter -lt $max_retries ]; then
        echo "✅ Terhubung ke database MySQL/MariaDB dengan sukses!"
        echo "📦 Menjalankan migrasi database..."
        php artisan migrate --force --no-interaction || true
    fi
fi

# 5. Optimasi Cache Laravel pada Production
if [ "$APP_ENV" = "production" ]; then
    echo "⚡ Menjalankan optimasi cache Laravel untuk Dokploy Production..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

# Pastikan kembali izin kepemilikan setelah pembuatan cache & key
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "=================================================="
echo "✨ Aplikasi TU SMKN Karanganyar siap melayani permintaan!"
echo "=================================================="

# Jalankan command utama (apache2-foreground)
exec "$@"
