#!/bin/bash

SCRIPT_PATH=$(readlink -f "$0")
DIRECTORY_PATH=$(dirname "${SCRIPT_PATH}")

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

    # PHP INI
    echo "Config - PHP INI"
    CONFIG_FILE="${DIRECTORY_PATH}/extra/conf/php.ini"
    if [[ -e "${CONFIG_FILE}" ]]; then
        cp -f "${CONFIG_FILE}" /usr/local/etc/php/php.ini
        echo "File \"${CONFIG_FILE}\" successfully imported."
    fi

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

function init_xdebug()
{
    echo "Xdebug INIT - START"

     read -r -d '' XDEBUG_PROFILE <<HEREDOC
# Xdebug
export PHP_IDE_CONFIG="serverName=${XDEBUG_SERVER_NAME}"
export XDEBUG_CONFIG="remote_host=$(/sbin/ip route|awk '/default/ { print $3 }') idekey=${XDEBUG_IDE_KEY}"
HEREDOC

    echo "${XDEBUG_PROFILE}" >> ~/.bashrc

    echo "Xdebug INIT - END"
}

LOCK_FILE="/var/docker.lock"
if [[ ! -e "${LOCK_FILE}" ]]; then

    init_server

    # init_opcache
    init_xdebug


    touch "${LOCK_FILE}"
fi

init_configuration
init_vhosts
service apache2 start

tail -f /dev/null
