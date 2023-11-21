# Development php image
FROM php:8.2-fpm AS PHP_DEV

LABEL core=php

# Add docker php ext repo
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Install php extensions
RUN chmod +x /usr/local/bin/install-php-extensions && \
    sync && \
    install-php-extensions mbstring \
                           pdo_mysql \
                           zip \
                           exif \
                           pcntl \
                           gd \
                           memcached \
                           bcmath

# Install dependencies
RUN apt-get update && \
    apt-get install -y --no-install-recommends libz-dev \
                                               libpq-dev \
                                               libjpeg-dev \
                                               libpng-dev \
                                               libssl-dev \
                                               libzip-dev \
                                               unzip \
                                               zip \
                                               nodejs && \
    apt-get clean && \
    pecl install redis && \
    docker-php-ext-configure gd && \
    docker-php-ext-configure zip && \
    docker-php-ext-install gd \
                           exif \
                           opcache \
                           pdo_mysql \
                           pdo_pgsql \
                           pgsql \
                           pcntl \
                           zip \
                           sockets \
                           bcmath && \
    docker-php-ext-enable redis && \
    rm -rf /var/lib/apt/lists/*;

# swich uid and gid to 1000 to not overlap user with host system
RUN usermod -u 1000 www-data && \
    groupmod -g 1000 www-data

# COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Hack for logging in Docker
RUN ln -sf /proc/1/fd/1 /var/log/stream.log

COPY ./docker /docker
RUN chmod 0755 /docker/startup.sh

# Set working directory
WORKDIR /var/www
RUN chmod -R 0777 /var/www/storage

COPY --chown=www-data:www-data . /var/www/
RUN composer install --no-scripts --optimize-autoloader

#CMD ["/docker/startup.sh"]
