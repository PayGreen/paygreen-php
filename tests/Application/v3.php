<?php

use Http\Client\Curl\Client;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use Paygreen\Sdk\Payment\V3\PaymentClient;

$curl = new Client();

$client = new PaymentClient($curl);

$response = $client->authenticate();

$bearer = $response->getData()->data->token;

$client->setBearer($bearer);

$buyer = new Buyer();
$buyer->setId(uniqid());
$buyer->setFirstname('John');
$buyer->setLastname('Doe');
$buyer->setEmail('test@paygreen.fr');
$buyer->setCountryCode('FR');

$response = $client->createBuyer($buyer);
$data = $response->getData();
dump($data);
$buyer->setReference($data->data->id);
$response = $client->getBuyer($buyer);
dump($response->getData());
$buyer->setFirstname('Jerry');
$buyer->setLastname('Cane');
$buyer->setEmail('cane@paygreen.fr');
$buyer->setCountryCode('US');
$response = $client->updateBuyer($buyer);
dump($response->getData());