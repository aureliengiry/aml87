ARG PHP_VERSION=8.2

FROM composer/composer:2-bin AS composer
FROM mlocati/php-extension-installer:latest AS php_extension_installer

FROM php:${PHP_VERSION}-fpm-alpine as aml87_php_fpm
ENV USERNAME=www-data
ARG BUILD_ARGUMENT_ENV=dev

LABEL org.opencontainers.image.authors="Aurélien GIRY <aurelien.giry@gmail.com>"
LABEL org.opencontainers.image.title="Custom PHP 8.2 FPM image for AML87 application."

ENV APP_HOME /var/www/html

# php extensions installer: https://github.com/mlocati/docker-php-extension-installer
COPY --from=php_extension_installer --link /usr/bin/install-php-extensions /usr/local/bin/

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"
COPY --from=composer --link /composer /usr/bin/composer

# Install Symfony requirements
ENV APCU_VERSION 5.1.18
RUN \
    apk add --no-cache \
        freetype-dev \
        icu-libs \
        libjpeg-turbo-dev \
        libpng-dev \
        libwebp-dev \
        zlib-dev \
        libxml2-dev  \
        libxml2-utils  \
        libzip-dev \
        rabbitmq-c rabbitmq-c-dev \
        zip unzip && \
    apk add --no-cache --virtual .build-deps \
        ${PHPIZE_DEPS}\
        icu-dev && \
    apk del .build-deps && \
    set -eux; \
    install-php-extensions \
        amqp \
		apcu \
        bcmath \
        calendar \
        gd \
		intl \
		opcache \
        pdo_mysql \
		zip \
    ;

ARG XDEBUG_VERSION=3.2.1
RUN if [[ "$BUILD_ARGUMENT_ENV" = "dev" ]] ; then install-php-extensions xdebug-${XDEBUG_VERSION}; else echo "No xdebug on prod"; fi

COPY --link ./docker/docker-full/phpfpm/conf.d/${BUILD_ARGUMENT_ENV}/custom-php.ini /usr/local/etc/php/php.ini
COPY --link ./docker/docker-full/phpfpm/php-fpm.d/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
WORKDIR $APP_HOME

COPY --chown=${USERNAME}:${USERNAME} . $APP_HOME/
RUN if [ "$BUILD_ARGUMENT_ENV" = "dev" ] || [ "$BUILD_ARGUMENT_ENV" = "test" ] ; then COMPOSER_MEMORY_LIMIT=-1 composer install --optimize-autoloader --no-interaction --no-progress; \
    else COMPOSER_MEMORY_LIMIT=-1 composer install -o --no-dev --no-scripts && COMPOSER_MEMORY_LIMIT=-1 composer dump-autoload -o --no-dev --classmap-authoritative; \
    fi

# ======================================================================================================================
FROM node:16.15-alpine AS assets_builder
USER node
RUN mkdir -p /home/node/app
WORKDIR /home/node/app

COPY --chown=node . .

ARG BUILD_ARGUMENT_ENV=dev
RUN if [ "$BUILD_ARGUMENT_ENV" = "dev" ] ; then yarn install && yarn run encore dev; \
    else yarn install --production && yarn run encore production; \
    fi
# ======================================================================================================================

FROM aml87_php_fpm

COPY --from=assets_builder --chown=${USERNAME}:${USERNAME} /home/node/app/node_modules $APP_HOME/node_modules
COPY --from=assets_builder --chown=${USERNAME}:${USERNAME} /home/node/app/public/build $APP_HOME/public/build
COPY --from=assets_builder --chown=${USERNAME}:${USERNAME} /home/node/app/package.json $APP_HOME/package.json
COPY --from=assets_builder --chown=${USERNAME}:${USERNAME} /home/node/app/yarn.lock $APP_HOME/yarn.lock

USER root

CMD ["php-fpm"]
