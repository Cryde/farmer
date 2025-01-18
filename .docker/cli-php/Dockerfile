FROM php:8.4-cli-alpine3.21

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk add --update --no-cache \
    libpq-dev \
    libzip-dev \
    shadow \
    autoconf \
    build-base

RUN docker-php-ext-install \
    opcache  \
    bcmath  \
    zip  \
    pdo  \
    pgsql  \
    pdo_pgsql

RUN pecl install pcov  && docker-php-ext-enable pcov

ARG USER=www-data
ARG UID=1000

RUN usermod -u ${UID} ${USER}
RUN groupmod -g ${UID} ${USER}

USER ${USER}

COPY . /var/www/stellar
WORKDIR /var/www
