<?php

namespace Paygreen\Tests\Unit\Payment\V3;

use Http\Mock\Client;
use Paygreen\Sdk\Payment\Model\Order;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;
use Paygreen\Sdk\Payment\V3\PaymentClient;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class PaymentClientTest extends TestCase
{
    /**
     * @var PaymentClient
     */
    private $client;

    public function setUp()
    {
        putenv("PG_PAYMENT_PUBLIC_KEY=public_key");
        putenv("PG_PAYMENT_PRIVATE_KEY=private_key");
        putenv("PG_PAYMENT_API_SERVER=SANDBOX");
        putenv("PG_PAYMENT_API_VERSION=3");

        $client = new Client();
        $logger = new NullLogger();

        $this->client = new PaymentClient($client, $logger);
    }

    public function testRequestAuthenticate()
    {
        $this->client->authenticate();
        $request = $this->client->getLastRequest();

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/auth/authentication/public_key/secret-key', $request->getUri()->getPath());
    }

    public function testRequestCreateBuyer()
    {
        $buyer = new Buyer();
        $buyer->setId(uniqid());
        $buyer->setFirstname('John');
        $buyer->setLastname('Doe');
        $buyer->setEmail('dev-module@paygreen.fr');
        $buyer->setCountryCode('FR');

        $this->client->createBuyer($buyer);
        $request = $this->client->getLastRequest();
        
        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/shops/public_key/buyers', $request->getUri()->getPath());
        $this->assertEquals($buyer->getEmail(), $content->email);
        $this->assertEquals($buyer->getFirstname(), $content->first_name);
        $this->assertEquals($buyer->getLastname(), $content->last_name);
        $this->assertEquals($buyer->getId(), $content->reference);
        $this->assertEquals($buyer->getCountryCode(), $content->country);
    }

    public function testRequestGetBuyer()
    {
        $buyer = new Buyer();
        $buyer->setReference("buyerReference");

        $this->client->getBuyer($buyer);
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/payment/shops/public_key/buyers/buyerReference', $request->getUri()->getPath());
    }

    public function testRequestUpdateBuyer()
    {
        $buyer = new Buyer();
        $buyer->setId("buyerId");
        $buyer->setReference("buyerReference");
        $buyer->setFirstname('John');
        $buyer->setLastname('Doe');
        $buyer->setEmail('dev-module@paygreen.fr');
        $buyer->setCountryCode('FR');

        $this->client->updateBuyer($buyer);
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/shops/public_key/buyers/buyerReference', $request->getUri()->getPath());
        $this->assertEquals($buyer->getEmail(), $content->email);
        $this->assertEquals($buyer->getFirstname(), $content->first_name);
        $this->assertEquals($buyer->getLastname(), $content->last_name);
        $this->assertEquals($buyer->getId(), $content->reference);
        $this->assertEquals($buyer->getCountryCode(), $content->country);
    }

    public function testRequestCreateOrder()
    {
        $buyer = new Buyer();
        $buyer->setId("buyerId");
        $buyer->setFirstname('John');
        $buyer->setLastname('Doe');
        $buyer->setEmail('dev-module@paygreen.fr');
        $buyer->setCountryCode('FR');

        $order = new Order();
        $order->setCustomer($buyer);
        $order->setReference('SDK-ORDER-123');
        $order->setAmount(1000);
        $order->setCurrency('EUR');

        $paymentOrder = new PaymentOrder();
        $paymentOrder->setPaymentMode("instant");
        $paymentOrder->setAutoCapture(true);
        $paymentOrder->setIntegrationMode("hosted_fields");
        $paymentOrder->setOrder($order);
        
        $this->client->createOrder($paymentOrder);
        $request = $this->client->getLastRequest();
        
        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/payment/payment-orders', $request->getUri()->getPath());
        $this->assertEquals($buyer->getEmail(), $content->buyer->email);
        $this->assertEquals($buyer->getFirstname(), $content->buyer->firstName);
        $this->assertEquals($buyer->getLastname(), $content->buyer->lastName);
        $this->assertEquals($buyer->getId(), $content->buyer->reference);
        $this->assertEquals($buyer->getCountryCode(), $content->buyer->country);

        $this->assertEquals($order->getReference(), $content->reference);
        $this->assertEquals($order->getAmount(), $content->amount);
        $this->assertEquals($order->getCurrency(), $content->currency);

        $this->assertEquals($paymentOrder->getPaymentMode(), $content->paymentMode);
        $this->assertEquals($paymentOrder->getAutoCapture(), $content->auto_capture);
        $this->assertEquals($paymentOrder->getIntegrationMode(), $content->integration_mode);
    }
}