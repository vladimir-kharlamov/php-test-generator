﻿FROM php:8.0.5-fpm-alpine

# Install system dependencies
#RUN apt-get update && apt-get install -y git

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql

# Install zip
#RUN apt-get install -y zip unzip libzip-dev
#RUN docker-php-ext-install zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www