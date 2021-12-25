FROM php:7.4-apache

LABEL org.opencontainers.image.authors="Relight developers <relight-dev@amg-dev.fr"
LABEL org.opencontainers.image.title="Custom PHP 7.4 image for Relight Admin Testing"

RUN apt-get update && apt-get install -y libxml2-dev libxml2-utils libfreetype6-dev libjpeg62-turbo-dev \
        libjpeg-dev libpng-dev libwebp-dev libicu-dev wget git zip unzip libzip-dev \
        && pecl install apcu \
        && docker-php-ext-configure gd --with-jpeg --with-freetype --with-webp \
        && docker-php-ext-install soap gd zip intl opcache pdo calendar bcmath sockets json \
        && docker-php-ext-enable opcache calendar apcu

RUN apt autoremove -y
RUN curl -sL https://deb.nodesource.com/setup_14.x | /bin/bash -
RUN apt-get update && apt-get install -y nodejs
RUN npm install -g yarn

RUN echo 'date.timezone=Europe/Paris' >> /usr/local/etc/php/php.ini
RUN echo 'opcache.memory_consumption=256' >> /usr/local/etc/php/php.ini
RUN echo 'opcache.max_accelerated_files=20000' >> /usr/local/etc/php/php.ini
RUN echo 'opcache.validate_timestamps=1' >> /usr/local/etc/php/php.ini
RUN echo 'realpath_cache_size=4096K' >> /usr/local/etc/php/php.ini
RUN echo 'realpath_cache_ttl=600' >> /usr/local/etc/php/php.ini

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_MEMORY_LIMIT -1
