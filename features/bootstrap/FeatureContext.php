<?php

use Behat\Behat\Context\Context;
use Paygreen\Sdk\Payment\V3\Client;
use Paygreen\Sdk\Payment\V3\Environment;
use PHPUnit\Framework\Assert;
use Symfony\Component\Dotenv\Dotenv;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    use BuyerDictionary;
    use AuthenticationDictionary;
    use PaymentOrderDictionary;
    use InstrumentDictionary;

    /**
     * @var Client
     */
    private $client;


    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        (new Dotenv())->load(dirname(dirname(__DIR__)) . '/.env.behat');
    }

    /**
     * @Given /^A ready to use Client$/
     */
    public function aReadyToUseClient()
    {
        $shopId = getenv('SHOP_ID');
        $secretKey = getenv('SECRET_KEY');
        $endpoint = getenv('ENVIRONMENT');
        $environment = new Environment($shopId, $secretKey, $endpoint);

        $httpClient = new Http\Client\Curl\Client();

        $this->client = new Client($httpClient, $environment);
    }

    /**
     * @Then /^I receive a (\d+) status code$/
     */
    public function iReceiveAStatusCode($arg1)
    {
        Assert::assertEquals($arg1, $this->client->getLastResponse()->getStatusCode());
    }


}
