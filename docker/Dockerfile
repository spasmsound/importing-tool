FROM php:8.1-fpm
WORKDIR "/application"

ARG APCU_VERSION=5.1.21

RUN apt-get update

RUN apt-get install -y --allow-downgrades \
        libfreetype6-dev \
        zlib1g-dev \
        libjpeg62-turbo-dev \
        libicu-dev \
        libzip-dev \
        libxml2-dev \
        libpq-dev \
        libwebp-dev \
        supervisor

RUN docker-php-ext-install -j$(nproc) iconv pdo pdo_mysql zip exif \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable opcache \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

RUN apt-get install -y \
        librabbitmq-dev \
        libssh-dev \
    && docker-php-ext-install \
        bcmath \
        sockets \
    && pecl install amqp \
    && docker-php-ext-enable amqp

# Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# APCu cache
RUN pecl install apcu-${APCU_VERSION} && docker-php-ext-enable apcu

RUN apt-get clean all
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -o /usr/local/bin/cachetool http://gordalina.github.io/cachetool/downloads/cachetool.phar

# Install git
RUN apt-get update \
    && apt-get -y install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN apt-get update && apt-get install -y \
    unzip \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

