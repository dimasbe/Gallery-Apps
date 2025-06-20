# ... (bagian sebelumnya dari Dockerfile)

# Install Nginx dan ekstensi PHP yang mungkin dibutuhkan oleh Laravel.
RUN apk add --no-cache nginx \
    mysql-client \
    nodejs \
    npm \
    # Ekstensi PHP untuk Laravel:
    php82-dom \
    php82-pdo_mysql \ # PASTIKAN INI ADA
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
    # php82-pecl-redis # Hapus atau komen ini jika Anda tidak menggunakan Redis

    # Tambahan penting untuk memastikan PDO MySQL driver tersedia:
    php82-pdo_sqlite # Seringkali pdo_sqlite juga dibutuhkan untuk testing/cache
    # Jika Anda menggunakan PostgreSQL, Anda butuh:
    # php82-pdo_pgsql \
    # postgresql-client

# ... (bagian selanjutnya dari Dockerfile)