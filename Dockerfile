# Use PHP 8.3 with Apache
FROM php:8.3-apache

WORKDIR /var/www/html

# Install system dependencies + Postgres headers + Node.js
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    libpq-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo_pgsql mbstring zip

# Enable Apache rewrite
RUN a2enmod rewrite

# Set Apache DocumentRoot to Laravel public folder
RUN sed -i 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader

# 🔥 Install Node deps & build Vite assets
RUN npm install
RUN npm run build

# Set permissions (VERY IMPORTANT)
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copy entrypoint
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
