---
title: PHP Client
excerpt: The PayGreen PHP SDK exposes the API features through a standardized programming interface.
category: 62d66960a411210082d84f35
slug: php-client
---

# Introduction



## Prerequisites

PHP 5.6 and above.

## Usage

First, you need to initialize the HTTP client:
```php
$psr18Client = new Client(); // Must implement the HttpClient interface like Guzzle or curl-client

$environment = new Paygreen\Sdk\Payment\V3\Environment(
    'YOUR_SHOP_ID', // Look like this: sh_00000000000000
    'YOUR_SECRET_KEY', // Look like this: sk_00000000000000
    'SANDBOX' // Possible values : PRODUCTION, SANDBOX
);

$client = new Paygreen\Sdk\Payment\V3\Client($psr18Client, $environment);
```
