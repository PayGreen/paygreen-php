<?php

namespace Paygreen\Tests\Unit\Charity\V2;

use Http\Client\Curl\Client;
use Paygreen\Sdk\Charity\V2\Enum\DonationTypeEnum;
use Paygreen\Sdk\Charity\V2\Environment;
use Paygreen\Sdk\Charity\V2\Model\Buyer;
use Paygreen\Sdk\Charity\V2\Model\Donation;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class ClientTest extends TestCase
{
    /** @var \Paygreen\Sdk\Charity\V2\Client */
    private $client;

    public function setUp()
    {
        $client = new Client();

        $environment = new Environment(
            'client_id',
            'SANDBOX',
            2
        );

        $logger = new NullLogger();

        $this->client = new \Paygreen\Sdk\Charity\V2\Client($client, $environment, $logger);
    }

    public function testLogin()
    {
        $this->client->login(
            'client_id',
            'username',
            'password'
        );
        $request = $this->client->getLastRequest();
        
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/login', $request->getUri()->getPath());
    }

    public function testRefresh()
    {
        $this->client->refresh(
            'client_id',
            'refresh_token'
        );
        $request = $this->client->getLastRequest();
        

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/login', $request->getUri()->getPath());
    }

    public function testGetAccountInfos()
    {
        $this->client->getAccountInfos('client_id');
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/account/client_id', $request->getUri()->getPath());
    }

    public function testGetUserInfos()
    {
        $this->client->getUserInfos('client_id', 'username');
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/account/client_id/user/username', $request->getUri()->getPath());
    }

    public function testGetPartnershipGroups()
    {
        $this->client->getPartnershipGroups();
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/partnership-group', $request->getUri()->getPath());
    }

    public function testGetPartnershipGroup()
    {
        $this->client->getPartnershipGroup('external_id');
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/partnership-group/external_id', $request->getUri()->getPath());
    }

    public function testGetDefaultPartnershipGroup()
    {
        $this->client->getDefaultPartnershipGroup();
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $uri = $request->getUri();
        $this->assertEquals('/partnership-group?isDefault=1', $uri->getPath() . '?' . $uri->getQuery());
    }
    
    public function testCreateDonation()
    {
        $buyer = new Buyer();
        $buyer->setEmail("dev-modulep@paygreen.fr");
        $buyer->setReference("buyerReference");
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
        $donation->setAssociationId(1);
        $donation->setType(DonationTypeEnum::ROUNDING);
        $donation->setDonationAmount(100);
        $donation->setTotalAmount(1000);
        $donation->setCurrency("EUR");
        $donation->setBuyer($buyer);
        $donation->setIsAPledge(true);
        
        $this->client->createDonation($donation);
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/donation', $request->getUri()->getPath());
    }

    public function testGetDonation()
    {
        $donationId = 1000;

        $this->client->getDonation($donationId);
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/donation/1000', $request->getUri()->getPath());
    }
}