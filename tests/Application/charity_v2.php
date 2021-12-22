<?php

use Http\Client\Curl\Client;

$curl = new Client();

$environment = new \Paygreen\Sdk\Charity\V2\Environment(
    getenv('PG_CHARITY_CLIENT_ID'),
    getenv('PG_CHARITY_API_SERVER'),
    getenv('PG_CHARITY_API_VERSION')
);

$environment->setTestMode(true);

$client = new \Paygreen\Sdk\Charity\V2\Client($curl, $environment);

$response = $client->login('poleintegration_5', 'poleintegration_5', 'poleintegration_5');
$responseData = json_decode($response->getBody()->getContents());
dump($responseData);

$client->setBearer($responseData->access_token);

$response = $client->refresh('poleintegration_5', $responseData->refresh_token);
$responseData = json_decode($response->getBody()->getContents());
dump($responseData);

$client->setBearer($responseData->access_token);

/*$response = $client->getAccountInfos('poleintegration_5');
$responseData = json_decode($response->getBody()->getContents());
dump($responseData);
 
$response = $client->getUserInfos('poleintegration_5', 'poleintegration_5');
$responseData = json_decode($response->getBody()->getContents());
dump($responseData);*/

$response = $client->getPartnershipGroups();
$responseData = json_decode($response->getBody()->getContents());
dump($responseData);