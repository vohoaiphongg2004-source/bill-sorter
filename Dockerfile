FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev \
    && docker-php-ext-install zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

# Tạo APP_KEY nếu chưa có
RUN cp .env.example .env || true
RUN php artisan key:generate --force

# Cache
RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}