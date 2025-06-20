FROM php:8.2-fpm-alpine

# Install dependensi sistem, Nginx, Node.js, dan ekstensi PHP
RUN apk add --no-cache \
    nginx \
    mysql-client \
    nodejs \
    npm \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    icu-dev \
    oniguruma-dev \
    libxml2-dev \
    # Kembali menggunakan paket php-pecl-redis karena lebih stabil di Alpine
    php82-pecl-redis \
    # Dan tambahkan ekstensi PHP yang dibutuhkan Laravel dan sudah dikompilasi sebelumnya
    php82-bcmath \
    php82-gd \
    php82-curl \
    php82-intl \
    php82-zip \
    php82-opcache \
    php82-fileinfo \
    php82-tokenizer \
    php82-session \
    php82-openssl && \
    # Gunakan docker-php-ext-install HANYA untuk ekstensi yang tidak tersedia sebagai paket phpXX-
    docker-php-ext-install pdo pdo_mysql mbstring xml dom json

WORKDIR /app

COPY . /app

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

RUN npm ci && npm run build

COPY nginx.conf /etc/nginx/conf.d/default.conf

RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache
RUN chmod -R 775 /app/storage /app/bootstrap/cache

EXPOSE 80

CMD php-fpm -F && nginx -g 'daemon off;'