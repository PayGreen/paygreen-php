<?php

use Behat\Behat\Tester\Exception\PendingException;
use Paygreen\Sdk\Payment\V3\Model\SellingContract;
use PHPUnit\Framework\Assert;

/**
 * Defines selling contract related features.
 */
trait SellingContractDictionary
{
    /**
     * @var SellingContract
     */
    private $sellingContract;

    /**
     * @Given /^A selling contract object$/
     */
    public function aSellingContractObject()
    {
        $this->sellingContract = new SellingContract();
        $this->sellingContract->setNumber('1234566');
        $this->sellingContract->setMcc(4555);
        $this->sellingContract->setMaxAmount(15000);
    }

    /**
     * @When /^I create a selling contract$/
     */
    public function iCreateASellingContract()
    {
        $this->client->createSellingContract($this->sellingContract);
    }

    /**
     * @When /^I get all selling contracts$/
     */
    public function iGetAllSellingContracts()
    {
        $this->client->listSellingContract(getenv('SHOP_ID'));
    }

    /**
     * @Then /^I receive a response with the selling contract$/
     */
    public function iReceiveAResponseWithTheSellingContract()
    {
        $response = $this->client->getLastResponse();
        $sellingContract = json_decode((string) $response->getBody())->data;

        Assert::assertEquals(getenv('SHOP_ID'), $sellingContract->shop_id);
        Assert::assertEquals('selling_contract', $sellingContract->object);
        Assert::assertObjectHasAttribute('id', $sellingContract);
        Assert::assertObjectHasAttribute('number', $sellingContract);
        Assert::assertObjectHasAttribute('mcc', $sellingContract);
        Assert::assertObjectHasAttribute('max_amount', $sellingContract);
        Assert::assertObjectHasAttribute('status', $sellingContract);
        Assert::assertObjectHasAttribute('type', $sellingContract);
    }

    /**
     * @Given /^I receive a response with all selling contracts$/
     */
    public function iReceiveAResponseWithAllSellingContracts()
    {
        $response = $this->client->getLastResponse();
        $sellingContracts = json_decode((string) $response->getBody())->data;

        foreach ($sellingContracts as $sellingContract) {
            Assert::assertEquals(getenv('SHOP_ID'), $sellingContract->shop_id);
            Assert::assertEquals('selling_contract', $sellingContract->object);
            Assert::assertObjectHasAttribute('id', $sellingContract);
            Assert::assertObjectHasAttribute('number', $sellingContract);
            Assert::assertObjectHasAttribute('mcc', $sellingContract);
            Assert::assertObjectHasAttribute('max_amount', $sellingContract);
            Assert::assertObjectHasAttribute('status', $sellingContract);
            Assert::assertObjectHasAttribute('type', $sellingContract);
        }
    }
}
