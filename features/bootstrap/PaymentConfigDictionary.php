<?php

use Paygreen\Sdk\Payment\V3\Model\PaymentConfig;
use PHPUnit\Framework\Assert;

/**
 * Defines payment config related features.
 */
trait PaymentConfigDictionary
{
    /**
     * @var PaymentConfig
     */
    private $paymentConfig;

    /**
     * @Given /^A payment config object$/
     */
    public function aPaymentConfigObject()
    {
        $this->paymentConfig = new PaymentConfig();
        $this->paymentConfig->setCurrency('eur');
        $this->paymentConfig->setPlatform('conecs');
    }

    /**
     * @When /^I create a payment config$/
     */
    public function iCreateAPaymentConfig()
    {
        $this->client->createPaymentConfig($this->paymentConfig, getenv('SHOP_ID'));
    }

    /**
     * @Then /^I receive a response with the payment config$/
     */
    public function iReceiveAResponseWithThePaymentConfig()
    {
        $response = $this->client->getLastResponse();
        $data = json_decode((string) $response->getBody())->data;

        Assert::assertEquals(getenv('SHOP_ID'), $data->shop_id);
        Assert::assertEquals('payment_config', $data->object);
        Assert::assertEquals('conecs', $data->platform);
        Assert::assertObjectHasAttribute('id', $data);
        Assert::assertObjectHasAttribute('status', $data);
        Assert::assertObjectHasAttribute('currency', $data);
        Assert::assertObjectHasAttribute('platform_options', $data);
    }

    /**
     * @When /^I get all payment configs$/
     */
    public function iGetAllPaymentConfigs()
    {
        $this->client->listPaymentConfig();
    }

    /**
     * @Given /^I receive a response with all payment configs$/
     */
    public function iReceiveAResponseWithAllPaymentConfigs()
    {
        $response = $this->client->getLastResponse();
        $paymentConfigs = json_decode((string) $response->getBody())->data;

        foreach ($paymentConfigs as $paymentConfig) {
            Assert::assertEquals(getenv('SHOP_ID'), $paymentConfig->shop_id);
            Assert::assertEquals('payment_config', $paymentConfig->object);
            Assert::assertObjectHasAttribute('status', $paymentConfig);
            Assert::assertObjectHasAttribute('currency', $paymentConfig);
        }
    }
}
