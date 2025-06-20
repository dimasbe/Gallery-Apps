FROM php:8.2-fpm-alpine

# Install Nginx dan ekstensi PHP yang dibutuhkan
RUN apk add --no-cache nginx mysql-client nodejs npm \
    php82-dom php82-pdo_mysql php82-mbstring php82-xml php82-zip php82-gd \
    php82-curl php82-opcache php82-json php82-fileinfo php82-tokenizer \
    php82-session php82-bcmath php82-ctype php82-exif php82-iconv php82-intl \
    php82-openssl php82-phar php82-pdo_sqlite php82-pecl-redis

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