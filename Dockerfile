# ... (bagian sebelumnya dari Dockerfile)

# Install dependensi sistem yang dibutuhkan untuk Nginx, Node.js, dan ekstensi PHP
RUN apk add --no-cache \
    nginx \
    mysql-client \
    nodejs \
    npm \
    # Dependensi untuk ekstensi PHP
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    # Untuk intl
    icu-dev \
    # Untuk bcmath
    php82-bcmath \
    # Untuk gd
    php82-gd \
    # Untuk curl
    php82-curl \
    # Untuk intl
    php82-intl \
    # Untuk zip
    php82-zip \
    # Untuk opcache (penting untuk performa)
    php82-opcache \
    # Untuk fileinfo
    php82-fileinfo \
    # Untuk tokenizer
    php82-tokenizer \
    # Untuk session
    php82-session \
    # Untuk openssl
    php82-openssl

# Instal ekstensi PHP menggunakan script helper bawaan Docker
RUN docker-php-ext-install pdo pdo_mysql mbstring xml dom json \
    # Tambahan jika menggunakan Redis
    && pecl install redis \
    && docker-php-ext-enable redis

# Opsional: Jika Anda menggunakan versi PHP yang berbeda atau ada masalah,
# pastikan versi di FROM match dengan phpXX- di atas
# Misalnya, jika FROM php:8.3-fpm-alpine, ganti semua php82- menjadi php83-

# ... (bagian selanjutnya dari Dockerfile)