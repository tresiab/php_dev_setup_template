#!/bin/sh
# Ensure script is executable
# chmod +x docker-php-cs-fixer.sh

# Run PHP-CS-Fixer in Docker on the project root
docker compose -f dev_env/docker-compose.base.yml --env-file .env exec -T php php-cs-fixer fix --config=.php-cs-fixer.php --allow-risky=yes
