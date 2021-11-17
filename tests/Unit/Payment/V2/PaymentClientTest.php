<?php

namespace Paygreen\Tests\Unit\Payment\V2;

use Http\Client\Exception as HttpClientException;
use Http\Mock\Client;
use Paygreen\Sdk\Payment\Model\Address;
use Paygreen\Sdk\Payment\Model\Customer;
use Paygreen\Sdk\Payment\Model\Order;
use Paygreen\Sdk\Payment\V2\Model\PaymentOrder;
use Paygreen\Sdk\Payment\V2\PaymentClient;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class PaymentClientTest extends TestCase
{
    /** @var PaymentClient */
    private $client;

    /** @var PaymentOrder */
    private $paymentOrder;

    /**
     * @return void
     */
    public function setUp()
    {
        putenv("PG_PAYMENT_PUBLIC_KEY=public_key");
        putenv("PG_PAYMENT_PRIVATE_KEY=private_key");
        putenv("PG_PAYMENT_API_SERVER=SANDBOX");
        putenv("PG_PAYMENT_API_VERSION=2");

        $client = new Client();
        $logger = new NullLogger();

        $this->client = new PaymentClient($client, $logger);

        $this->buildPaymentOrder();
    }

    /**
     * @return void
     * @throws HttpClientException
     */
    public function testRequestCreateCash()
    {
        $this->client->createCashPayment($this->paymentOrder);
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/api/public_key/payins/transaction/cash', $request->getUri()->getPath());
    }

    /**
     * @return void
     */
    private function buildPaymentOrder()
    {
        $customer = new Customer();
        $customer->setId(1);
        $customer->setEmail('maxime.lemolt@paygreen.fr');
        $customer->setFirstname('John');
        $customer->setLastname('Doe');

        $shippingAddress = new Address();
        $shippingAddress->setFirstname('John');
        $shippingAddress->setLastname('Doe');
        $shippingAddress->setStreetLineOne('1 rue de la Livraison');
        $shippingAddress->setStreetLineTwo('Appartement 12');
        $shippingAddress->setCity('Rouen');
        $shippingAddress->setCountryCode('FR');
        $shippingAddress->setPostcode('76000');

        $billingAddress = new Address();
        $billingAddress->setFirstname('John');
        $billingAddress->setLastname('Doe');
        $billingAddress->setStreetLineOne('1 rue de la Facturation');
        $billingAddress->setCity('Rouen');
        $billingAddress->setCountryCode('FR');
        $billingAddress->setPostcode('76000');

        $order = new Order();
        $order->setCustomer($customer);
        $order->setBillingAddress($billingAddress);
        $order->setShippingAddress($shippingAddress);
        $order->setReference('SDK-ORDER-123');
        $order->setAmount(1000);
        $order->setCurrency('EUR');

        $this->paymentOrder = new PaymentOrder();
        $this->paymentOrder->setOrder($order);
    }
}