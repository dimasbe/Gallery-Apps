FROM php:8.2-fpm-alpine

# Install dependensi sistem dan ekstensi PHP
RUN apk add --no-cache nginx mysql-client nodejs npm libzip-dev libpng-dev libjpeg-turbo-dev libwebp-dev freetype-dev icu-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring xml dom json \
    && pecl install redis \
    && docker-php-ext-enable redis

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