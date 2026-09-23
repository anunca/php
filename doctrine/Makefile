.PHONY: help
.DEFAULT_GOAL := help

include .env.local
-include .env

export

ENV ?= dev
TAG ?= ${ENV}
DOCKER_SHELL ?= sh

dc = docker compose -f compose.yml -f compose.$(ENV).yml

help h: ## Show help
	@awk 'BEGIN {FS = ":.*##"} /^[a-zA-Z0-9_. -]+:.*##/ {split($$1,a," "); printf "%-20s %s\n",a[1],$$2}' $(MAKEFILE_LIST)

##@ Docker
config c: ## Show config
	$(dc) config

build b: ## Build images
	$(dc) build

start s: ## Start containers
	$(dc) up -d

stop st: ## Stop containers
	$(dc) down -t0

restart r: stop start ## Restart

run: ## Run shell
	$(dc) run --rm --entrypoint $(DOCKER_SHELL) app

shell sh: ## Exec shell
	$(dc) exec app $(DOCKER_SHELL)

logs l: ## Follow logs
	$(dc) logs -f

ps: ## List containers
	$(dc) ps -a

clean: ## Remove containers and volumes
	$(dc) down -t0 --volumes --remove-orphans

##@ Composer
composer.install: ## Install
	$(dc) run --rm php composer install

##@ DB
db.create.dump: ## DB create dump
	$(dc) exec app sh -c 'php doctrine orm:schema-tool:create --dump-sql'

db.create: ## DB create
	$(dc) exec app sh -c 'php doctrine orm:schema-tool:create'

db.drop.dump: ## DB drop dump
	$(dc) exec app sh -c 'php doctrine orm:schema-tool:drop --dump-sql'

db.drop: ## DB drop
	$(dc) exec app sh -c 'php doctrine orm:schema-tool:drop --force'

db.info: ## DB info
	$(dc) exec app sh -c 'php doctrine orm:info'

db.update.dump: ## DB update dump
	$(dc) exec app sh -c 'php doctrine orm:schema-tool:update --dump-sql'

db.update: ## DB update
	$(dc) exec app sh -c 'php doctrine orm:schema-tool:update'	