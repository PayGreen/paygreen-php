<?php

use Http\Client\Curl\Client;
use Paygreen\Sdk\Charity\V2\Enum\DonationTypeEnum;
use Paygreen\Sdk\Charity\V2\Model\Buyer;
use Paygreen\Sdk\Charity\V2\Model\Donation;

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

//$response = $client->getPartnershipGroups();
//$responseData = json_decode($response->getBody()->getContents());
//dump($responseData);
//$partershipGroups = $responseData->_embedded->partnership_group;
//$defaultGroupExternalId = "default";
//
//foreach ($partershipGroups as $partership) {
//    if($partership->isDefault === "1") {
//        $defaultGroupExternalId = $partership->externalId;
//    }
//}
//$response = $client->getPartnershipGroup($defaultGroupExternalId);
//$responseData = json_decode($response->getBody()->getContents());
//dump($responseData);

$response = $client->getDefaultPartnershipGroup();
$responseData = json_decode($response->getBody()->getContents());
dump($responseData);

$buyer = new Buyer();
$buyer->setEmail("dev-module@paygreen.fr");
$buyer->setFirstName('John');
$buyer->setLastName('Doe');
$buyer->setAddressLine('1 rue de la Livraison');
$buyer->setAddressLineTwo('Appartement 12');
$buyer->setCity('Rouen');
$buyer->setCountryCode('FR');
$buyer->setPostalCode('76000');
$buyer->setPhoneNumber("0102030405");
$buyer->setCompanyName("PayGreen");

$donation = new Donation();
$donation->setReference('GIFT-123');
$donation->setAssociationId(1);
$donation->setType(DonationTypeEnum::ROUNDING);
$donation->setDonationAmount(100);
$donation->setTotalAmount(1000);
$donation->setCurrency("EUR");
$donation->setBuyer($buyer);
$donation->setIsAPledge(true);

$response = $client->createDonation($donation);
$responseData = json_decode($response->getBody()->getContents());
dump($responseData);

$response = $client->getDonation((int)$responseData->idDonation);
$responseData = json_decode($response->getBody()->getContents());
dump($responseData);