<?php

use Http\Client\Curl\Client;
use Paygreen\Sdk\Climate\V2\ClimateClient;
use Paygreen\Sdk\Climate\V2\Model\DeliveryData;
use Paygreen\Sdk\Climate\V2\Model\PostalAddress;
use Paygreen\Sdk\Climate\V2\Model\WebBrowsingData;
use Paygreen\Sdk\Core\GreenEnvironment;

$curl = new Client();

$environment = new GreenEnvironment(
    getenv('PG_CLIMATE_CLIENT_ID'),
    getenv('PG_CLIMATE_API_SERVER'),
    getenv('PG_CLIMATE_API_VERSION')
);

$client = new ClimateClient($curl, $environment);

$response = $client->login('moduleTree', 'moduleTree', 'moduleTree');
$responseData = json_decode($response->getBody()->getContents());
dump($responseData);

$client->setBearer($responseData->access_token);

$response = $client->refresh('moduleTree', $responseData->refresh_token);
$responseData = json_decode($response->getBody()->getContents());
dump($responseData);

$client->setBearer($responseData->access_token);

// $response = $client->getAccountInfos('moduleTree');
// $responseData = json_decode($response->getBody()->getContents());
// dump($responseData);
// 
// $response = $client->getUserInfos('moduleTree', 'moduleTree');
// $responseData = json_decode($response->getBody()->getContents());
// dump($responseData);

// $response = $client->createEmptyFootprint('my-footprint-id');
// $responseData = json_decode($response->getBody()->getContents());
// dump($responseData);

// $response = $client->getFootprint('my-footprint-id', true);
// $responseData = json_decode($response->getBody()->getContents());
// dump($responseData);

// $response = $client->closeFootprint('my-footprint-id', 'CLOSED');
// $responseData = json_decode($response->getBody()->getContents());
// dump($responseData);

// $webBrowsingData = new WebBrowsingData();
// $webBrowsingData->setUserAgent('Application:my-application/1.0.0 sdk:1.0.0 php:5.6;');
// $webBrowsingData->setCountPages(85);
// $webBrowsingData->setCountImages(15);
// $webBrowsingData->setDevice('Laptop');
// $webBrowsingData->setBrowser('Firefox');
// $webBrowsingData->setTime(4789);
// $webBrowsingData->setExternalId('my-external-id');
// 
// $response = $client->addWebBrowsingData('my-footprint-id', $webBrowsingData);
// $responseData = json_decode($response->getBody()->getContents());
// dump($responseData);

$departure = new PostalAddress(
    '1 rue de Paris',
    '75000',
    'Paris',
    'France'
);

$arrival = new PostalAddress(
    '1 rue de Paris',
    '75000',
    'Paris',
    'France'
);

$deliveryData = new DeliveryData();
$deliveryData->setTotalWeightInKg(45.5);
$deliveryData->setDeparture($departure);
$deliveryData->setArrival($arrival);
$deliveryData->setTransportationExternalId('my-transportation-external-id');
//$deliveryData->setDeliveryService('Colissimo');

$response = $client->addDeliveryData('my-footprint-id', $deliveryData);
$responseData = json_decode($response->getBody()->getContents());
dump($responseData);
