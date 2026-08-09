FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    poppler-utils \
    qpdf \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN cp .env.example .env || true
RUN php artisan key:generate --force

RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear

# Giới hạn upload / xử lý PDF
RUN echo "upload_max_filesize=50M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size=50M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit=512M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_execution_time=300" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_input_time=300" >> /usr/local/etc/php/conf.d/uploads.ini

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}