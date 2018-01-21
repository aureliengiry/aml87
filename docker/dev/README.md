Docker for LAMP Server [![Build Status](https://travis-ci.org/aureliengiry/docker-lamp-server.svg?branch=master)](https://travis-ci.org/aureliengiry/docker-lamp-server)
======================

## Architecture

Here are the environment containers:

* `web`: This is the Apache/PHP server container (in which the application volume is mounted),
* `mysql`: This is the MySQL (mariaDB) server container
* `blackfire`: This is the Blackfire container (used for profiling the application).
* `nodejs`: This is the Node JS container.
* `mailcatcher`: This is the mailcatcher container (used for email testing, web interface is accessible on http://127.0.0.1:1080).
* `rabbitmq`: This is the rabbitmq container (web interface is accessible on http://127.0.0.1:15672).
