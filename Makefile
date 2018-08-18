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
docker-init: docker-cmd-up

docker-start:         ## Start docker
docker-start: docker-cmd-start

docker-stop:          ## Stop docker
docker-stop: docker-cmd-stop

docker-restart:       ## Restart project
docker-restart: docker-cmd-stop docker-cmd-start

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
assets-compile-dev:         ## Compile assets for dev
assets-compile-dev:
	$(EXEC_NODEJS) /bin/bash -c "cd $(PROJECT_PATH) && yarn run encore dev"

assets-compile-dev-watch:   ## Compile assets for dev with watch mode
assets-compile-dev-watch:
	$(EXEC_NODEJS) /bin/bash -c "cd $(PROJECT_PATH) && yarn run encore dev --watch"

assets-compile-prod:        ## Compile assets for prod
assets-compile-prod:
	$(EXEC_NODEJS) /bin/bash -c "cd $(PROJECT_PATH) && yarn run encore production"

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

composer-install:   ## Install vendor
composer-install:
	$(EXEC_WEB) /bin/bash -c "cd $(PROJECT_PATH) && php -d memory_limit=-1 /usr/local/bin/composer install -o"

composer-update:    ## Update vendor
composer-update:
	$(EXEC_WEB) /bin/bash -c "cd $(PROJECT_PATH) && php -d memory_limit=-1 /usr/local/bin/composer update -o"

##
## Database
##---------------------------------------------------------------------------

db-init-dev:        ## Init Database, fixtures for dev
db-init-dev: vendor
	-$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:database:drop --force --env=dev
	-$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:database:create --env=dev
	-$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:schema:update --force --env=dev
	-$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:fixtures:load --env=dev -n


##
## Tests
##---------------------------------------------------------------------------

tests-init:        ## Init Database, fixtures for the PHP unit tests
tests-init: vendor
	-$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:database:drop --force --env=test
	-$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:database:create --env=test
	-$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:schema:update --force --env=test
	-$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:fixtures:load --env=test -n

tests-ut:             ## Run the phpunit on unit tests and exclude functional tests
tests-ut:
	$(EXEC_WEB) /bin/bash -c "cd $(PROJECT_PATH) && php -d memory_limit=-1 vendor/bin/phpunit --exclude-group functional"

tests-functional:  ## Run the phpunit on functionnal tests
tests-functional:
	$(EXEC_WEB) /bin/bash -c "cd $(PROJECT_PATH) && php -d memory_limit=-1 vendor/bin/phpunit --group functional"

##
## Dependencies
##---------------------------------------------------------------------------

deps:           ## Install the project PHP and JS dependencies
deps: vendor

##
## Tools
##---------------------------------------------------------------------------
phpstan:			## PHPStan - PHP Static Analysis Tool
phpstan:
	$(EXEC_WEB) /bin/bash -c "cd $(PROJECT_PATH) && php -d memory_limit=-1 vendor/bin/phpstan.phar analyse src tests"

php-cs-fixer-dry-run:   ## PHP Code Style Fixer in dry-run mode
php-cs-fixer-dry-run:
	 $(EXEC_WEB) /bin/bash -c "cd $(SITE_PATH) && vendor/bin/php-cs-fixer fix --config=.php_cs -v --dry-run --allow-risky=yes"

php-cs-fixer:           ## PHP Code Style Fixer
php-cs-fixer:
	 $(EXEC_WEB) /bin/bash -c "cd $(SITE_PATH) && vendor/bin/php-cs-fixer fix --config=.php_cs -v --allow-risky=yes"


# Internal rules

build:
	$(FIG) build

docker-cmd-up:
	$(FIG) up -d && $(FIG) logs

docker-cmd-start:
	$(FIG) start

docker-cmd-stop:
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
