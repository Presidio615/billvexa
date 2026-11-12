
# Build frontend assets
FROM node:20 AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build


# Laravel PHP application
FROM php:8.4-apache

# Install dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zlib1g-dev \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    bcmath \
    zip \
    gd \
    fileinfo \
    && rm -rf /var/lib/apt/lists/*


# Clean Apache MPM configuration

# Diagnose Apache MPM configuration
RUN echo "=== ENABLED MPM FILES ===" && \
    ls -la /etc/apache2/mods-enabled/mpm* || true

RUN echo "=== MPM LOAD DIRECTIVES ===" && \
    grep -RniE '^[[:space:]]*LoadModule[[:space:]]+mpm_' \
    /etc/apache2 || true



# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy Laravel application
COPY . .

# Copy frontend assets
COPY --from=frontend /app/public/build ./public/build

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Configure Apache
RUN sed -ri 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf \
    && echo '<Directory /var/www/html/public>\nAllowOverride All\nRequire all granted\n</Directory>' >> /etc/apache2/apache2.conf

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 10000

CMD ["bash", "-c", "PORT=${PORT:-10000}; sed -i \"s/Listen 80/Listen ${PORT}/\" /etc/apache2/ports.conf; sed -i \"s/:80>/:${PORT}>/\" /etc/apache2/sites-available/000-default.conf; apache2-foreground"]
