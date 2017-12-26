FROM php:7.1-apache

MAINTAINER Aurélien GIRY <aurelien.giry@gmail.com>

COPY . /usr/local/docker
RUN chmod -R 777 /usr/local/docker


# # PHP 7.1
# RUN apt-get update --fix-missing && apt-get install -y autoconf \
#     php7.1 \
#     libapache2-mod-php7.1 \
#     php7.1-apcu \
#     php7.1-apcu-bc \
#     php7.1-cli \
#     php7.1-mysql \
#     php7.1-curl \
#     php7.1-json \
#     php7.1-gd \
#     php7.1-mcrypt \
#     php7.1-msgpack \
#     php7.1-intl \
#     php7.1-sqlite3 \
#     php7.1-gmp \
#     php7.1-geoip \
#     php7.1-mbstring \
#     php7.1-xml \
#     php7.1-zip \
#     php7.1-mongodb \
#     php7.1-xdebug \
#     php7.1-xmlrpc \
#     php7.1-xsl \
#     php7.1-dev \
#     php-pear

RUN apt-get update && apt-get install -y \
        php-soap \
        php-http-request \
        libxml2-dev \
        libxml2-utils \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng12-dev \
        vim \
        mysql-client \
        telnet \
        netcat \
        wget \
        git \
        libicu-dev \
        python-pip \
        python-dev

RUN docker-php-ext-install soap gd zip intl opcache pdo pdo_mysql mysqli mbstring
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug opcache

# # Tools
# RUN apt-get update --fix-missing && apt-get install -y autoconf \
#     git \
#     default-jre \
#     acl \
#     curl \
#     make \
#     vim \
#     mysql-client

# Sphinx documentation
RUN pip install sphinx sphinx-autobuild sphinx_rtd_theme sphinxcontrib-phpdomain git+https://github.com/fabpot/sphinx-php.git

# Composer
RUN \
    curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Install phpunit
RUN \
    wget https://phar.phpunit.de/phpunit.phar && \
    chmod +x phpunit.phar && \
    mv phpunit.phar /usr/local/bin/phpunit 

# RUN echo 'date.timezone = Europe/Paris' >> /etc/php/7.1/cli/php.ini
# RUN echo 'date.timezone = Europe/Paris' >> /etc/php/7.1/apache2/php.ini

RUN pecl update-channels

RUN \
    export PHP_VERSION=`/usr/bin/php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;"` && \
    curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/amd64/${PHP_VERSION} && \
    export PHP_EXT_DIR=`/usr/bin/php -r "echo ini_get('extension_dir');"` && \
    tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp && mv /tmp/blackfire-*.so ${PHP_EXT_DIR}/blackfire.so && \
    chown root ${PHP_EXT_DIR}/blackfire.so && chown :root ${PHP_EXT_DIR}/blackfire.so && chmod 0755 ${PHP_EXT_DIR}/blackfire.so

RUN usermod -u 1000 www-data

ENTRYPOINT ["/usr/local/docker/run.sh"]
