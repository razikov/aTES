FROM php:8.1-fpm

RUN apt-get update --fix-missing \
    && apt-get install -y curl wget zip unzip git \
    && apt-get install -y libicu-dev libpq-dev libxml2-dev libzip-dev libonig-dev libxslt-dev librabbitmq-dev \
    && docker-php-ext-install intl pdo_pgsql mbstring bcmath xsl zip \
    && rm -rf /var/lib/apt/lists/*

RUN curl https://getcomposer.org/composer.phar > /usr/local/bin/composer && chmod a+x /usr/local/bin/composer

RUN pecl install -o -f xdebug amqp \
    && docker-php-ext-enable amqp \
    && rm -rf /tmp/pear

RUN git clone --depth 1 https://github.com/edenhill/librdkafka.git \
    && ( \
        cd librdkafka \
        && ./configure \
        && make \
        && make install \
    ) \
    && pecl install rdkafka \
    && echo "extension=rdkafka.so" > /usr/local/etc/php/conf.d/rdkafka.ini

COPY ./php.ini /usr/local/etc/php/

WORKDIR "/app"
