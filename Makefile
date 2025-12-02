DEV_SETUP_PATH := dev_env
COMPOSE_FILE := $(shell realpath $(DEV_SETUP_PATH)/docker-compose.base.yml)
ENV_FILE := $(shell pwd)/.env

COMPOSE := docker compose --env-file $(ENV_FILE) -f $(COMPOSE_FILE)

# Tells make this is not a file, just a command to always run
.PHONY: up down logs shell db-shell format clean-volumes clean-images

up:
	$(COMPOSE) up --build -d

down:
	$(COMPOSE) down

install-dependancies:
	$(COMPOSE) exec php composer install

logs:
	$(COMPOSE) logs -f php

shell:
	$(COMPOSE) exec php sh

db-shell:
	$(COMPOSE) exec db \
    sh -c 'mysql -u$$MYSQL_USER -p$$MYSQL_PASSWORD $$MYSQL_DATABASE'

format:
	$(COMPOSE) exec php pretty-php src/
	$(COMPOSE) exec php php-cs-fixer fix --config=.php-cs-fixer.php --allow-risky=yes

pre-commit:
	pre-commit run --all-files

clean-volumes:
	$(COMPOSE) down -v

clean-images:
	$(COMPOSE) down --rmi all -v
