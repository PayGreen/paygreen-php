<?php

use Behat\Mink\Mink;
use Behat\Mink\Session;
use DMore\ChromeDriver\ChromeDriver;
use Behat\Behat\Tester\Exception\PendingException;
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
        $address->setCountryCode('UK');
        $address->setPostalCode('SW14 6ZG');

        $this->paymentOrder = new PaymentOrder();
        $this->paymentOrder->setReference('sdk-behat-payment-order');
        $this->paymentOrder->setAmount(100);
        $this->paymentOrder->setAutoCapture(false);
        $this->paymentOrder->setCurrency('eur');
        $this->paymentOrder->setShippingAddress($address);
        $this->paymentOrder->setDescription('Test payment order');
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

        // Shipping address assertions
        Assert::assertEquals($this->paymentOrder->getShippingAddress()->getCity(), $data->shipping_address->city);
        Assert::assertEquals($this->paymentOrder->getShippingAddress()->getCountryCode(), $data->shipping_address->country);
        Assert::assertEquals($this->paymentOrder->getShippingAddress()->getStreetLineOne(), $data->shipping_address->line1);
        Assert::assertEquals($this->paymentOrder->getShippingAddress()->getStreetLineTwo(), $data->shipping_address->line2);
        Assert::assertEquals($this->paymentOrder->getShippingAddress()->getPostalCode(), $data->shipping_address->postal_code);

        // Buyer assertions
        Assert::assertEquals($this->paymentOrder->getBuyer()->getEmail(), $data->buyer->email);
        Assert::assertEquals($this->paymentOrder->getBuyer()->getFirstName(), $data->buyer->first_name);
        Assert::assertEquals($this->paymentOrder->getBuyer()->getLastName(), $data->buyer->last_name);
        Assert::assertEquals($this->paymentOrder->getBuyer()->getReference(), $data->buyer->reference);
        // Assert::assertEquals($this->paymentOrder->getBuyer()->getPhoneNumber(), $data->buyer->phone_number);
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
        throw new PendingException();
    }

    /**
     * @Given /^I authorize payment with pgjs$/
     */
    public function iAuthorizePaymentWithPgjs()
    {
        $mink = new Mink(array(
            'browser' => new Session(new ChromeDriver('http://localhost:9222', null, 'http://www.google.com'))
        ));

        $session = $mink->getSession('browser');
        $session->start();
        $session->visit('http://localhost/payment_v3_create_payment.html?' .
            http_build_query([
                'publicKey' => getenv('PUBLIC_KEY'),
                'paymentOrderId' => $this->paymentOrder->getId(),
                'objectSecret' => $this->objectSecret,
                'instrumentId' => $this->instrumentId,
            ]));

        $page = $session->getPage();

        // Wait until iframe is loaded
        $page->waitFor(10, function () use ($page) {
            return $page->find('css', '#paygreen-pan-frame iframe');
        });

        // Fill pan field
        $session->switchToIFrame('paygreen-pan');
        $page->waitFor(10, function () use ($page) {
            return $page->find('css', 'input[name="pan"]');
        });
        $page->fillField('pan', getenv('BANK_CARD_PAN'));

        // Fill cvc field
        $session->switchToIFrame();
        $session->switchToIFrame('paygreen-cvv');
        $page->waitFor(10, function () use ($page) {
            return $page->find('css', 'input[name="cvv"]');
        });
        $page->fillField('cvv', getenv('BANK_CARD_CVV'));

        // Fill expiration field
        $session->switchToIFrame();
        $session->switchToIFrame('paygreen-exp');
        $page->waitFor(10, function () use ($page) {
            return $page->find('css', 'input[name="exp"]');
        });
        $page->fillField('exp', getenv('BANK_CARD_EXP'));

        // Submit form
        $session->switchToIFrame();
        $session->executeScript('paygreenjs.submitPayment()');

        $session->wait(
            5000,
            "paymentDone === true"
        );
        $success = $session->evaluateScript('paymentDone');

        Assert::assertTrue($success);
    }
}
