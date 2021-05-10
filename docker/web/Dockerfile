FROM php:7.2-apache


# Ubuntu

RUN apt-get update


# PHP

RUN docker-php-ext-install mysqli
RUN apt-get update
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install gd
RUN apt-get install -y libxml2-dev
RUN docker-php-ext-install soap
RUN apt-get install -y zlib1g-dev libzip-dev sendmail
RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get install -y libmcrypt-dev
RUN pecl install mcrypt-1.0.2
RUN docker-php-ext-enable mcrypt
RUN sed -i '/#!\/bin\/sh/aservice sendmail restart' /usr/local/bin/docker-php-entrypoint
RUN sed -i '/#!\/bin\/sh/aecho "$(hostname -i)\t$(hostname) $(hostname).localhost" >> /etc/hosts' /usr/local/bin/docker-php-entrypoint
COPY php.ini $PHP_INI_DIR/php.ini


# SSL

RUN apt-get install -y ssl-cert
RUN a2enmod ssl
RUN a2ensite default-ssl.conf


# Apache

COPY codeigniter.conf /etc/apache2/conf-enabled
RUN a2enmod rewrite
RUN service apache2 restart
