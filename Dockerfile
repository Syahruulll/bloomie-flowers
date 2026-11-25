FROM node:22-bookworm-slim AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./
RUN npm run build

FROM php:8.3-cli-bookworm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        gosu \
        ifupdown \
        iproute2 \
        iputils-ping \
        curl \
        libonig-dev \
        libpq-dev \
        libzip-dev \
        unzip \
        isc-dhcp-client \
    && docker-php-ext-install mbstring pdo_pgsql zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

COPY . .
RUN composer install \
        --no-dev \
        --no-interaction \
        --prefer-dist \
        --optimize-autoloader \
    && mkdir -p \
        bootstrap/cache \
        public/uploads \
        storage/app \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
    && chown -R www-data:www-data bootstrap/cache public/uploads storage

COPY --from=frontend /app/public/build ./public/build
COPY docker/entrypoint.sh /usr/local/bin/bloomie-entrypoint
RUN chmod +x /usr/local/bin/bloomie-entrypoint

VOLUME ["/var/www/html/public/uploads", "/var/www/html/storage"]

EXPOSE 8000

ENTRYPOINT ["/usr/local/bin/bloomie-entrypoint"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
