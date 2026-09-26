.PHONY: help config build start stop restart run shell logs ps smoke clean
.DEFAULT_GOAL := help

include .env.local
-include .env

export

ENV ?= dev
TAG ?= ${ENV}
DOCKER_SHELL ?= bash

dc_files = compose.yml

ifeq ($(ENV),prod)
	dc_files += compose.prod.yml
else
	dc_files += compose.dev.yml
endif

# Cache adapter
ifeq ($(CACHE_ADAPTER),redis)
	ifeq ($(ENV),prod)
		dc_files += compose.redis.prod.yml
	else
		dc_files += compose.redis.yml
	endif
else ifeq ($(CACHE_ADAPTER),memcached)
	dc_files += compose.memcached.yml
endif

# HAProxy (always added when cache adapter is used)
ifneq ($(CACHE_ADAPTER),)
	ifeq ($(ENV),prod)
		dc_files += compose.haproxy.yml compose.haproxy.prod.yml
	else
		dc_files += compose.haproxy.yml compose.haproxy.dev.yml
	endif
endif

dc = docker compose $(foreach f,$(dc_files),-f $(f))

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

sh.app2: ## Exec shell
	$(dc) exec app2 $(DOCKER_SHELL)

sh.app3: ## Exec shell
	$(dc) exec app3 $(DOCKER_SHELL)

##@ Composer
composer.install ci: ## Run composer install
	$(dc) run --rm app composer install

composer.fund cf: ## Run composer fund
	$(dc) run --rm app composer fund

composer.update cu: ## Run composer update
	$(dc) run --rm app composer update

composer.remove cr: ## Remove vendor directory
	$(dc) run --rm app rm -rf vendor

##@ Redis
redis.sh: ## Shell
	$(dc) exec redis redis-cli

redis.flushall: ## Flushall
	$(dc) exec redis redis-cli FLUSHALL

##@ Test
smoke: ## Verify HTTP application readiness
	@for attempt in $$(seq 1 30); do \
		if curl --fail --silent --show-error http://localhost/ >/dev/null; then exit 0; fi; \
		sleep 2; \
	done; \
	$(MAKE) ps; \
	$(MAKE) logs || true; \
	exit 1
