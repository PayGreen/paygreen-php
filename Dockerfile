ARG PHP_VERSION=5.6
ARG PHPSTAN_PHP_VERSION=7.2
ARG NGINX_VERSION=1.21

FROM php:${PHP_VERSION}-fpm-alpine AS php

RUN set -eux; \
	apk add --no-cache \
		chromium \
		acl \
		libzip-dev \
		$PHPIZE_DEPS \
		wget \
		; \
	docker-php-ext-install -j$(nproc) \
		json \
		zip \
		;

RUN wget https://xdebug.org/files/xdebug-2.5.5.tgz && \
  tar -xzf xdebug-2.5.5.tgz && \
  cd xdebug-2.5.5 && \
  phpize && \
  ./configure --enable-xdebug && \
  make && \
  make install && \
  cd .. && \
  rm xdebug-2.5.5.tgz && \
  rm -rf xdebug-2.5.5

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN set -eux; \
	composer clear-cache
ENV PATH="${PATH}:/root/.composer/vendor/bin"

WORKDIR /srv/paygreen

COPY composer.json composer.lock phpunit.xml.dist ./
COPY lib lib/
COPY tests tests/
COPY features features/

RUN set -eux; \
	composer install --prefer-dist --no-scripts --no-progress; \
	composer clear-cache

COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]


FROM php:${PHPSTAN_PHP_VERSION}-fpm-alpine AS phptools

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN set -eux; \
	composer clear-cache
ENV PATH="${PATH}:/root/.composer/vendor/bin"

WORKDIR /srv/paygreen

COPY composer.json composer.lock phpunit.xml.dist ./
COPY lib lib/
COPY tests tests/
COPY --from=php /srv/paygreen/vendor vendor/

RUN set -eux; \
    composer global require phpstan/phpstan; \
    composer global require friendsofphp/php-cs-fixer; \
    export PATH=~/.composer/vendor/bin:$PATH

COPY docker/phpstan/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]


FROM nginx:${NGINX_VERSION}-alpine AS nginx

COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d/

WORKDIR /srv/paygreen

COPY --from=php /srv/paygreen ./