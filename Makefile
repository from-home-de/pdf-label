.SILENT:
.PHONY: help

# Based on https://gist.github.com/prwhite/8168133#comment-1313022

## This help screen
help:
	printf "Available commands\n\n"
	awk '/^[a-zA-Z\-\_0-9]+:/ { \
		helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")-1); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			printf "\033[33m%-40s\033[0m %s\n", helpCommand, helpMessage; \
		} \
	} \
	{ lastLine = $$0 }' $(MAKEFILE_LIST)

PROJECT = cdn
STAGE = development
DOCKER_COMPOSE_OPTIONS = -p $(PROJECT) -f docker-compose.$(STAGE).yml
DOCKER_COMPOSE_UP_SCALE_OPTIONS = --scale nginx=1
DOCKER_COMPOSE_BASE_COMMAND = CURRENT_UID="$$(id -u):$$(id -g)" docker-compose $(DOCKER_COMPOSE_OPTIONS)
DOCKER_COMPOSE_RUN_COMMAND = $(DOCKER_COMPOSE_BASE_COMMAND) run --rm
DOCKER_COMPOSE_ISOLATED_RUN_COMMAND = $(DOCKER_COMPOSE_BASE_COMMAND) run --rm --no-deps

## Install setup
install: dcvalidate dcbuild dcpull dcup
.PHONY: install

## Update setup
update: dcvalidate dcbuild dcpull dcup
.PHONY: update

## Build all containers
dcbuild:
	COMPOSE_DOCKER_CLI_BUILD=1 \
	DOCKER_BUILDKIT=1 \
	$(DOCKER_COMPOSE_BASE_COMMAND) build --pull --parallel
.PHONY: dcbuild

## Pull all containers
dcpull:
	$(DOCKER_COMPOSE_BASE_COMMAND) pull
.PHONY: dcpull

## Run docker-compose file validation
dcvalidate:
	$(DOCKER_COMPOSE_BASE_COMMAND) config -q
.PHONY: dcvalidate

## Bring up docker-compose setup
dcup:
	$(DOCKER_COMPOSE_BASE_COMMAND) up $(DOCKER_COMPOSE_UP_SCALE_OPTIONS) -d --force-recreate
.PHONY: dcup

## Bring up docker-compose down
dcdown:
	$(DOCKER_COMPOSE_BASE_COMMAND) down --remove-orphans
.PHONY: dcdown

## Show docker compose setup status
dcps:
	$(DOCKER_COMPOSE_BASE_COMMAND) ps
.PHONY: dcps

## Show docker compose setup images
dcimages:
	$(DOCKER_COMPOSE_BASE_COMMAND) images
.PHONY: dcimages