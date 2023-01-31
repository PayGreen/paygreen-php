<?php

namespace Paygreen\Tests\Unit\Payment\V3;

use Http\Mock\Client;
use Paygreen\Sdk\Payment\V3\Environment;
use Psr\Log\NullLogger;

trait ClientTrait
{
    /**
     * @var \Paygreen\Sdk\Payment\V3\Client
     */
    private $client;

    public function setUp()
    {
        $client = new Client();

        $environment = new Environment(
            'my_shop_id',
            'my_secret_key',
            'SANDBOX',
            3
        );

        $logger = new NullLogger();

        $this->client = new \Paygreen\Sdk\Payment\V3\Client($client, $environment, $logger);
    }
}