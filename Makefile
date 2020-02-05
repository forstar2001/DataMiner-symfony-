#!make
override UNIVERSE_ENVIRONMENT=$(shell echo $${UNIVERSE_ENVIRONMENT})

ifeq ($(filter $(UNIVERSE_ENVIRONMENT),dev prod),)
    $(error UNIVERSE_ENVIRONMENT is missing or not valid.)
endif

ifneq ($(findstring $(firstword $(MAKECMDGOALS)),logs composer console),)
    ARGV:=$(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS)); \
    $(eval $(ARGV):;@:)
endif

ifneq ($(findstring $(firstword $(MAKECMDGOALS)),shell restart),)
    ARGV:=$(wordlist 3,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS)); \
    $(eval $(ARGV):;@:)
endif

ifneq ($(findstring $(firstword $(MAKECMDGOALS)),shell restart),)
ifeq ($(strip $(word 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))),)
    $(error Service does not exists.)
endif
endif

override __SERVICE_NAME__=$(shell basename $(shell dirname $(realpath $(firstword $(MAKEFILE_LIST))))_$(1))
override __POSTGRES_DSN__=$(shell echo $(DATABASE_URL) | sed 's/\(.*\):\/\/\(.*\):\(.*\)@\(.*\)\/\(.*\)/\$(1)/')
override __DOCKER__=$(shell echo docker $(1))
override __DOCKER_COMPOSE__=$(shell echo docker-compose -f docker-compose.yml -f docker/docker-compose.base.yml -f docker/docker-compose.$(UNIVERSE_ENVIRONMENT).yml $(1) $(ARGV))
override __DOCKER_COMPOSE_EXEC__=$(call __DOCKER_COMPOSE__,exec --user $(UNIVERSE_USER) $(1) $(2))
override __INSTALL__=$(shell install $(1) $(2))
override __VIM__=$(shell vi $(1))

export UNIVERSE_USER=$(shell id -u):$(shell id -g)
export UNIVERSE_POSTGRES_DB=$(call __POSTGRES_DSN__,5)
export UNIVERSE_POSTGRES_USER=$(call __POSTGRES_DSN__,2)
export UNIVERSE_POSTGRES_PASSWORD=$(call __POSTGRES_DSN__,3)

ifeq ($(findstring $(firstword $(MAKECMDGOALS)),.env.local),)
ifeq ($(wildcard .env.local),)
    $(error .env.local is missing or not valid. Run `make .env.local`)
endif
endif

include .env $(addsuffix .$(UNIVERSE_ENVIRONMENT),.env) $(realpath .env.local)
export $(shell sed 's/=.*//' .env $(addsuffix .$(UNIVERSE_ENVIRONMENT),.env) $(realpath .env.local))

.env.local:
	$(call __INSTALL__,$(addsuffix -dist,$@),$@)
	$(call __VIM__,$@ <$$(tty) >$$(tty))

config:
	$(call __DOCKER_COMPOSE__,config)

up:
	$(call __DOCKER_COMPOSE__,up -d --build --force-recreate)

down:
	$(call __DOCKER_COMPOSE__,down --rmi all --volumes --remove-orphans)

ps:
	$(call __DOCKER_COMPOSE__,ps)

logs:
	$(call __DOCKER_COMPOSE__,logs)

composer:
	$(call __DOCKER_COMPOSE_EXEC__,$(call __SERVICE_NAME__,php-fpm) composer)

console:
	$(call __DOCKER_COMPOSE_EXEC__,$(call __SERVICE_NAME__,php-fpm) bin/console)

shell:
	$(call __DOCKER_COMPOSE_EXEC__,$(call __SERVICE_NAME__,$(word 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))) ash)

restart:
	$(call __DOCKER_COMPOSE__,restart $(call __SERVICE_NAME__,$(word 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))))

pause:
	$(call __DOCKER_COMPOSE__,pause)

unpause:
	$(call __DOCKER_COMPOSE__,unpause)

top:
	$(call __DOCKER_COMPOSE__,top)

df:
	$(call __DOCKER__,system df)

prune: df .confirm
	$(call __DOCKER__,system prune --all --volumes --force)

.confirm:
	@echo -n "\nAre you sure? [y/N] " && read t && [ $${t:-N} = y ]

.SILENT: config up down ps logs composer console shell restart pause unpause top df prune .confirm

.PHONY: config
