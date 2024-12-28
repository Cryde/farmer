FROM php:8.4-cli-alpine3.21

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

RUN apk add --update --no-cache git bash vim

RUN docker-php-ext-configure intl
RUN docker-php-ext-install opcache intl

RUN docker-php-ext-install opcache bcmath bz2 zip pdo pgsql pdo_pgsql

RUN apk add --update --no-cache shadow
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

COPY --chown=www-data:www-data . /var/www/stellar

WORKDIR /var/www

USER www-data