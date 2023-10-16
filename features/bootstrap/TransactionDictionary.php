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
            $iframe = $driver->findElement(WebDriverBy::id('cardNumber'));
            $driver->switchTo()->frame($iframe);
            $driver->wait()->until(
                WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('input[name="cardnumber"]'))
            );
            $driver->findElement(WebDriverBy::name('cardnumber'))->sendKeys(getenv('BANK_CARD_PAN'));

            // Fill cvv field
            $driver->switchTo()->defaultContent();
            $iframe = $driver->findElement(WebDriverBy::id('cvv'));
            $driver->switchTo()->frame($iframe);
            $driver->wait()->until(
                WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('input[name="cvc"]'))
            );
            $driver->findElement(WebDriverBy::name('cvc'))->sendKeys(getenv('BANK_CARD_CVV'));

            // Fill expiration field
            $driver->switchTo()->defaultContent();
            $iframe = $driver->findElement(WebDriverBy::id('expiryDate'));
            $driver->switchTo()->frame($iframe);
            $driver->wait()->until(
                WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('input[name="exp-date"]'))
            );
            $driver->findElement(WebDriverBy::name('exp-date'))->sendKeys(getenv('BANK_CARD_EXP'));

            // Submit form
            $driver->switchTo()->defaultContent();
            $driver->executeScript('paygreenjs.submitPayment()');
        }

        // Wait until secure authentication frame is loaded
        $driver->wait()->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('#secure_authentication'))
        );
        sleep(3);
        $driver->switchTo()->defaultContent();
        $iframe = $driver->findElement(WebDriverBy::cssSelector('#secure_authentication'));
        $driver->switchTo()->frame($iframe);
        // Fill 3dsecure
        $driver->wait()->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('iframe[name="cko-3ds2-iframe"]'))
        );
        $iframe = $driver->findElement(WebDriverBy::cssSelector('iframe[name="cko-3ds2-iframe"]'));
        $driver->switchTo()->frame($iframe);
        $driver->wait()->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('input[name="password"]'))
        );
        $driver->findElement(WebDriverBy::name('password'))->sendKeys('Checkout1!');
        $driver->findElement(WebDriverBy::id('txtButton'))->click();

        sleep(5);

        $driver->switchTo()->defaultContent();
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