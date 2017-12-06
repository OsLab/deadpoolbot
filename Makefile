DC=docker-compose

.DEFAULT_GOAL := help
.PHONY: help start stop restart bash logs

help:
	@echo ''
	@echo ''
	@echo '                            ci-bot project'
	@echo '                            --------------'
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'
	@echo ''
	@echo '---------------------------------------------------------------------------'
	@echo ''

## Setup
##---------------------------------------------------------------------------
install:        ## Install and start the project
install: up vendor info

##
## Provisioning
##---------------------------------------------------------------------------
start:          ## start the project
start: up info

stop:           ## Stop docker containers
	$(DC) down

restart:        ## Restart the whole project
restart: stop start info

bash:           ## Switch to the bash App container of the application
	@$(DC) exec app bash

logs:           ## Show container logs
	@$(DC) logs --follow app

# Internal rules

up:
	$(DC) up -d --remove-orphans

vendor: composer.lock
	@$(DC) exec app composer install

info:
	@echo ""
	@echo "\033[92m[OK] Application running on https://localhost:8000\033[0m"
	@echo ""
