#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

composer install --prefer-dist --no-progress --no-interaction

vendor/bin/phpunit --configuration phpunit.xml.dist --coverage-text --colors=never

exec docker-php-entrypoint "$@"
