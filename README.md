# Paygreen PHP SDK

## 🚀 Getting Started

### Installation

```shell
composer require paygreen/paygreen-php
```

### Requirements

- PHP 5.6 and above.
- [PSR-18](https://www.php-fig.org/psr/psr-18/) HTTP Client like [Guzzle](https://github.com/guzzle/guzzle) or [curl-client](https://github.com/php-http/curl-client)

## 📚 Documentation

> 🚀 Find the documentation for Paygreen V3 [here](https://github.com/PayGreen/paygreen-php/tree/master/docs/v3).

## 🚧 Testing

Start docker stack:
```shell
docker-compose up -d
```

PHPUnit tests:
```shell
docker-compose exec php vendor/bin/phpunit tests
```

Behat tests:

```shell
docker-compose exec php vendor/bin/behat
```
