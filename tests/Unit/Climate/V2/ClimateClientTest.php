<?php

namespace Paygreen\Tests\Unit\Climate\V2;

use Http\Client\Curl\Client;
use Paygreen\Sdk\Climate\V2\ClimateClient;
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
}