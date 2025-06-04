# Change php version
FROM php:8.2-fpm

# Installing services and extensions
RUN apt-get update && apt-get install -y \
    mariadb-client \
    build-essential \
    libpng-dev \
    libwebp-dev \
    libonig-dev \
    libpq-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    libxml2-dev \
    libzip-dev \
    nano \
    iputils-ping \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    tzdata \
    libc-client-dev \
    libkrb5-dev \
    \
    # Other extensions
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl soap bcmath sockets \
    && docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg \
    && docker-php-ext-install gd \
    \
    # clean cache
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    # install composer
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0" \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="10000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="192" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10"

RUN docker-php-ext-install opcache
# Add user for aplication
RUN groupadd -g 1000 admin && useradd -u 1000 -ms /bin/bash -g admin admin
#COPY --chown=admin:admin . /var/www
USER admin

EXPOSE 9000
CMD ["php-fpm"]
