<?php

use Behat\Behat\Tester\Exception\PendingException;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;
use PHPUnit\Framework\Assert;

/**
 * Defines payment order related features.
 */
trait PaymentOrderDictionary
{
    /**
     * @var PaymentOrder
     */
    private $paymentOrder;

    /**
     * @var string
     */
    private $objectSecret;

    /**
     * @var string
     */
    private $instrumentId;

    /**
     * @Given /^A payment order object$/
     */
    public function aPaymentOrderObject()
    {
        $address = new Paygreen\Sdk\Payment\V3\Model\Address();
        $address->setStreetLineOne('54 Crown Street');
        $address->setCity('London');
        $address->setCountryCode('GB');
        $address->setPostalCode('SW14 6ZG');
        $address->setState('London');

        $this->paymentOrder = new PaymentOrder();
        $this->paymentOrder->setReference('sdk-behat-payment-order-' . microtime());
        $this->paymentOrder->setAmount(100);
        $this->paymentOrder->setAutoCapture(false);
        $this->paymentOrder->setCurrency('eur');
        $this->paymentOrder->setShippingAddress($address);
        $this->paymentOrder->setDescription('Test payment order');
        $this->paymentOrder->setCancelUrl('https://www.heypongo.com?cancel');
        $this->paymentOrder->setReturnUrl('https://www.heypongo.com?success');
    }

    /**
     * @Given /^I set ([^"]*) to ([^"]*) in the payment order object$/
     */
    public function iSetToInThePaymentOrderObject($arg1, $arg2)
    {
        $arg1 = explode('_', $arg1);
        $arg1 = array_map('ucfirst', $arg1);
        $arg1 = implode('', $arg1);

        $this->paymentOrder->{'set'.$arg1} = $arg2;
    }

    /**
     * @Given /^I add the buyer object to the payment order object$/
     */
    public function iAddTheBuyerObjectToThePaymentOrderObject()
    {
        $this->paymentOrder->setBuyer($this->buyer);
    }

    /**
     * @Given /^I add the instrument id to the payment order object$/
     */
    public function iAddTheInstrumentIdToThePaymentOrderObject()
    {
        $this->paymentOrder->setInstrument($this->instrumentId);
    }

    /**
     * @When /^I create a payment order$/
     */
    public function iCreateAPaymentOrder()
    {
        $this->client->createPaymentOrder($this->paymentOrder);
    }

    /**
     * @Given /^I receive a response with the payment order$/
     */
    public function iReceiveAResponseWithThePaymentOrder()
    {
        $response = $this->client->getLastResponse();
        $data = json_decode((string)$response->getBody())->data;
        $this->paymentOrder->setId($data->id);
        $this->objectSecret = $data->object_secret;

        print $this->paymentOrder->getId();

        Assert::assertEquals('payment_order', $data->object);
        Assert::assertEquals($this->paymentOrder->getReference(), $data->reference);
        Assert::assertEquals($this->paymentOrder->getAmount(), $data->amount);
        Assert::assertEquals($this->paymentOrder->getCurrency(), $data->currency);
        Assert::assertEquals($this->paymentOrder->getDescription(), $data->description);
        Assert::assertEquals($this->paymentOrder->getCancelUrl() . '&po_id=' . $data->id, $data->cancel_url);
        Assert::assertEquals($this->paymentOrder->getReturnUrl() . '&po_id=' . $data->id, $data->return_url);

        // Shipping address assertions
        Assert::assertEquals($this->paymentOrder->getShippingAddress()->getCity(), $data->shipping_address->city);
        Assert::assertEquals($this->paymentOrder->getShippingAddress()->getCountryCode(), $data->shipping_address->country);
        Assert::assertEquals($this->paymentOrder->getShippingAddress()->getStreetLineOne(), $data->shipping_address->line1);
        Assert::assertEquals($this->paymentOrder->getShippingAddress()->getStreetLineTwo(), $data->shipping_address->line2);
        Assert::assertEquals($this->paymentOrder->getShippingAddress()->getPostalCode(), $data->shipping_address->postal_code);
        Assert::assertEquals($this->paymentOrder->getShippingAddress()->getState(), $data->shipping_address->state);

        // Buyer assertions
        if ($this->paymentOrder->getBuyer()) {
            Assert::assertEquals($this->paymentOrder->getBuyer()->getEmail(), $data->buyer->email);
            Assert::assertEquals($this->paymentOrder->getBuyer()->getFirstName(), $data->buyer->first_name);
            Assert::assertEquals($this->paymentOrder->getBuyer()->getLastName(), $data->buyer->last_name);
            Assert::assertEquals($this->paymentOrder->getBuyer()->getReference(), $data->buyer->reference);
            // Assert::assertEquals($this->paymentOrder->getBuyer()->getPhoneNumber(), $data->buyer->phone_number);
        }
    }

    /**
     * @Given /^I add the payment order id to the payment order object$/
     */
    public function iAddThePaymentOrderIdToThePaymentOrderObject()
    {
        $response = $this->client->getLastResponse();
        $data = json_decode((string)$response->getBody())->data;

        $this->paymentOrder->setId($data->id);

        print $this->paymentOrder->getId();
    }

    /**
     * @When /^I update the payment order$/
     */
    public function iUpdateThePaymentOrder()
    {
        throw new PendingException();

        // Keep it pending while we don't have the official update documentation.

        // $this->paymentOrder->setDescription('Test payment order updated');
        // $this->client->updatePaymentOrder($this->paymentOrder);
    }

    /**
     * @When /^I capture a payment order$/
     */
    public function iCaptureAPaymentOrder()
    {
        $response = $this->client->capturePaymentOrder($this->paymentOrder->getId());
    }

    /**
     * @When /^I refund a payment order$/
     */
    public function iRefundAPaymentOrder()
    {
        $this->client->refundPaymentOrder($this->paymentOrder->getId());
    }

    /**
     * @When /^I refund partially a payment order$/
     */
    public function iRefundPartiallyAPaymentOrder()
    {
        $response = $this->client->getPaymentOrder($this->paymentOrder->getId());
        $responseData = json_decode($response->getBody()->getContents())->data;
        $operation = $responseData->transactions['0']->operations['0'];
        $operationId = $operation->id;
        $partialAmount = $operation->amount / 2;

        $this->client->refundPaymentOrder(
            $this->paymentOrder->getId(),
            $operationId,
            $partialAmount
        );
    }
    /**
     * @When /^I cancel a payment order$/
     */
    public function iCancelAPaymentOrder()
    {
        $this->client->cancelPaymentOrder($this->paymentOrder->getId());
    }

    /**
     * @Given /^I authorize payment with pgjs$/
     */
    public function iAuthorizePaymentWithPgjs()
    {
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
    }
}
