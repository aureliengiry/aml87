FROM php:7.4-apache

LABEL org.opencontainers.image.authors="Aurélien GIRY <aurelien.giry@gmail.com>"
LABEL org.opencontainers.image.title="Custom PHP 7.4 image for Relight Admin application."

COPY . /usr/local/docker
RUN chmod -R 777 /usr/local/docker

RUN apt-get update && apt-get install -y libxml2-dev libxml2-utils libfreetype6-dev libjpeg62-turbo-dev libjpeg-dev \
    libpng-dev vim nano default-mysql-client telnet netcat wget git libicu-dev ssl-cert iproute2 zip unzip libwebp-dev libzip-dev librabbitmq-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freetype --with-webp \
    && docker-php-ext-install soap gd zip intl opcache pdo pdo_mysql mysqli calendar bcmath sockets json \
    && pecl install apcu xdebug amqp \
    && docker-php-ext-enable apcu opcache calendar xdebug amqp

# Apache modules
RUN a2enmod ssl expires headers rewrite

# Install the Blackfire PHP probe
# @see https://blackfire.io/docs/php/integrations/php-docker
RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && architecture=$(case $(uname -m) in i386 | i686 | x86) echo "i386" ;; x86_64 | amd64) echo "amd64" ;; aarch64 | arm64 | armv8) echo "arm64" ;; *) echo "amd64" ;; esac) \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/$architecture/$version \
    && mkdir -p /tmp/blackfire \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get ('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
    && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz

# Assign a new UID/GID to avoid using a generated value
RUN \
    usermod -u 1000 www-data && \
    groupmod -g 1000 www-data

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_MEMORY_LIMIT -1

ENTRYPOINT ["/usr/local/docker/run.sh"]
