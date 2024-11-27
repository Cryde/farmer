FROM php:8.3-cli-alpine3.20

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

WORKDIR /var/www