<?php

use PHPUnit\Framework\Assert;

/**
 * Defines payment config related features.
 */
trait TransactionDictionary
{
    /**
     * @When /^I get the transaction$/
     */
    public function iGetTheTransaction()
    {
        $response = $this->client->getTransaction('tr_d7e4181dfa664a4889fce1868d785bac');
    }

    /**
     * @Then /^I receive a response with the transaction$/
     */
    public function iReceiveAResponseWithTheTransaction()
    {
        $response = $this->client->getLastResponse();
        $transaction = json_decode((string) $response->getBody())->data;

        Assert::assertEquals('transaction', $transaction->object);
        Assert::assertObjectHasAttribute('id', $transaction);
        Assert::assertObjectHasAttribute('amount', $transaction);
        Assert::assertObjectHasAttribute('status', $transaction);
        Assert::assertObjectHasAttribute('currency', $transaction);
        Assert::assertObjectHasAttribute('buyer', $transaction);
        Assert::assertObjectHasAttribute('payment_order_id', $transaction);
        Assert::assertObjectHasAttribute('mode', $transaction);
    }

    /**
     * @When /^I get all transactions$/
     */
    public function iGetAllTransactions()
    {
        $this->client->listTransaction(getenv('SHOP_ID'));
    }

    /**
     * @Given /^I receive a response with all transactions$/
     */
    public function iReceiveAResponseWithAllTransactions()
    {
        $response = $this->client->getLastResponse();
        $transactions = json_decode((string) $response->getBody())->data;

        foreach ($transactions as $transaction) {
            Assert::assertEquals('transaction', $transaction->object);
            Assert::assertObjectHasAttribute('id', $transaction);
            Assert::assertObjectHasAttribute('amount', $transaction);
            Assert::assertObjectHasAttribute('status', $transaction);
            Assert::assertObjectHasAttribute('currency', $transaction);
            Assert::assertObjectHasAttribute('buyer', $transaction);
            Assert::assertObjectHasAttribute('payment_order_id', $transaction);
            Assert::assertObjectHasAttribute('mode', $transaction);
        }
    }
}