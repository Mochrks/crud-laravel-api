# Stage 1: Build the application and prepare dependencies using Composer
FROM composer:2.2.9 AS composer
WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --ignore-platform-reqs --no-interaction --no-plugins --no-scripts

# Copy application files
COPY . ./

# Generate autoload files and clear cache
RUN composer dump-autoload --optimize --classmap-authoritative
RUN php artisan cache:clear

# Stage 2: Set up PHP and Apache for runtime
FROM php:8.2-apache AS runtime
WORKDIR /var/www

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install necessary PHP extensions
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    libonig-dev \
    openssl \
    libpq-dev && \
    docker-php-ext-install \
    mbstring \
    pdo_pgsql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Allow Composer to be run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Copy built application from composer stage
COPY --from=composer /app .

# Set ownership for certain directories
RUN chown -R www-data:www-data storage bootstrap/cache

# Configure document root for Apache
ENV APACHE_DOCUMENT_ROOT /var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Expose port 80 for the application
EXPOSE 80

# Add maintainer label
LABEL maintainer="mochrizki-dev"

# Command to run Apache
CMD ["apache2-foreground"]
