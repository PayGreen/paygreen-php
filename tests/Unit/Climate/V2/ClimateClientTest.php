<?php

namespace Paygreen\Tests\Unit\Climate\V2;

use Http\Client\Curl\Client;
use Paygreen\Sdk\Climate\V2\ClimateClient;
use Paygreen\Sdk\Climate\V2\Model\WebBrowsingData;
use Paygreen\Sdk\Core\Exception\ConstraintViolationException;
use Paygreen\Sdk\Core\GreenEnvironment;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class ClimateClientTest extends TestCase
{
    /** @var ClimateClient */
    private $client;

    public function setUp()
    {
        $client = new Client();

        $environment = new GreenEnvironment(
            'client_id',
            'SANDBOX',
            2
        );

        $logger = new NullLogger();

        $this->client = new ClimateClient($client, $environment, $logger);
    }

    /**
     * @throws ConstraintViolationException
     */
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

    /**
     * @throws ConstraintViolationException
     */
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

    /**
     * @throws ConstraintViolationException
     */
    public function testGetAccountInfos()
    {
        $this->client->getAccountInfos('client_id');
        $request = $this->client->getLastRequest();
        
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/account/client_id', $request->getUri()->getPath());
    }

    /**
     * @throws ConstraintViolationException
     */
    public function testGetUserInfos()
    {
        $this->client->getUserInfos('client_id', 'username');
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/account/client_id/user/username', $request->getUri()->getPath());
    }

    /**
     * @throws ConstraintViolationException
     */
    public function testCreateEmptyFootprint()
    {
        $this->client->createEmptyFootprint('footprint_id');
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/carbon/footprints', $request->getUri()->getPath());
    }

    /**
     * @throws ConstraintViolationException
     */
    public function testGetFootprint()
    {
        $this->client->getFootprint('footprint_id');
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/carbon/footprints/footprint_id', $request->getUri()->getPath());
    }

    /**
     * @throws ConstraintViolationException
     */
    public function testCloseFootprint()
    {
        $this->client->closeFootprint('footprint_id', 'CLOSED');
        $request = $this->client->getLastRequest();

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals('/carbon/footprints/footprint_id', $request->getUri()->getPath());
    }

    /**
     * @throws ConstraintViolationException
     */
    public function testAddWebBrowsingData()
    {
        $webBrowsingData = new WebBrowsingData();
        $webBrowsingData->setUserAgent('Application:my-application/1.0.0 sdk:1.0.0 php:5.6;');
        $webBrowsingData->setCountPages(85);
        $webBrowsingData->setCountImages(15);
        $webBrowsingData->setDevice('Laptop');
        $webBrowsingData->setBrowser('Firefox');
        $webBrowsingData->setTime(4789);
        $webBrowsingData->setExternalId('my-external-id');
        
        $this->client->addWebBrowsing('footprint_id', $webBrowsingData);
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/carbon/footprints/footprint_id/web', $request->getUri()->getPath());
    }
}