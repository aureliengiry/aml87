FIG=docker-compose
RUN_WEB=$(FIG) run --rm web
RUN_NODEJS=$(FIG) run --rm nodejs
CONSOLE=bin/console

EXEC_WEB=$(FIG) exec web
EXEC_NODEJS=$(FIG) exec nodejs
EXEC_MYSQL=$(FIG) exec mysql

PROJECT_PATH=/var/www/aml87
SYMFONY_CONSOLE="$(PROJECT_PATH)/bin/console"

.DEFAULT_GOAL := help
.PHONY: help start stop reset db db-diff db-migrate db-rollback db-load watch clear clean test tu tf tj lint ls ly lt lj build up perm deps cc sf-list

help:
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'


##
## Project setup
##---------------------------------------------------------------------------

docker-init:          ## Init and start docker of Relight & Dimipro
docker-init: up

docker-start:         ## Start docker
docker-start: docker-start

docker-stop:          ## Stop docker
docker-stop: docker-stop

docker-restart:       ## Restart project
docker-restart: docker-stop docker-start

apache-restart:       ## Restart apache of web container
apache-restart:
	$(EXEC_WEB) service apache2 restart

##
## Shell by container
##---------------------------------------------------------------------------

web-shell:            ## Shell of web container
web-shell:
	$(EXEC_WEB) /bin/bash

nodejs-shell:         ## Shell of nodejs container
nodejs-shell:
	$(EXEC_NODEJS) /bin/bash

mysql-shell:          ## Shell of mysql container
mysql-shell:
	$(EXEC_MYSQL) /bin/bash

##
## Assets
##---------------------------------------------------------------------------
assets-compile-dev:   ## Compile assets for dev
assets-compile-dev:
	$(EXEC_NODEJS) $(PROJECT_PATH)/node_modules/.bin/encore dev

##
## Symfony
##---------------------------------------------------------------------------

sf-list:      ## Get command list
sf-list:
	@$(EXEC_WEB) $(SYMFONY_CONSOLE)

sf-cc:        ## Clear the cache in dev env
sf-cc:
	@$(EXEC_WEB) $(SYMFONY_CONSOLE) cache:clear --no-warmup
	@$(EXEC_WEB) $(SYMFONY_CONSOLE) cache:warmup

##
## Tests
##---------------------------------------------------------------------------

tu-init:        ## Init Database, fixtures for the PHP unit tests
tu-init: vendor
	-$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:database:drop --force --env=test
	-$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:database:create --env=test
	-$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:schema:update --force --env=test

tu:             ## Run the PHP unit tests
tu:
	$(EXEC_WEB) phpunit $(PROJECT_PATH)

##
## Dependencies
##---------------------------------------------------------------------------

deps:           ## Install the project PHP and JS dependencies
deps: vendor

# Internal rules

build:
	$(FIG) build

up:
	$(FIG) up -d && $(FIG) logs

docker-start:
	$(FIG) start

docker-stop:
	$(FIG) stop

perm:
	-$(EXEC_WEB) chmod -R 777 $(PROJECT_PATH)/var

# Rules from files

vendor: composer.lock
	@$(EXEC_WEB) composer install -d $(PROJECT_PATH)

composer.lock: composer.json
	@echo compose.lock is not up to date.

app/config/parameters.yml: app/config/parameters.yml.dist
	@$(RUN_WEB) composer -d $(PROJECT_PATH) run-script post-install-cmd

node_modules: yarn.lock
	@$(RUN_NODEJS) yarn install

yarn.lock: package.json
	@echo yarn.lock is not up to date.

web/built: front node_modules
	@$(RUN_NODEJS) yarn build-dev
