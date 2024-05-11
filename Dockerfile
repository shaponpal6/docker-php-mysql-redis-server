# Use the official PHP image as a base
FROM php:8.3.2-apache

RUN apt-get update && apt-get install -y \
    entr \
    libzip-dev \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions required for MySQL connection
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Redis PHP extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# Clear package cache
RUN apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy the PHP application files into the container
COPY index.php /var/www/html/index.php

# Copy Composer dependencies for caching
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

# Generate autoload files
RUN composer dump-autoload --optimize

# Expose port 80 to the outside world
EXPOSE 80
