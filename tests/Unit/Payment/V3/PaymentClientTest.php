<?php

namespace Paygreen\Tests\Unit\Payment\V3;

use Http\Client\Curl\Client;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use Paygreen\Sdk\Payment\V3\PaymentClient;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Dotenv\Dotenv;

final class PaymentClientTest extends TestCase
{
    /**
     * @var PaymentClient
     */
    private $client;

    /*
    public function setUp()
    {
        (new Dotenv())->load($GLOBALS['ROOT'] . '/.env.v3');

        $curl = new Client();
        $logger = new NullLogger();

        $this->client = new PaymentClient($curl, $logger);
    }
    */

    /*
    public function testCanAuthenticate()
    {
        $response = $this->client->authenticate();

        $content = $response->getData();

        $this->assertTrue(isset($content->created));

        $this->client->setBearer($content->data->token);
    }
    */

    /*
    public function testCanCreateBuyer()
    {
        $buyer = new Buyer();
        $buyer->setReference(uniqid());
        $buyer->setFirstname('John');
        $buyer->setLastname('Doe');
        $buyer->setEmail('test@paygreen.fr');
        $buyer->setCountryCode('FR');

        $response = $this->client->createBuyer($buyer);

    }
    */

}