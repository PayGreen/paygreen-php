<?php

namespace Paygreen\Tests\Unit\Payment\V2;

use Http\Client\Exception as HttpClientException;
use Http\Mock\Client;
use Paygreen\Sdk\Core\Environment;
use Paygreen\Sdk\Payment\V2\Model\Address;
use Paygreen\Sdk\Payment\V2\Model\Customer;
use Paygreen\Sdk\Payment\V2\Model\MultiplePayment;
use Paygreen\Sdk\Payment\V2\Model\Order;
use Paygreen\Sdk\Payment\V2\Model\OrderDetails;
use Paygreen\Sdk\Payment\V2\Model\PaymentOrder;
use Paygreen\Sdk\Payment\V2\PaymentClient;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class PaymentClientTest extends TestCase
{
    /** @var PaymentClient */
    private $client;

    public function setUp()
    {
        $client = new Client();

        $environment = new Environment(
            'public_key',
            'private_key',
            'SANDBOX',
            2
        );

        $logger = new NullLogger();

        $this->client = new PaymentClient($client, $environment, $logger);
    }

    /**
     * @throws HttpClientException
     */
    public function testRequestCreateCash()
    {
        $paymentOrder = $this->buildPaymentOrder();
        $paymentOrder->setType('CASH');

        $this->client->createCashPayment($paymentOrder);
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/api/public_key/payins/transaction/cash', $request->getUri()->getPath());
        $this->assertEquals($paymentOrder->getType(), $content->type);
        $this->assertEquals($paymentOrder->getOrder()->getAmount(), $content->amount);
    }

    /**
     * @throws HttpClientException
     */
    public function testRequestCreateRecurring()
    {
        $paymentOrder = $this->buildPaymentOrder();
        $paymentOrder->setType('RECURRING');

        $orderDetails = new OrderDetails();
        $orderDetails->setCycle(40);
        $orderDetails->setCount(12);
        $orderDetails->setFirstAmount(6500);
        $orderDetails->setDay(18);
        $orderDetails->setStartAt(1637227163);

        $multiplePayment = new MultiplePayment();
        $multiplePayment->setOrderDetails($orderDetails);

        $paymentOrder->setMultiplePayment($multiplePayment);

        $this->client->createRecurringPayment($paymentOrder);
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/api/public_key/payins/transaction/subscription', $request->getUri()->getPath());
        $this->assertEquals($paymentOrder->getType(), $content->type);
        $this->assertEquals($paymentOrder->getOrder()->getAmount(), $content->amount);
    }

    /**
     * @throws HttpClientException
     */
    public function testRequestCreateXtime()
    {
        $paymentOrder = $this->buildPaymentOrder();
        $paymentOrder->setType('XTIME');

        $orderDetails = new OrderDetails();
        $orderDetails->setCycle(40);
        $orderDetails->setCount(3);

        $multiplePayment = new MultiplePayment();
        $multiplePayment->setOrderDetails($orderDetails);

        $paymentOrder->setMultiplePayment($multiplePayment);

        $this->client->createXtimePayment($paymentOrder);
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/api/public_key/payins/transaction/xtime', $request->getUri()->getPath());
        $this->assertEquals($paymentOrder->getType(), $content->type);
        $this->assertEquals($paymentOrder->getOrder()->getAmount(), $content->amount);
    }

    /**
     * @throws HttpClientException
     */
    public function testRequestCreateTokenize()
    {
        $paymentOrder = $this->buildPaymentOrder();
        $paymentOrder->setType('TOKENIZE');

        $this->client->createTokenizePayment($paymentOrder);
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/api/public_key/payins/transaction/tokenize', $request->getUri()->getPath());
        $this->assertEquals($paymentOrder->getType(), $content->type);
        $this->assertEquals($paymentOrder->getOrder()->getAmount(), $content->amount);
    }

    /**
     * @throws HttpClientException
     */
    public function testRequestCancelPayment()
    {
        $this->client->cancelPayment('tr15acde62ecfc1b8a2a1706b3f17a714e');
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/api/public_key/payins/transaction/cancel', $request->getUri()->getPath());
        $this->assertEquals('tr15acde62ecfc1b8a2a1706b3f17a714e', $content->id);
    }

    /**
     * @throws HttpClientException
     */
    public function testRequestRefundPayment()
    {
        $this->client->refundPayment('tr15acde62ecfc1b8a2a1706b3f17a714e', 5000);
        $request = $this->client->getLastRequest();

        $this->assertEquals('DELETE', $request->getMethod());
        $this->assertEquals(
            '/api/public_key/payins/transaction/tr15acde62ecfc1b8a2a1706b3f17a714e',
            $request->getUri()->getPath()
        );
    }

    /**
     * @throws HttpClientException
     */
    public function testRequestGetTransaction()
    {
        $transactionId = 'tr15acde62ecfc1b8a2a1706b3f17a714e';

        $this->client->getTransaction($transactionId);
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            "/api/public_key/payins/transaction/{$transactionId}",
            $request->getUri()->getPath()
        );
    }

    /**
     * @throws HttpClientException
     */
    public function testRequestConfirmTransaction()
    {
        $transactionId = 'tr15acde62ecfc1b8a2a1706b3f17a714e';

        $this->client->confirmTransaction($transactionId);
        $request = $this->client->getLastRequest();

        $this->assertEquals('PUT', $request->getMethod());
        $this->assertEquals(
            "/api/public_key/payins/transaction/{$transactionId}",
            $request->getUri()->getPath()
        );
    }

    /**
     * @return PaymentOrder
     */
    private function buildPaymentOrder()
    {
        $customer = new Customer();
        $customer->setId(1);
        $customer->setEmail('maxime.lemolt@paygreen.fr');
        $customer->setFirstname('John');
        $customer->setLastname('Doe');

        $shippingAddress = new Address();
        $shippingAddress->setStreetLineOne('1 rue de la Livraison');
        $shippingAddress->setStreetLineTwo('Appartement 12');
        $shippingAddress->setCity('Rouen');
        $shippingAddress->setCountryCode('FR');
        $shippingAddress->setPostcode('76000');

        $billingAddress = new Address();
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

        $paymentOrder = new PaymentOrder();
        $paymentOrder->setOrder($order);

        return $paymentOrder;
    }
}
