<?php

use Http\Client\Curl\Client;
use Paygreen\Sdk\Payment\Model\Address;
use Paygreen\Sdk\Payment\Model\Customer;
use Paygreen\Sdk\Payment\Model\Order;
use Paygreen\Sdk\Payment\V2\Model\PaymentOrder;
use Paygreen\Sdk\Payment\V2\PaymentClient;

$curl = new Client();

$client = new PaymentClient($curl);

$customer = new Customer();
$customer->setId(1);
$customer->setEmail('team.module@paygreen.fr');
$customer->setFirstname('John');
$customer->setLastname('Doe');

$shippingAddress = new Address();
$shippingAddress->setFirstname('John');
$shippingAddress->setLastname('Doe');
$shippingAddress->setStreetLineOne('1 rue de la Livraison');
$shippingAddress->setStreetLineTwo('Appartement 12');
$shippingAddress->setCity('Rouen');
$shippingAddress->setCountryCode('FR');
$shippingAddress->setPostcode('76000');

$billingAddress = new Address();
$billingAddress->setFirstname('John');
$billingAddress->setLastname('Doe');
$billingAddress->setStreetLineOne('1 rue de la Facturation');
$billingAddress->setCity('Rouen');
$billingAddress->setCountryCode('FR');
$billingAddress->setPostcode('76000');

$order = new Order();
$order->setCustomer($customer);
$order->setBillingAddress($billingAddress);
$order->setShippingAddress($shippingAddress);
$order->setReference('SDK-ORDER-123');
$order->setAmount(1000);
$order->setCurrency('EUR');

$paymentOrder = new PaymentOrder();
$paymentOrder->setOrder($order);


$response = $client->createPaymentOrder($paymentOrder);

dump($response);