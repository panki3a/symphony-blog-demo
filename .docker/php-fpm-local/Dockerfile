FROM php:8.3.8-fpm-bookworm

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY --chown=www-data:www-data ./ /app
COPY ./.docker/php-fpm-local/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./.docker/php-fpm-local/docker-fpm-entrypoint /usr/local/bin/

RUN apt-get update && apt-get install -y \
        zlib1g-dev \
        libpq-dev \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        curl \
        nano \
        iputils-ping \
        vim \
        git \
        zip \
        unzip \
        zlib1g-dev \
        libzip-dev \
        libpng-dev  \
        libjpeg-dev \
        libfreetype6-dev \
        libwebp-dev \
        libicu-dev \
    ;

RUN pecl install \
        redis \
        xdebug \
    ; \
RUN    docker-php-ext-install -j$(nproc) \
        intl \
        opcache \
        pdo \
        pdo_mysql \
        zip \
        sockets \
        bcmath  \
        pcntl \
        gd \
	; \
    docker-php-ext-enable \
        opcache \
        redis \
    ; \
    docker-php-ext-install intl ;
# install the xhprof extension to profile requests
COPY ./.docker/php-fpm-local/xhprof.ini /usr/local/etc/php/conf.d/xhprof.ini
RUN pecl install xhprof; \
    docker-php-ext-enable xhprof; \
    mkdir -m 777 /profiles ;

RUN { \
        echo 'memory_limit=128M'; \
        echo 'post_max_size=128M'; \
        echo 'upload_max_filesize=128M'; \
    } > /usr/local/etc/php/conf.d/project-performance.ini; \
    chmod +x /usr/local/bin/docker-fpm-entrypoint; \
    chmod o+w /tmp; \
    apt update --allow-insecure-repositories --allow-unauthenticated; \
    apt upgrade -y; \
    apt install -y; \
    apt-get autoclean; \
    apt-get clean; \
    rm -rf /tmp/*; \
    rm -rf /tmp/*; \
    rm -rf /var/cache/apk/*;

ENTRYPOINT ["docker-fpm-entrypoint"]

WORKDIR /app

CMD ["php-fpm"]
