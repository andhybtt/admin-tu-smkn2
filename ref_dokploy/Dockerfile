# ==============================================================================
# Dockerfile: SIM Administrasi Guru & Siswa (Laravel + Livewire + PWA)
# Optimized for Dokploy Deployment & Cloud PaaS (Traefik / Coolify / Docker)
# Base: PHP 8.2 Apache (Debian Bookworm)
# ==============================================================================

FROM php:8.2-apache

# 1. Install system dependencies & libraries
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
    && rm -rf /var/lib/apt/lists/*

# 2. Configure & Install PHP extensions required by Laravel & Imaging
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mysqli \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        opcache

# 3. Copy Composer from official image
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# 4. Enable Apache Modules (rewrite, headers, expires)
RUN a2enmod rewrite headers expires

# 5. Copy Apache VirtualHost configuration
COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf

# 6. Set Working Directory
WORKDIR /var/www/html

# 7. Copy Application Source Code
COPY . /var/www/html/

# 8. Install Composer dependencies for Laravel App
WORKDIR /var/www/html/laravel_app
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-ansi || true

WORKDIR /var/www/html

# 9. Configure Directory Permissions for Storage & Cache
RUN mkdir -p /var/www/html/laravel_app/storage/framework/cache/data \
             /var/www/html/laravel_app/storage/framework/sessions \
             /var/www/html/laravel_app/storage/framework/views \
             /var/www/html/laravel_app/storage/logs \
             /var/www/html/laravel_app/storage/app/public \
             /var/www/html/laravel_app/bootstrap/cache \
             /var/www/html/laravel_app/public/uploads/absensi \
             /var/www/html/uploads \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/laravel_app/storage \
    && chmod -R 775 /var/www/html/laravel_app/bootstrap/cache \
    && chmod -R 775 /var/www/html/laravel_app/public/uploads \
    && chmod -R 775 /var/www/html/uploads

# 10. Configure PHP Production Settings
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

# 11. Configure Entrypoint Script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# 12. Expose Port 80 (For Dokploy / Traefik Reverse Proxy)
EXPOSE 80

# 13. Healthcheck
HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
    CMD curl -f http://localhost/up || curl -f http://localhost/ || exit 1

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]
