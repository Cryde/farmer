FROM php:8.4-fpm-alpine3.21

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk add --update --no-cache \
    libpq-dev \
    bzip2-dev  \
    libzip-dev \
    icu-dev  \
    icu-data-full \
    build-base  \
    autoconf  \
    libxml2-dev  \
    libssh2-dev


RUN docker-php-ext-configure intl
RUN docker-php-ext-install opcache intl

RUN docker-php-ext-install opcache bcmath bz2 zip pdo pgsql pdo_pgsql



COPY --chown=www-data:www-data . /var/www/farmer
WORKDIR /var/www/farmer
ENV APP_ENV="prod"