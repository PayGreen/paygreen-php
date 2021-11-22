<?php

use Http\Client\Curl\Client;
use Paygreen\Sdk\Payment\Model\Address;
use Paygreen\Sdk\Payment\Model\Customer;
use Paygreen\Sdk\Payment\Model\Order;
use Paygreen\Sdk\Payment\Model\OrderDetails;
use Paygreen\Sdk\Payment\V2\Model\PaymentOrder;
use Paygreen\Sdk\Payment\V2\PaymentClient;
use Paygreen\Sdk\Payment\V2\Model\MultiplePayment;
use Paygreen\Sdk\Core\Environment;

$curl = new Client();

$environment = new Environment(
    getenv('PG_PAYMENT_PUBLIC_KEY'),
    getenv('PG_PAYMENT_PRIVATE_KEY'),
    getenv('PG_PAYMENT_API_SERVER'),
    getenv('PG_PAYMENT_API_VERSION')
);

$client = new PaymentClient($curl, $environment);

$customer = new Customer();
$customer->setId(1);
$customer->setEmail('maxime.lemolt@paygreen.fr');
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
$paymentOrder->setType('CASH');
$paymentOrder->setOrder($order);

$response = $client->createCashPayment($paymentOrder);
$responseData = $response->getData();

dump($responseData);

$transactionId = $responseData->data->id;
$response = $client->refundPayment($transactionId);
dump($response->getData());

// $orderDetails = new OrderDetails();
// $orderDetails->setCycle(40);
// $orderDetails->setCount(12);
// $orderDetails->setFirstAmount(6500);
// $orderDetails->setDay(18);
// $orderDetails->setStartAt(1637227163);
//
// $multiplePayment = new MultiplePayment();
// $multiplePayment->setWithPaymentLink(true);
// $multiplePayment->setOrderDetails($orderDetails);

// $paymentOrder->setMultiplePayment($multiplePayment);
// $paymentOrder->setType('RECURRING');

// $response = $client->createRecurringPayment($paymentOrder);

// dump($response->getData());