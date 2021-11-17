<?php

namespace Paygreen\Tests\Unit\Payment\V3;

use Http\Mock\Client;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use Paygreen\Sdk\Payment\V3\PaymentClient;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class PaymentClientTest extends TestCase
{
    /**
     * @var PaymentClient
     */
    private $client;

    public function setUp()
    {
        putenv("PG_PAYMENT_PUBLIC_KEY=public_key");
        putenv("PG_PAYMENT_PRIVATE_KEY=private_key");
        putenv("PG_PAYMENT_API_SERVER=SANDBOX");
        putenv("PG_PAYMENT_API_VERSION=3");

        $client = new Client();
        $logger = new NullLogger();

        $this->client = new PaymentClient($client, $logger);
    }

    public function testRequestAuthenticate()
    {
        $this->client->authenticate();
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/auth/authentication/public_key/secret-key', $request->getUri()->getPath());
    }

    public function testRequestCreateBuyer()
    {
        $buyer = new Buyer();
        $buyer->setId(uniqid());
        $buyer->setFirstname('John');
        $buyer->setLastname('Doe');
        $buyer->setEmail('test@paygreen.fr');
        $buyer->setCountryCode('FR');

        $this->client->createBuyer($buyer);
        $request = $this->client->getLastRequest();
        
        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/shops/public_key/buyers', $request->getUri()->getPath());
        $this->assertEquals($buyer->getEmail(), $content->email);
    }

}