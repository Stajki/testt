FROM php:7.4-fpm
MAINTAINER Shop

WORKDIR /var/www/vhost

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update
RUN apt-get install -y \
        curl \
        wget \
        nano \
        git \
        zip \
        npm

# COMPOSER
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
