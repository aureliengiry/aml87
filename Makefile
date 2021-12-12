
EXEC_WEB=docker-compose exec web
EXEC_NODEJS=docker-compose exec nodejs
EXEC_MYSQL=docker-compose exec mysql

PROJECT_PATH=/var/www/aml87
SYMFONY_CONSOLE="$(PROJECT_PATH)/bin/console"

##
## ----------------------------------------------------------------------------
##   Project setup
## ----------------------------------------------------------------------------
##

apache-restart: ## Restart apache of web container
	$(EXEC_WEB) service apache2 restart

git-hooks-install: ## Install/update hooks
	cp hooks/pre-commit.sh .git/hooks/pre-commit
	chmod 755 .git/hooks/pre-commit

project-update: ## Start all process to update project. Ex: make project-update
	make composer-install sf-cc yarn-install assets-compile-dev apache-restart git-hooks-install

project-upgrade: ## Start all process to update project. Ex: make project-upgrade
	make composer-update sf-cc yarn-upgrade assets-compile-dev apache-restart git-hooks-install

.PHONY: apache-restart git-hooks-install project-update project-upgrade

##
## ----------------------------------------------------------------------------
##   Docker
## ----------------------------------------------------------------------------
##

docker-init: ## Build and start docker of Relight
	docker-compose up -d --remove-orphans && docker-compose logs

docker-build: ## Build the project from latest images and without cache but don't start containers
	docker-compose build --no-cache --pull

docker-start: ## Start docker
	docker-compose start

docker-stop: ## Stop docker
	docker-compose stop

docker-restart: ## Restart project
	docker-compose restart

docker-ps: ## List all containers
	docker-compose ps

docker-stats: ## Print real-time statistics about containers ressources usage
	docker stats $(docker ps --format={{.Names}})

docker-logs: ## Follow logs generated by all containers
	docker-compose logs -f --tail=0

docker-logs-full: ## Follow logs generated by all containers from the containers creation
	docker-compose logs -f

.PHONY: docker-init docker-build docker-start docker-stop docker-restart docker-ps docker-stats docker-logs docker-logs-full

##
## ----------------------------------------------------------------------------
##   Shell for each docker container
## ----------------------------------------------------------------------------
##

web-shell: ## Shell of container web_php
	$(EXEC_WEB) /bin/bash

nodejs-shell: ## Shell of nodejs container
	$(EXEC_NODEJS) /bin/bash

mysql-shell: ## Shell of mysql container
	$(EXEC_MYSQL) /bin/bash

.PHONY: web-shell nodejs-shell mysql-shell

##
## ----------------------------------------------------------------------------
##   Yarn
## ----------------------------------------------------------------------------
##

yarn-install: ## Install Javascript dependencies in node_modules directory.
	$(EXEC_NODEJS) /bin/bash -c "cd $(PROJECT_PATH) && yarn install"

yarn-install-prod: ## Install Javascript dependencies for production in node_modules directory.
	$(EXEC_NODEJS) /bin/bash -c "cd $(PROJECT_PATH) && yarn install --prod"

yarn-install-force: ## Install Javascript dependencies in node_modules directory with force mode.
	$(EXEC_NODEJS) /bin/bash -c "cd $(PROJECT_PATH) && yarn install --force"

yarn-upgrade: ## Update Javascript dependencies in node_modules directory.
	$(EXEC_NODEJS) /bin/bash -c "cd $(PROJECT_PATH) && yarn upgrade"

yarn-add: ## add Javascript dependencies. Ex: make yarn-add PACKAGE=react
	$(EXEC_NODEJS) /bin/bash -c "cd $(PROJECT_PATH) && yarn add $(PACKAGE)"

yarn-add-dev: ## add Javascript dependencies for dev. Ex: make yarn-add-dev PACKAGE=react
	$(EXEC_NODEJS) /bin/bash -c "cd $(PROJECT_PATH) && yarn add --dev $(PACKAGE)"

yarn-test: ## start testing suite with jest. Ex: make yarn-test
	$(EXEC_NODEJS) /bin/bash -c "cd $(PROJECT_PATH) && yarn test $(PACKAGE)"

.PHONY: yarn-install yarn-install-prod yarn-install-force yarn-upgrade yarn-add yarn-add-dev yarn-test

##
## ----------------------------------------------------------------------------
##   Assets
## ----------------------------------------------------------------------------
##

assets-compile-dev: yarn-install ## Compile assets for dev
	$(EXEC_NODEJS) /bin/bash -c "cd $(PROJECT_PATH) && yarn run encore dev"

assets-compile-dev-watch: ## Compile assets for dev with watch mode
	$(EXEC_NODEJS) /bin/bash -c "cd $(PROJECT_PATH) && yarn run encore dev --watch"

assets-compile-prod: yarn-install-prod ## Compile assets for prod
	$(EXEC_NODEJS) /bin/bash -c "cd $(PROJECT_PATH) && yarn run encore production"

.PHONY: assets-compile-dev assets-compile-dev-watch assets-compile-prod

##
## ----------------------------------------------------------------------------
##   Symfony
## ----------------------------------------------------------------------------
##

sf-list:      ## Get command list
	@$(EXEC_WEB) $(SYMFONY_CONSOLE)

sf-cc:        ## Clear the cache in dev env
	$(EXEC_WEB) php -d memory_limit=-1 $(SYMFONY_CONSOLE) cache:clear --no-warmup
	$(EXEC_WEB) php -d memory_limit=-1 $(SYMFONY_CONSOLE) cache:warmup
	make sf-fix-rights

sf-fix-rights:        ## Clear the cache in dev env
	$(EXEC_WEB) chmod -R 777 $(PROJECT_PATH)/var/log
	$(EXEC_WEB) chmod -R 777 $(PROJECT_PATH)/var/sessions
	$(EXEC_WEB) chmod -R 777 $(PROJECT_PATH)/var/cache

sf-db-migrate:      ## Migrate database schema to the latest available version. Ex: make sf-db-migrate
	$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:migrations:migrate -n

.PHONY: sf-list sf-cc sf-fix-rights sf-db-migrate

##
## ----------------------------------------------------------------------------
##   Composer
## ----------------------------------------------------------------------------
##

composer-install: ## Install PHP dependencies in vendor directory.
	$(EXEC_WEB) /bin/bash -c "cd $(PROJECT_PATH) && php -d memory_limit=-1 /usr/bin/composer install"

composer-remove: ## Update PHP dependencies in vendor directory. Ex: make composer-require PACKAGE=symfony/serializer
	$(EXEC_WEB) /bin/bash -c "cd $(PROJECT_PATH) && php -d memory_limit=-1 /usr/bin/composer remove $(PACKAGE)"

composer-require: ## Update PHP dependencies in vendor directory. Ex: make composer-require PACKAGE=symfony/serializer
	$(EXEC_WEB) /bin/bash -c "cd $(PROJECT_PATH) && php -d memory_limit=-1 /usr/bin/composer require $(PACKAGE)"

composer-require-dev: ## Update PHP dependencies for dev in vendor directory. Ex: make composer-require-dev PACKAGE=symfony/serializer
	$(EXEC_WEB) /bin/bash -c "cd $(PROJECT_PATH) && php -d memory_limit=-1 /usr/bin/composer require --dev $(PACKAGE)"

composer-update:    ## Update PHP dependencies in vendor directory.
	$(EXEC_WEB) /bin/bash -c "cd $(PROJECT_PATH) && php -d memory_limit=-1 /usr/bin/composer update"
	make yarn-install-force

.PHONY: composer-install composer-remove composer-require composer-require-dev composer-update

##
## ----------------------------------------------------------------------------
##   Database
## ----------------------------------------------------------------------------
##

db-init-dev:        ## Init Database, fixtures for dev
	-$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:database:drop --force --env=dev
	-$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:database:create --env=dev
	-$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:schema:update --force --env=dev
	-$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:fixtures:load --env=dev -n

db-init-dev-without-docker:        ## Init Database, fixtures for dev without docker
	-bin/console doctrine:database:drop --force --env=dev
	-bin/console doctrine:database:create --env=dev
	-bin/console doctrine:schema:update --force --env=dev
	-bin/console doctrine:fixtures:load --env=dev -n

.PHONY: db-init-dev db-init-dev-without-docker

##
## ----------------------------------------------------------------------------
##   Tests
## ----------------------------------------------------------------------------
##

tests-init:        ## Init Database, fixtures for the PHP unit tests
tests-init: vendor
	-$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:database:drop --force --env=test
	-$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:database:create --env=test
	-$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:schema:update --force --env=test
	-$(EXEC_WEB) $(SYMFONY_CONSOLE) doctrine:fixtures:load --env=test -n

tests-ut:             ## Run the phpunit on unit tests and exclude functional tests
	$(EXEC_WEB) /bin/bash -c "cd $(PROJECT_PATH) && php -d memory_limit=-1 bin/phpunit --exclude-group functional"

tests-functional:  ## Run the phpunit on functionnal tests
	$(EXEC_WEB) /bin/bash -c "cd $(PROJECT_PATH) && php -d memory_limit=-1 bin/phpunit --group functional"

.PHONY: tests-init tests-ut tests-functional

##
## ----------------------------------------------------------------------------
##   Tools
## ----------------------------------------------------------------------------
##
phpstan-complete: ## PHPStan - PHP Static Analysis Tool (Analyse all files in src/*)
	$(EXEC_WEB) /bin/bash -c "cd $(PROJECT_PATH) && php -d memory_limit=-1 /usr/bin/composer phpstan"

phpstan-general: ## PHPStan - PHP Static Analysis Tool (Analyse all files in src/*)
	$(EXEC_WEB) /bin/bash -c "cd $(PROJECT_PATH) && php -d memory_limit=-1 vendor/bin/phpstan analyse -c phpstan.neon src --level 7"

phpstan-tests: ## PHPStan - PHP Static Analysis Tool (Analyse all files in tests/*)
	$(EXEC_WEB) /bin/bash -c "cd $(PROJECT_PATH) && php -d memory_limit=-1 vendor/bin/phpstan analyse -c phpstan-tests.neon tests --level 7"

phpstan-diff: ## PHPStan analyse diff files with master (Analyse all updated php files)
	$(EXEC_WEB) /bin/bash -c "cd $(PROJECT_PATH) && php -d memory_limit=-1 vendor/bin/phpstan analyse --level 7 \`git diff --name-only master... '*.php' \`"

php-cs-fixer-dry-run:   ## PHP Code Style Fixer in dry-run mode
	$(EXEC_WEB) /bin/bash -c "cd $(PROJECT_PATH) && vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php -v --dry-run --allow-risky=yes"

php-cs-fixer:           ## PHP Code Style Fixer
	$(EXEC_WEB) /bin/bash -c "cd $(PROJECT_PATH) && vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php -v --allow-risky=yes"

eslint: yarn-install  ## Lint Javascript files
	$(EXEC_NODEJS) /bin/bash -c "cd $(PROJECT_PATH) && ./node_modules/.bin/eslint assets/js webpack.config.js"

eslint-fix: yarn-install ## Lint Javascript files and fix them
	$(EXEC_NODEJS) /bin/bash -c "cd $(PROJECT_PATH) && ./node_modules/.bin/eslint --fix assets/js webpack.config.js"

ssl-certificate-create:  ## Create self-signed certificate
	$(EXEC_WEB) /bin/bash -c "openssl req -new -x509 -days 365 -keyout /etc/apache2/ssl/key/aml87.key -out /etc/apache2/ssl/crt/aml87.crt -nodes -subj '/O=AML87/OU=AML87/CN=www.aml87.local'"

# Rules from files
vendor: composer.lock
	@$(EXEC_WEB) composer install -d $(PROJECT_PATH)

composer.lock: composer.json
	@echo compose.lock is not up to date.

node_modules: yarn.lock
	@$(RUN_NODEJS) yarn install

yarn.lock: package.json
	@echo yarn.lock is not up to date.

web/built: front node_modules
	@$(RUN_NODEJS) yarn build-dev

.DEFAULT_GOAL := help
.PHONY: help
help: ## Show this help
	@egrep -h '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) \
		| awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' \
		| sed -e 's/\[32m##/[33m/'
