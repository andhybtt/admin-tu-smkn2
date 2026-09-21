# ==============================================================================
# Dockerfile: SIM Administrasi Tata Usaha SMKN Karanganyar
# Laravel 11 + Livewire 3 + Tailwind CSS (Vite Multi-stage Build)
# Optimized for Dokploy Deployment & Cloud PaaS (Traefik / Cloudflare / Docker)
# Base Runtime: PHP 8.2 Apache (Debian Bookworm)
# ==============================================================================

# ------------------------------------------------------------------------------
# Stage 1: Kompilasi Asset Frontend (Node.js 20 & Vite)
# ------------------------------------------------------------------------------
FROM node:20-alpine AS frontend-builder

WORKDIR /app

# Salin package.json & lockfile
COPY package.json package-lock.json* ./

# Install dependensi npm
RUN npm ci || npm install

# Salin konfigurasi Tailwind & Vite beserta source code frontend
COPY tailwind.config.js vite.config.js ./
COPY resources ./resources
COPY public ./public

# Kompilasi asset produksi ke folder /public/build
RUN npm run build

# ------------------------------------------------------------------------------
# Stage 2: Runtime PHP 8.2 Apache Production
# ------------------------------------------------------------------------------
FROM php:8.2-apache

LABEL maintainer="SMK Negeri Karanganyar <tu@smkn-karanganyar.sch.id>"
LABEL description="Sistem Informasi Administrasi Tata Usaha SMK Negeri Karanganyar"

# 1. Install dependensi sistem Linux (Debian Bookworm)
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    unzip \
    zip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    && rm -rf /var/lib/apt/lists/*

# 2. Konfigurasi & install ekstensi PHP yang dibutuhkan Laravel, Livewire & Scan Dokumen
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mysqli \
        mbstring \
        exif \
        pcntl \
        bcmath \
        intl \
        gd \
        zip \
        opcache

# 3. Salin Composer resmi dari image composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# 4. Aktifkan modul Apache (rewrite, headers, expires)
RUN a2enmod rewrite headers expires

# 5. Salin konfigurasi Apache VirtualHost
COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf

# 6. Set Direktori Kerja Aplikasi
WORKDIR /var/www/html

# 7. Salin seluruh Source Code Aplikasi
COPY . /var/www/html/

# 8. Salin hasil kompilasi Vite dari Stage 1
COPY --from=frontend-builder /app/public/build /var/www/html/public/build

# 9. Install dependensi Composer (Production mode, tanpa dev package)
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-ansi

# 10. Konfigurasi Direktori Penyimpanan & Hak Akses
RUN mkdir -p /var/www/html/storage/framework/cache/data \
             /var/www/html/storage/framework/sessions \
             /var/www/html/storage/framework/views \
             /var/www/html/storage/logs \
             /var/www/html/storage/app/public \
             /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 11. Konfigurasi Pengaturan PHP Produksi (Ukuran Upload 64M & OPcache)
RUN { \
        echo "upload_max_filesize = 64M"; \
        echo "post_max_size = 64M"; \
        echo "memory_limit = 256M"; \
        echo "max_execution_time = 300"; \
        echo "date.timezone = Asia/Jakarta"; \
        echo "display_errors = Off"; \
        echo "log_errors = On"; \
        echo "error_reporting = E_ALL"; \
        echo "session.cookie_httponly = 1"; \
        echo "session.use_only_cookies = 1"; \
        echo "opcache.enable = 1"; \
        echo "opcache.memory_consumption = 128"; \
        echo "opcache.interned_strings_buffer = 8"; \
        echo "opcache.max_accelerated_files = 10000"; \
        echo "opcache.revalidate_freq = 2"; \
    } > /usr/local/etc/php/conf.d/custom-production.ini

# 12. Salin Entrypoint Script
COPY docker/entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# 13. Expose Port 80 (Untuk Dokploy / Traefik Reverse Proxy)
EXPOSE 80

# 14. Healthcheck
HEALTHCHECK --interval=30s --timeout=5s --start-period=15s --retries=3 \
    CMD curl -f http://localhost/up || curl -f http://localhost/ || exit 1

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]
