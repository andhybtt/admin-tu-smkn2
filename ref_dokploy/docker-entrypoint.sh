#!/bin/bash
set -e

echo "=================================================="
echo "🚀 Memulai SIM Administrasi Guru (Dokploy / Docker)"
echo "=================================================="

cd /var/www/html/laravel_app

# 1. Pastikan seluruh folder storage dan bootstrap/cache dibuat dan berizin 777
mkdir -p storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/logs \
         storage/app/public \
         bootstrap/cache \
         public/uploads/absensi \
         /var/www/html/uploads

touch storage/logs/laravel.log

chown -R www-data:www-data storage bootstrap/cache public/uploads /var/www/html/uploads
chmod -R 775 storage bootstrap/cache public/uploads /var/www/html/uploads

# 2. Generate APP_KEY jika belum ada di .env atau environment
if [ -z "$APP_KEY" ]; then
    echo "🔑 APP_KEY belum terdeteksi, menghasilkan application key baru..."
    php artisan key:generate --force --no-interaction
fi

# 3. Optimasi Cache Laravel pada Production
if [ "$APP_ENV" = "production" ]; then
    echo "⚡ Menjalankan optimasi cache Laravel untuk Dokploy Production..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

# 4. Tunggu koneksi database jika DB_HOST dikonfigurasi
if [ -n "$DB_HOST" ] && [ "$DB_HOST" != "127.0.0.1" ]; then
    echo "⏳ Menunggu database di $DB_HOST:$DB_PORT siap..."
    max_retries=30
    counter=0
    until php -r "
        \$h = getenv('DB_HOST') ?: 'db';
        \$p = getenv('DB_PORT') ?: '3306';
        \$d = getenv('DB_DATABASE') ?: 'db_administrasi_guru';
        \$u = getenv('DB_USERNAME') ?: getenv('DB_USER') ?: 'root';
        \$w = getenv('DB_PASSWORD') ?: '';
        try {
            new PDO(\"mysql:host=\$h;port=\$p;dbname=\$d\", \$u, \$w);
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
        echo "✅ Terhubung ke database MySQL dengan sukses!"
        # Jalankan migrasi jika diperlukan
        php artisan migrate --force --no-interaction || true
    fi
fi

# Re-ensure permissions after key generation and cache creation
chmod -R 775 storage bootstrap/cache

echo "=================================================="
echo "✨ Aplikasi siap melayani permintaan!"
echo "=================================================="

# Jalankan command utama (apache2-foreground)
exec "$@"
