# ... (bagian sebelumnya dari Dockerfile)

# Install Nginx dan ekstensi PHP yang mungkin dibutuhkan oleh Laravel.
RUN apk add --no-cache nginx \
    mysql-client \
    nodejs \
    npm \
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
    php82-pdo_sqlite \
    php82-pecl-redis # Hapus atau komen baris ini jika Anda tidak menggunakan Redis

# ... (bagian selanjutnya dari Dockerfile)