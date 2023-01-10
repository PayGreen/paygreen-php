<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;
use PHPUnit\Framework\Assert;

/**
 * Defines transaction related features.
 */
trait TransactionDictionary
{
    /**
     * @var string
     */
    private $transactionId;

    /**
     * @When /^I get a transaction id$/
     */
    public function iGetATransactionId()
    {
        $this->paymentOrder->setBuyer($this->buyer);
        $this->paymentOrder->setAutoCapture(false);
        $response = $this->client->createPaymentOrder($this->paymentOrder);

        $data = json_decode((string)$response->getBody())->data;
        $this->paymentOrder->setId($data->id);
        $this->objectSecret = $data->object_secret;

        // Authorize with PGJS
        $driver = RemoteWebDriver::create('http://selenium:4444', DesiredCapabilities::firefox());
        $driver->get('http://host.docker.internal/payment_v3_create_payment.php?' .
            http_build_query([
                'publicKey' => getenv('PUBLIC_KEY'),
                'paymentOrderId' => $this->paymentOrder->getId(),
                'objectSecret' => $this->objectSecret,
                'instrumentId' => $this->instrumentId,
            ]));

        if (null === $this->instrumentId) {
            // Wait until iframe is loaded
            $driver->wait()->until(
                WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('#paygreen-pan-frame iframe'))
            );

            sleep(3);

            // Fill pan field
            $iframe = $driver->findElement(WebDriverBy::id('cardNumberFrame'));
            $driver->switchTo()->frame($iframe);
            $driver->wait()->until(
                WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('input[name="pan"]'))
            );
            $driver->findElement(WebDriverBy::name('pan'))->sendKeys(getenv('BANK_CARD_PAN'));

            // Fill cvv field
            $driver->switchTo()->defaultContent();
            $iframe = $driver->findElement(WebDriverBy::id('cvvFrame'));
            $driver->switchTo()->frame($iframe);
            $driver->wait()->until(
                WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('input[name="cvv"]'))
            );
            $driver->findElement(WebDriverBy::name('cvv'))->sendKeys(getenv('BANK_CARD_CVV'));

            // Fill expiration field
            $driver->switchTo()->defaultContent();
            $iframe = $driver->findElement(WebDriverBy::id('expFrame'));
            $driver->switchTo()->frame($iframe);
            $driver->wait()->until(
                WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('input[name="exp"]'))
            );
            $driver->findElement(WebDriverBy::name('exp'))->sendKeys(getenv('BANK_CARD_EXP'));

            // Submit form
            $driver->switchTo()->defaultContent();
            $driver->executeScript('paygreenjs.submitPayment()');
        }

        $driver->wait()->until(
            function ($driver) {
                return $driver->executeScript('return paymentDone === true');
            }
        );

        $success = $driver->executeScript('return paymentDone');
        $driver->quit();

        Assert::assertTrue($success);

        $response = $this->client->capturePaymentOrder($this->paymentOrder->getId());
        $data = json_decode((string)$response->getBody())->data;
        $this->transactionId = $data->transactions[0]->id;
    }

    /**
     * @When /^I get the transaction$/
     */
    public function iGetTheTransaction()
    {
        $this->client->getTransaction($this->transactionId);
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