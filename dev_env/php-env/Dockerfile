# This Dockerfile is necessary if you require things that the base image doesn't provide, ie PDO MySQL
# If you need extra tools like (git, vim, curl) you can add it to this file

## Downloads the official PHP 8.2 CLI image from DockerHub - PHP runtime only, no web server
#FROM php:8.2-cli

ARG PHP_VERSION=8.2-apache

# Downloads the official PHP 8.2 Apache image from DockerHub - PHP + Apache all-in-one web server
FROM php:${PHP_VERSION}

# Install system dependencies for Composer packages
RUN apt-get update && apt-get install -y \
    unzip git curl \
    && rm -rf /var/lib/apt/lists/*

# Install MySQL extension for PDO (PHP Data Objects)
# It is a database access abstraction layer built into PHP
# docker-php-ext-install is a helper script included in the official PHP Docker images
#   it makes it easy to install common PHP extensions without manually compiling or configuring them
# pdo is required for using PHP Data Objects, it is database-agnostic - does not connect to MySQL by itself
# pdo_mysql allows you to use PDO to connect to MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
# Copy the Composer executable from the Composer image into my PHP image so I can run Composer
# inside my container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# PHP Dev Format Tools
RUN composer global require \
    lkrms/pretty-php \
    friendsofphp/php-cs-fixer \
    squizlabs/php_codesniffer

ENV PATH="/root/.composer/vendor/bin:${PATH}"

# php.ini
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# After setting WORKDIR /app, any subsequent lines like
#   COPY ..
#   RUN composer install
#   CMD ["php", "test.php"]
# all happen inside /app by default
# If /app doesn't exist Docker creates it
# When you run:
#   docker compose exec php sh
# you'll start in the /app directory, not /
# Without WORKDIR:
#   COPY ./app /app
#   RUN php /app/test.php
# With WORKDIR:
#   WORKDIR /app
#   COPY . .
#   RUN php test.php
WORKDIR /var/www/html

# Start PHP-FPM in background, then keep container alive
ENTRYPOINT ["docker-php-entrypoint"]
# -F = run in foreground
CMD ["php-fpm", "-F"]
