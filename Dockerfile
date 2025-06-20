# Gunakan base image PHP-FPM resmi. Sesuaikan versi PHP (misal: 8.3-fpm-alpine)
# jika aplikasi Anda memerlukan versi PHP yang berbeda.
FROM php:8.2-fpm-alpine

# Install Nginx dan ekstensi PHP yang mungkin dibutuhkan oleh Laravel.
# `mysql-client` untuk koneksi database MySQL/MariaDB.
# `nodejs` dan `npm` untuk membangun aset frontend (Vite).
RUN apk add --no-cache nginx \
    mysql-client \
    nodejs \
    npm \
    # Tambahan ekstensi PHP yang umum dibutuhkan Laravel:
    php82-dom \
    php82-pdo_mysql \
    php82-mbstring \
    php82-xml \
    php82-zip \
    php82-gd \
    php82-curl \
    php82-opcache \
    php82-json \
    php82-fileinfo \
    php82-tokenizer \
    php82-session \
    php82-bcmath \
    php82-ctype \
    php82-exif \
    php82-iconv \
    php82-intl \
    php82-openssl \
    php82-phar \
    php82-pecl-redis # Contoh jika Anda menggunakan Redis, hapus jika tidak
    # Anda mungkin perlu menambahkan ekstensi lain sesuai kebutuhan spesifik aplikasi Anda.

# Set working directory di dalam container ke /app
WORKDIR /app

# Salin kode aplikasi Laravel Anda ke dalam container
# Pastikan ini dilakukan SETELAH install Composer dan NPM jika Anda ingin layer cache Docker yang efisien
COPY . /app

# Install Composer: Salin biner Composer dari image resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# Jalankan Composer install. --no-dev untuk produksi, --optimize-autoloader untuk performa.
RUN composer install --no-dev --optimize-autoloader

# Install Node.js dependencies dan jalankan build Vite
# Jika Anda menggunakan `npm ci` di lokal, pakai itu di sini.
# Pastikan `npm run build` ada di package.json Anda
RUN npm ci && npm run build

# Salin file konfigurasi Nginx kustom Anda ke dalam container
# File nginx.conf ini harus ada di root proyek Anda (sejajar dengan Dockerfile)
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Setel izin untuk direktori yang dapat ditulis oleh Laravel
# `www-data` adalah user default yang digunakan PHP-FPM dan Nginx di Alpine Linux
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache
RUN chmod -R 775 /app/storage /app/bootstrap/cache

# Buka port 80 untuk Nginx
EXPOSE 80

# Perintah untuk memulai PHP-FPM dan Nginx
# `php-fpm -F` menjalankan PHP-FPM di foreground.
# `nginx -g 'daemon off;'` menjalankan Nginx di foreground (tidak sebagai daemon background).
# `&&` memastikan Nginx hanya berjalan jika PHP-FPM berhasil dimulai.
CMD php-fpm -F && nginx -g 'daemon off;'