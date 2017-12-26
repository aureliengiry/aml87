#!/bin/bash

function init_server()
{
    APP_IP="$(/sbin/ifconfig eth0| grep "inet addr:" | awk {"print $2"} | cut -d ":" -f 2)"
    echo "ServerName localhost" >> /etc/apache2/apache2.conf

    service apache2 start
}

function init_configuration()
{
    #sed -i -e "s|Listen 80|Listen 8080|g" /etc/apache2/ports.conf
    #sed -i -e "s|:80|:8080|g" /etc/apache2/sites-enabled/000-default.conf
    #sed -i -e "s|80.conf|8080.conf|g" /etc/apache2/sites-enabled/000-default.conf

    a2enmod ssl expires headers rewrite

    echo "<?php phpinfo(); ?>" > /var/www/html/phpinfo.php
}

function init_vhosts()
{
    echo "Disabled all vhosts"
    rm /etc/apache2/sites-enabled/*

    echo "Init vhosts"
    VHOSTS_PATH="/etc/apache2/sites-available/"
    if [[ -d "${VHOSTS_PATH}" ]]; then
        VHOST_FILES="$(find "${VHOSTS_PATH}" -maxdepth 1 -type f -name *.conf)"
        if [[ ! -z "${VHOST_FILES}" ]]; then
            for FILE in ${VHOST_FILES}; do
                FILENAME="$(basename "${FILE}")"

                VHOST_NAME="$(echo "${FILENAME}" | cut -d : -f 1)"

                a2ensite "${VHOST_NAME}"
            done
        fi
    fi
}

function init_blackfire()
{
    read -r -d '' BLACKFIRE_INI <<HEREDOC
extension=blackfire.so
blackfire.agent_socket=tcp://blackfire:${BLACKFIRE_PORT}
blackfire.agent_timeout=5
blackfire.log_file=/var/log/blackfire.log
blackfire.log_level=${BLACKFIRE_LOG_LEVEL}
blackfire.server_id=${BLACKFIRE_SERVER_ID}
blackfire.server_token=${BLACKFIRE_SERVER_TOKEN}
HEREDOC

    echo "${BLACKFIRE_INI}" >>  /usr/local/etc/php/conf.d/blackfire.ini
}

function init_xdebug()
{
    read -r -d '' XDEBUG_INI <<HEREDOC
[xdebug]
xdebug.max_nesting_level=500
xdebug.profiler_enable_trigger=1
xdebug.profiler_output_dir=/var/www/html/xdebug
xdebug.profiler_output_name=cachegrind.out.%p.%u
xdebug.var_display_max_children=-1
xdebug.var_display_max_depth=-1
xdebug.var_display_max_data=-1
xdebug.remote_autostart=0
xdebug.remote_enable=1
xdebug.remote_port=9000
xdebug.remote_connect_back=1
xdebug.remote_handler=dbgp
HEREDOC

    echo "${XDEBUG_INI}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

    read -r -d '' XDEBUG_PROFILE <<HEREDOC
# Xdebug
export PHP_IDE_CONFIG="serverName=${XDEBUG_SERVER_NAME}"
export XDEBUG_CONFIG="remote_host=$(/sbin/ip route|awk '/default/ { print $3 }') idekey=${XDEBUG_IDE_KEY}"
HEREDOC

    echo "${XDEBUG_PROFILE}" >> ~/.bashrc
}

function init_opcache()
{
    read -r -d '' OPCACHE_INI <<HEREDOC
[OPcache]
opcache.memory_consumption=512
opcache.revalidate_freq=60
opcache.validate_timestamps=1
opcache.max_accelerated_files=5000
HEREDOC

    echo "${OPCACHE_INI}" >> /etc/php/7.1/mods-available/opcache.ini
}

LOCK_FILE="/var/docker.lock"
if [[ ! -e "${LOCK_FILE}" ]]; then

    init_server
    init_configuration
    # init_opcache
    init_xdebug
    #init_blackfire

    service apache2 restart

    touch "${LOCK_FILE}"
fi

init_vhosts
composer self-update
service apache2 start

tail -f /dev/null
