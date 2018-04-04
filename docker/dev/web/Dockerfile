FROM php:7.1-apache

MAINTAINER Aurélien GIRY <aurelien.giry@gmail.com>

COPY . /usr/local/docker
RUN chmod -R 777 /usr/local/docker

RUN apt-get update && apt-get install -y \
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

# Blackfire extension
RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/amd64/$version \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp \
    && mv /tmp/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini

# Blackfire CLI
RUN mkdir -p /tmp/blackfire \
    && curl -A "Docker" -L https://blackfire.io/api/v1/releases/client/linux_static/amd64 | tar zxp -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire /usr/bin/blackfire \
    && rm -Rf /tmp/blackfire

RUN usermod -u 1000 www-data


RUN usermod -u 1000 www-data

ENTRYPOINT ["/usr/local/docker/run.sh"]
