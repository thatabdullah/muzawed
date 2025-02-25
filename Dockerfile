FROM php:8.2-fpm


RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        git \
        curl \
        zip \
        unzip \
        libpng-dev \
        libonig-dev \
        libicu-dev \
        libxml2-dev \
        libzip-dev && \
    docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl zip && \
    pecl install redis && docker-php-ext-enable redis && rm -rf /var/lib/apt/lists/* 

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


RUN composer global require laravel/installer && \
    ln -s $(composer config --global home)/vendor/bin/laravel /usr/local/bin/laravel && \
    composer require livewire/livewire:^3.0 && composer require filament/filament:"^3.2" -W \
    && composer require bezhansalleh/filament-language-switch


WORKDIR /var/www


EXPOSE 8000

CMD ["php-fpm"]
