<?php

namespace Paygreen\Tests\Unit\Charity\V2;

use Http\Client\Curl\Client;
use Paygreen\Sdk\Charity\V2\Environment;
use Paygreen\Sdk\Core\Exception\ConstraintViolationException;
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