# Paygreen PHP SDK

## 🚀 Getting Started

### Installation

```shell
composer require paygreen/paygreen-php
```

### Requirements

- PHP 5.6 and above.
- [PSR-18](https://www.php-fig.org/psr/psr-18/) HTTP Client like [Guzzle](https://github.com/guzzle/guzzle) or [curl-client](https://github.com/php-http/curl-client)


### Example

```php
use Http\Client\Curl\Client;
use Paygreen\Sdk\Payment\V2\PaymentClient;

$environment = new Environment('YOUR_PUBLIC_KEY', 'YOUR_PRIVATE_KEY', 'SANDBOX', 2);

$client = new PaymentClient(new Client(), $environment);

$customer = new Paygreen\Sdk\Payment\V2\Model\Customer();
$customer->setId('my-customer-id');
$customer->setEmail('john.doe@customer.fr');
// ... and setStreetLineOne, setLastName

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

$response = $paymentClient->createCashPayment($paymentOrder);
```

## 📚 Documentation

See the [docs](https://github.com/PayGreen/paygreen-php/blob/master/docs/v2/README.md).

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
