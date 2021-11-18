# Paygreen PHP SDK
[![coverage report](https://gitlab.com/Paygreen-paygreen/integration/sdk-php/badges/develop/coverage.svg)](https://gitlab.com/Paygreen-paygreen/integration/sdk-php/-/commits/develop)

## Installation

```shell
composer require paygreen/paygreen-php
```

## Requirements

- PSR-7 HTTP Client like [Guzzle](https://github.com/guzzle/guzzle) or [curl-client](https://github.com/php-http/curl-client)

## Getting Started

```php
use Http\Client\Curl\Client;
use Paygreen\Sdk\Payment\V2\PaymentClient;

putenv("PG_PAYMENT_PUBLIC_KEY=public_key");
putenv("PG_PAYMENT_PRIVATE_KEY=private_key");
putenv("PG_PAYMENT_API_SERVER=PRODUCTION");
putenv("PG_PAYMENT_API_VERSION=2");

$curl = new Client();
$client = new PaymentClient($curl);


$customer = new Customer();
$customer->setEmail('john.doe@customer.com');
// ... set id, firstname, lastname

$shippingAddress = new Address();
$shippingAddress->setCity('Rouen');
// ... set firstname, lastname, street, postcode, country

$billingAddress = new Address();
$billingAddress->setCity('Rouen');
// ... set firstname, lastname, street, postcode, country

$order = new Order();
$order->setCustomer($customer);
$order->setBillingAddress($billingAddress);
$order->setShippingAddress($shippingAddress);
$order->setReference('my-reference');
$order->setAmount(1000);
$order->setCurrency('EUR');

$paymentOrder = new PaymentOrder();
$paymentOrder->setOrder($order);

$response = $client->createCashPayment($paymentOrder);

$data = $response->getData();
```

## Testing

Start docker stack:
```shell
docker-compose up -d
```

Run tests:
```shell
docker-compose exec php vendor/bin/phpunit tests
```
