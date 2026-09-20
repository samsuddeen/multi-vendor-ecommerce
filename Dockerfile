# ================================================================
# BASE IMAGE
# ================================================================
# PHP 8.3 + Apache
#
# Laravel project PHP 8.4 require karta hai.
# composer.json mein:
# "php": "^8.4"
#
# Isliye PHP 8.4 use kar rahe hain.
FROM php:8.4-apache


# ================================================================
# WORKING DIRECTORY
# ================================================================
# Laravel application container ke andar
# /var/www/html mein rahegi.
WORKDIR /var/www/html


# ================================================================
# APACHE CONFIGURATION
# ================================================================
# Laravel ke liye custom Apache virtual host copy karenge.
COPY laravel.conf /etc/apache2/sites-available/


# Laravel Apache configuration enable karna
RUN a2ensite laravel.conf


# Apache mod_rewrite enable karna
#
# Laravel ki .htaccess aur clean URLs ke liye required hai.
RUN a2enmod rewrite


# ================================================================
# SYSTEM PACKAGES / PHP EXTENSIONS
# ================================================================
RUN apt-get update -y && apt-get install -y \
    git \
    curl \
    libicu-dev \
    libmariadb-dev \
    unzip \
    zip \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libffi-dev \
    nano \
    wget \
    libzip-dev \
    libldap2-dev \
    && rm -rf /var/lib/apt/lists/* \
    \
    # GD extension configuration
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    \
    # LDAP extension configuration
    && docker-php-ext-configure ldap \
        --with-libdir=lib/x86_64-linux-gnu \
    \
    # PHP extensions install
    && docker-php-ext-install \
        gd \
        zip \
        ldap \
        mysqli \
        pdo \
        pdo_mysql


# ================================================================
# COMPOSER
# ================================================================
# Composer install karna
#
# Laravel dependencies install karne ke liye Composer required hai.
RUN curl -sS https://getcomposer.org/installer | \
    php -- \
    --install-dir=/usr/local/bin \
    --filename=composer



# ================================================================
# APACHE PORT
# ================================================================
# Container ke andar Apache port 80 par chalega.
#
# Host par hum ise 8084 se expose karenge.
EXPOSE 80


# ================================================================
# APACHE START
# ================================================================
# Apache foreground mein chalega.
#
# Docker container ko alive rakhne ke liye required hai.
CMD ["apache2-foreground"]
