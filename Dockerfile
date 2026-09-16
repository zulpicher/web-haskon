FROM php:8.3-fpm

# Install dependency sistem yang dibutuhkan ekstensi PHP di bawah
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer (disalin dari image resmi Composer, bukan install manual)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy source code (saat development, folder ini akan di-override oleh volume mount di docker-compose.yml)
COPY . .

# Install dependency PHP
RUN composer install --no-interaction --optimize-autoloader

# Set permission storage & cache supaya Laravel bisa nulis log/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
