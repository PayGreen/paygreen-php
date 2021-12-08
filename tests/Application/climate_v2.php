<?php

use Http\Client\Curl\Client;
use Paygreen\Sdk\Climate\V2\ClimateClient;
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

$response = $client->getAccountInfos('moduleTree');
$responseData = json_decode($response->getBody()->getContents());
dump($responseData);

$response = $client->getUserInfos('moduleTree', 'moduleTree');
$responseData = json_decode($response->getBody()->getContents());
dump($responseData);

// $response = $client->createEmptyFootprint('my-footprint-id');
// $responseData = json_decode($response->getBody()->getContents());
// dump($responseData);

$response = $client->getFootprint('my-footprint-id', true);
$responseData = json_decode($response->getBody()->getContents());
dump($responseData);

$response = $client->closeFootprint('my-footprint-id', 'CLOSED');
$responseData = json_decode($response->getBody()->getContents());
dump($responseData);
