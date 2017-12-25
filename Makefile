FIG=docker-compose
RUN=$(FIG) run --rm app
EXEC=$(FIG) exec app
CONSOLE=bin/console

.DEFAULT_GOAL := help
.PHONY: help start stop reset db db-diff db-migrate db-rollback db-load watch clear clean test tu tf tj lint ls ly lt lj build up perm deps cc

help:
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'


##
## Project setup
##---------------------------------------------------------------------------

init:          ## Install and start the project
init: up

start:         ## Start project
start: docker-start

stop:          ## Stop project
stop: docker-stop

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
	-$(EXEC) chmod -R 777 var

# Rules from files

vendor: composer.lock
	@$(RUN) composer install

composer.lock: composer.json
	@echo compose.lock is not up to date.

app/config/parameters.yml: app/config/parameters.yml.dist
	@$(RUN) composer run-script post-install-cmd

node_modules: yarn.lock
	@$(RUN) yarn install

yarn.lock: package.json
	@echo yarn.lock is not up to date.

web/built: front node_modules
	@$(RUN) yarn build-dev
