DOCKER = docker
DOCKER_COMPOSE = docker compose
DOCKER_PHP = php

# Containers
DOCKER_RUN = docker run -it --rm --init -v "$(PWD)/:/var/www/html" -w /var/www/html

.DEFAULT_GOAL := help

## —— Help 💡 ——————————————————————————————————————————————————————————————————
.PHONY: help
help: ## Show helps
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
.PHONY: up
up: ## Start all containers
	$(DOCKER_COMPOSE) up -d

.PHONY: stop
stop: ## Stop all containers
	$(DOCKER_COMPOSE) stop

.PHONY: down
down: ## Down containers
	$(DOCKER_COMPOSE) down

.PHONY: build-php
build-php: ## Build php container
	$(DOCKER_COMPOSE) build $(DOCKER_COMPOSE_PHP)

.PHONY: php
php: ## Open a shell in php container
	$(DOCKER_COMPOSE) exec $(DOCKER_PHP) /bin/bash

## —— Install & Build & Test ————————————————————————————————————————————————————————————————
.PHONY: composer-install
composer-install: ## Run composer install in php container
	$(DOCKER_COMPOSE) exec $(DOCKER_PHP) composer install
	$(DOCKER_COMPOSE) exec $(DOCKER_PHP) php bin/console assets:install

.PHONY: make-migration
make-migration: ## Create migration from diff
	$(DOCKER_COMPOSE) exec $(DOCKER_PHP) php bin/console make:migration

.PHONY: exec-migration
exec-migration: ## Execute migration in php container
	$(DOCKER_COMPOSE) exec $(DOCKER_PHP) php bin/console doctrine:migrations:migrate

.PHONY: exec-migration-diff
exec-migration-diff: ## Execute migration in php container
	$(DOCKER_COMPOSE) exec $(DOCKER_PHP) php bin/console doctrine:migrations:diff

.PHONY: prev-migration
prev-migration: ## Rollback previous migration in php container
	$(DOCKER_COMPOSE) exec $(DOCKER_PHP) php bin/console doctrine:migrations:migrate prev

.PHONY: assets-install
assets-install: ## Run assets:install in php container
	$(DOCKER_COMPOSE) exec $(DOCKER_PHP) php bin/console assets:install

.PHONY: cc
cc: ## Run cache:clear in php container
	$(DOCKER_COMPOSE) exec $(DOCKER_PHP) php bin/console cache:clear

.PHONY: wa
wa: ## Run cache:warmup in php container
	$(DOCKER_COMPOSE) exec $(DOCKER_PHP) php bin/console cache:wa

.PHONY: yarn-build
yarn-build: ## Run build assets in php container
	$(DOCKER_COMPOSE) exec $(DOCKER_PHP) yarn run build

.PHONY: restart-worker
restart-worker: ## Restart rabbitmq worker
	$(DOCKER_COMPOSE) exec $(DOCKER_PHP) php bin/console messenger:stop-workers

.PHONY: restart-worker-long
restart-worker-long: ## Restart rabbitmq worker-long
	$(DOCKER_COMPOSE) exec $(DOCKER_COMPOSE_WORKER_LONG) php bin/console messenger:stop-workers

## —— PlateformSH 🚀 ———————————————————————————————————————————————————————————
.PHONY: ssh
ssh: ## Open an ssh connection in prod environment
	symfony cloud:ssh -p shdr3bih7uelg -e master -A dynabuy

.PHONY: ssh-develop
ssh-develop: ## Open an ssh connection in develop environment
	symfony cloud:ssh -p shdr3bih7uelg -e develop -A dynabuy

.PHONY: ssh-release
ssh-release: ## Open an ssh connection in release environment
	symfony cloud:ssh -p shdr3bih7uelg -e release -A dynabuy
