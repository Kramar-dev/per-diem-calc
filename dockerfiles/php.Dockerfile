FROM php:8.2-fpm-alpine

WORKDIR /var/www/laravel

RUN apk --no-cache add \
        mysql-client \
        libzip-dev \
    && docker-php-ext-install \
        pdo pdo_mysql \
        zip