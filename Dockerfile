FROM php:7.2-apache

COPY scripts/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN apt-get update \
    && apt-get install -y --no-install-recommends dialog \
	&& apt-get install -y --no-install-recommends openssh-server \
	&& echo "root:Docker!" | chpasswd \
	&& chmod +x /usr/local/bin/entrypoint.sh \
	&& apt-get install -y zip unzip libzip-dev default-mysql-client \
	&& docker-php-ext-install mysqli && docker-php-ext-enable mysqli \
	&& docker-php-ext-install zip pdo_mysql

COPY config/sshd_config /etc/ssh/
COPY config/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ssl /var/www/ssl/
COPY src/public /var/www/html/

EXPOSE 8000 2222

ENTRYPOINT ["entrypoint.sh"]

WORKDIR /var/www/html/