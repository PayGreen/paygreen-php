<?php

use Http\Client\Curl\Client;
use Paygreen\Sdk\Core\Environment;
use Paygreen\Sdk\Payment\Model\Order;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;
use Paygreen\Sdk\Payment\V3\PaymentClient;

$curl = new Client();

$environment = new Environment(
    getenv('PG_PAYMENT_PUBLIC_KEY'),
    getenv('PG_PAYMENT_PRIVATE_KEY'),
    getenv('PG_PAYMENT_API_SERVER'),
    getenv('PG_PAYMENT_API_VERSION')
);

$client = new PaymentClient($curl, $environment);

$response = $client->authenticate();

$bearer = $response->getData()->data->token;

$client->setBearer($bearer);

$buyer = new Buyer();
$buyer->setId(uniqid());
$buyer->setFirstname('John');
$buyer->setLastname('Doe');
$buyer->setEmail('romain@paygreen.fr');
$buyer->setCountryCode('FR');

$response = $client->createBuyer($buyer);
$data = $response->getData();
dump($data);
$buyer->setReference($data->data->id);
$response = $client->getBuyer($buyer);
dump($response->getData());
$buyer->setFirstname('Jerry');
$buyer->setLastname('Cane');
$buyer->setEmail('dev-module@paygreen.fr');
$buyer->setCountryCode('US');
$response = $client->updateBuyer($buyer);
dump($response->getData());


$order = new Order();
$order->setCustomer($buyer);
$order->setReference('SDK-ORDER-123');
$order->setAmount(1000);
$order->setCurrency('EUR');

$paymentOrder = new PaymentOrder();
$paymentOrder->setPaymentMode("instant");
$paymentOrder->setAutoCapture(true);
$paymentOrder->setIntegrationMode("hosted_fields");
$paymentOrder->setOrder($order);

$response = $client->createOrder($paymentOrder);

dump($response->getData());