FROM php:7.2-apache

RUN apt-get update \
&& apt-get install -y zip unzip libzip-dev default-mysql-client \
&& docker-php-ext-install mysqli && docker-php-ext-enable mysqli \
&& docker-php-ext-install zip pdo_mysql

ADD ${WEBAPP_STORAGE_HOME}/config/000-default.conf /etc/apache2/sites-available/000-default.conf

COPY ${WEBAPP_STORAGE_HOME}/src/public /var/www/html/

WORKDIR /var/www/html