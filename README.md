# Paygreen PHP SDK

## Installation

```shell
composer require paygreen/paygreen-php
```

## Requirements

- PHP 5.6 and above.
- PSR-7 HTTP Client like [Guzzle](https://github.com/guzzle/guzzle) or [curl-client](https://github.com/php-http/curl-client)

## Getting Started

```php
use Http\Client\Curl\Client;
use Paygreen\Sdk\Payment\V2\PaymentClient;

$environment = new Environment('YOUR_PUBLIC_KEY', 'YOUR_PRIVATE_KEY', 'SANDBOX', 2);

$client = new PaymentClient(new Client(), $environment);

$customer = new Paygreen\Sdk\Payment\V2\Model\Customer();
$customer->setId('my-customer-id');
$customer->setEmail('john.doe@customer.fr');
// ... and setStreetLineOne, setLastname

$shippingAddress = new Paygreen\Sdk\Payment\V2\Model\Address();
$shippingAddress->setCity('London');
// ... and setStreetLineOne, setCountryCode, setPostcode

$billingAddress = new Paygreen\Sdk\Payment\V2\Model\Address();
$billingAddress->setCity('London');
// ... and setStreetLineOne, setCountryCode, setPostcode

$order = new Paygreen\Sdk\Payment\V2\Model\Order();
$order->setCustomer($customer);
$order->setBillingAddress($billingAddress);
$order->setShippingAddress($shippingAddress);
$order->setReference('my-order-reference');
$order->setAmount(2650);
$order->setCurrency('EUR');

$paymentOrder = new Paygreen\Sdk\Payment\V2\Model\PaymentOrder();
$paymentOrder->setType('CASH');
$paymentOrder->setOrder($order);
$paymentOrder->setNotifiedUrl('https://localhost/notify');

try {
    $response = $paymentClient->createCashPayment($paymentOrder);
} catch (Paygreen\Sdk\Core\Exception\ConstraintViolationException $exception) {
    // Here you can catch constraint validation errors.
}
```

## Documentation

See the [docs](https://github.com/PayGreen/paygreen-php/blob/master/docs/v2/README.md).

## Testing

Start docker stack:
```shell
docker-compose up -d
```

Run tests:
```shell
docker-compose exec php vendor/bin/phpunit tests
```
