<?php

use Symfony\Component\Dotenv\Dotenv;

date_default_timezone_set('Europe/Paris');

require dirname(dirname(__DIR__)) . '/vendor/autoload.php';

(new Dotenv())->load(__DIR__ . '/.env');

require __DIR__ . DIRECTORY_SEPARATOR . 'v2.php';
