<?php

use Symfony\Component\Dotenv\Dotenv;

date_default_timezone_set('Europe/Paris');

require dirname(dirname(__DIR__)) . '/vendor/autoload.php';

(new Dotenv())->load(__DIR__ . '/.env');

require __DIR__ . DIRECTORY_SEPARATOR . 'payment_v' . getenv('PG_PAYMENT_API_VERSION') . '.php';
//require __DIR__ . DIRECTORY_SEPARATOR . 'climate_v' . getenv('PG_CLIMATE_API_VERSION') . '.php';
//require __DIR__ . DIRECTORY_SEPARATOR . 'charity_v' . getenv('PG_CHARITY_API_VERSION') . '.php';
