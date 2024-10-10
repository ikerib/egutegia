#!/bin/bash

APP = ikerib/egutegia
VERSION := $(shell date +%Y-%m-%d)
DOCKER_TAG_DATE = ${APP}:${VERSION}
DOCKER_TAG_LATEST = ${APP}:latest
USER_ID = $(shell id -u)
GROUP_ID= $(shell id -g)
user==www-data

help:
	@echo 'usage: make [target]'
	@echo
	@echo 'targets'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ":#"

build: ## build
	docker compose --env-file .env.local build

build-force:
	docker compose --env-file .env.local build --force-rm --no-cache

restart:
	$(MAKE) stop && $(MAKE) run

run: ## run
	USER_ID=${USER_ID} GROUP_ID=${GROUP_ID} docker compose --env-file .env.local up -d

stop:
	docker compose down

ssh:
	docker compose exec app bash

prod: ## build imge
	docker build -t ${DOCKER_TAG_DATE} -t ${DOCKER_TAG_LATEST} -f docker/prod/Dockerfile .
	@echo ${VERSION} > VERSION
	@sed -i "s/^VERSION=.*/VERSION=${VERSION}/" .env || echo "VERSION=${VERSION}" >> .env
	@sed -i "s/^VERSION=.*/VERSION=${VERSION}/" .env.local || echo "VERSION=${VERSION}" >> .env.local

push: ## push docker image to registry
	docker push ${DOCKER_TAG_DATE}
	docker push ${DOCKER_TAG_LATEST}
