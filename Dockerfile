ARG PHP_VERSION=5.6

FROM php:${PHP_VERSION}-fpm-alpine AS php

RUN set -eux; \
    apk add --no-cache \
        $PHPIZE_DEPS \
    	; \
    pecl install \
        xdebug-2.5.5 \
    	; \
    docker-php-ext-install -j$(nproc) \
        json \
        ; \
    docker-php-ext-enable \
        xdebug

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN set -eux; \
	composer clear-cache
ENV PATH="${PATH}:/root/.composer/vendor/bin"

WORKDIR /srv/paygreen

COPY composer.json composer.lock ./
COPY lib lib/
COPY tests tests/

RUN set -eux; \
	composer install --prefer-dist --no-scripts --no-progress; \
	composer clear-cache


COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]