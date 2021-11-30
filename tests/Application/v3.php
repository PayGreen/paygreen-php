<?php

use Http\Client\Curl\Client;
use Paygreen\Sdk\Core\Environment;
use Paygreen\Sdk\Payment\V3\Enum\IntegrationModeEnum;
use Paygreen\Sdk\Payment\V3\Enum\ModeEnum;
use Paygreen\Sdk\Payment\V3\Model\Address;
use Paygreen\Sdk\Payment\V3\Model\Instrument;
use Paygreen\Sdk\Payment\V3\Model\Order;
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

$address = new Address();
$address->setStreetLineOne("107 allée Francois Mitterand");
$address->setPostalCode("76100");
$address->setCity("Rouen");
$address->setCountryCode("FR");

$buyer->setBillingAddress($address);

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

$buyerNoreference = new Buyer();
$buyerNoreference->setId(uniqid());
$buyerNoreference->setFirstname('Will');
$buyerNoreference->setLastname('Jackson');
$buyerNoreference->setEmail('romain@paygreen.fr');
$buyerNoreference->setCountryCode('FR');
$buyerNoreference->setBillingAddress($address);

$order = new Order();
$order->setBuyer($buyerNoreference);
$order->setReference('SDK-ORDER-123');
$order->setAmount(107);
$order->setCurrency('eur');
$order->setShippingAddress($address);

$paymentOrder = new PaymentOrder();
$paymentOrder->setPaymentMode(ModeEnum::INSTANT);
$paymentOrder->setIntegrationMode(IntegrationModeEnum::DIRECT);
$paymentOrder->setOrder($order);

$response = $client->createOrder($paymentOrder);
$data = $response->getData();
dump($data);

$order->setBuyer($buyer);
$response = $client->createOrder($paymentOrder);
$data = $response->getData();
dump($data);

$order->setReference($data->data->id);
$response = $client->getOrder($paymentOrder->getOrder()->getReference());
$data = $response->getData();
dump($data);

$paymentOrder->setPartialAllowed(true);
$response = $client->updateOrder($paymentOrder);
$data = $response->getData();
dump($data);

/*$instrument = new Instrument();
$instrument->setReference("ins_4961c47e6666497fb17d4e5af6268ac2");
$response = $client->deleteInstrument($instrument->getReference());
$data = $response->getData();
dump($data);*/

/*$response = $client->captureOrder("po_83b64a6891d04c60b8d372da4a1df37e");
$data = $response->getData();
dump($data);*/

/*$response = $client->refundOrder("po_546db30ae2ec47769ef6de982c87b7b2");
$data = $response->getData();
dump($data);*/
