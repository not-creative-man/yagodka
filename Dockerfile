FROM php:7.2-apache

# Set new document root
ENV APACHE_DOCUMENT_ROOT /var/www/yagodka/web

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN apt-get update
RUN apt-get install -y default-mysql-client wget zip unzip git
RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY . /var/www/yagodka

WORKDIR /var/www/yagodka

RUN /var/www/yagodka/bin/install_composer.sh
RUN composer update && composer install

RUN chmod -R 777 /var/www/yagodka/vendor /var/www/yagodka/assets /var/www/yagodka/runtime /var/www/yagodka/web/assets /var/www/yagodka/web/files