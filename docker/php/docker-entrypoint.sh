#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX tests/Application/var

composer install --prefer-dist --no-progress --no-interaction

exec docker-php-entrypoint "$@"
