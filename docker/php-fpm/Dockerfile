FROM php:8.2-fpm-alpine

# Set to keep file permissions same as host for mounted volume
RUN adduser -S 1001 -G www-data

RUN apk update --update-cache && \
        apk add openssl \
            curl\
            git\
            unzip\
            libmemcached-dev\
            curl-dev\
            libmcrypt-dev\
            libjpeg-turbo-dev\
            libpng-dev\
            libwebp-dev\
            freetype-dev\
            libzip-dev\
            oniguruma-dev\
            re2c\
            libtool\
            bash\
            mc\
            autoconf\
            dpkg-dev\
            dpkg\
            libmagic\
            file\
            build-base\
            ffmpeg

RUN apk add ca-certificates && \
    sed -i '/^mozilla\/DST_Root_CA_X3.crt$/ s/^/!/' /etc/ca-certificates.conf && \
    update-ca-certificates

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version
RUN mkdir -p "/.composer/cache" && chown -R 1001:www-data /.composer/cache

RUN docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype
RUN docker-php-ext-install gd

# Install Other Dependencies
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install zip
RUN docker-php-ext-install exif
RUN docker-php-ext-install mbstring
RUN docker-php-ext-configure pdo_mysql
RUN docker-php-ext-install -j "$(nproc)" pdo_mysql
RUN pecl install redis && docker-php-ext-enable redis
RUN pecl install mcrypt-1.0.6 && docker-php-ext-enable mcrypt
RUN pecl install excimer && docker-php-ext-enable excimer

#ADD ./docker/php-fpm/conf/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
ADD ./docker/php-fpm/ini/uploads.ini /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /var/www/app


