FROM composer:2.8 AS composer

# filament couldn't be installed without these 
RUN apk add --no-cache icu-dev && \
    docker-php-ext-install intl

WORKDIR /app
COPY ./muzawed/composer.json ./muzawed/composer.lock ./


RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --classmap-authoritative \
    --no-interaction \
    --no-progress \
    --no-scripts \
    --prefer-dist \
    && composer clear-cache \
    && find vendor -type f -name "*.md" -o -name "*.txt" -o -name "*.json" -o -name "*.lock" -delete \
    && find vendor -type d -name "tests" -o -name "test" -o -name "docs" -o -name "documentation" | xargs rm -rf \
    && find vendor -type d -name ".git" -o -name ".github" | xargs rm -rf


FROM php:8.4-fpm-alpine AS php-builder

RUN apk add --no-cache --virtual .build-deps \
        build-base \
        autoconf \
        libpng-dev \
        libxml2-dev \
        oniguruma-dev \
        icu-dev \
        libzip-dev \
    && apk add --no-cache --virtual .runtime-deps \
        libpng \
        libxml2 \
        oniguruma \
        icu-libs \
        libzip \
        curl \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        intl \
        zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps \
    && rm -rf /tmp/* /var/cache/apk/* /usr/src/* \
    && find /usr/local/lib/php -name "*.a" -delete \
    && find /usr/local/lib/php -name "*.la" -delete \
    && rm -rf /usr/local/lib/php/doc/* \
    && rm -rf /usr/local/php/man/*
# single output 
RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=2'; \
    echo 'opcache.fast_shutdown=1'; \
    echo 'opcache.enable_cli=1'; \
    echo 'opcache.jit=1255'; \
    echo 'opcache.jit_buffer_size=100M'; \
    } > /usr/local/etc/php/conf.d/opcache-recommended.ini


FROM php:8.4-fpm-alpine

COPY --from=php-builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=php-builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

#runtime dependencies
RUN apk add --no-cache \
        libpng \
        libxml2 \
        oniguruma \
        icu-libs \
        libzip \
        curl \
    && rm -rf /var/cache/apk/*

WORKDIR /var/www/muzawed

COPY --from=composer /app/vendor ./vendor

COPY ./muzawed/composer.json ./composer.json
COPY ./muzawed/composer.lock ./composer.lock
COPY ./muzawed/config ./config
COPY ./muzawed/routes ./routes
COPY ./muzawed/bootstrap ./bootstrap
COPY ./muzawed/artisan ./artisan

COPY ./muzawed/public ./public

COPY ./muzawed/app ./app
COPY ./muzawed/resources/views ./resources/views
COPY ./muzawed/resources/lang ./resources/lang

RUN mkdir -p bootstrap/cache storage/app/public storage/framework/cache \
    storage/framework/sessions storage/framework/views storage/logs \
    && touch bootstrap/cache/.gitignore \
    && chown -R www-data:www-data bootstrap/cache storage \
    && chmod -R 775 bootstrap/cache storage

RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && rm -rf /tmp/*

EXPOSE 9000

CMD ["php-fpm"]
