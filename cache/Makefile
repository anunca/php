.PHONY: help
.DEFAULT_GOAL := help

include .env.local
-include .env

export

ENV ?= dev
TAG ?= ${ENV}
DOCKER_SHELL ?= sh

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
	$(dc) run --rm --entrypoint $(DOCKER_SHELL) app1

shell sh: ## Exec shell
	$(dc) exec app1 $(DOCKER_SHELL)

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

##@ Redis
redis.sh: ## Shell
	$(dc) exec redis redis-cli

redis.flushall: ## Flushall
	$(dc) exec redis redis-cli FLUSHALL