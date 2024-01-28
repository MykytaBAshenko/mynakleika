FROM php:7.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd calendar
# Copy app config file
COPY ./laravel.ini /usr/local/etc/php/conf.d

# Add xdebug
RUN pecl install xdebug-3.1.6 && docker-php-ext-enable xdebug
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/www/app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ARG UID=1000
ARG GID=1000
RUN usermod  --uid $UID www-data
RUN groupmod --gid $GID www-data

USER www-data

EXPOSE 9000
CMD ["php-fpm"]
