<?php

namespace Paygreen\Tests\Unit\Payment\V2;

use Http\Mock\Client;
use Paygreen\Sdk\Payment\V2\Enum\PaymentTypeEnum;
use Paygreen\Sdk\Payment\V2\Environment;
use Paygreen\Sdk\Payment\V2\Model\Address;
use Paygreen\Sdk\Payment\V2\Model\Customer;
use Paygreen\Sdk\Payment\V2\Model\MultiplePayment;
use Paygreen\Sdk\Payment\V2\Model\Order;
use Paygreen\Sdk\Payment\V2\Model\PaymentOrder;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class ClientTest extends TestCase
{
    /** @var \Paygreen\Sdk\Payment\V2\Client */
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

        $this->client = new \Paygreen\Sdk\Payment\V2\Client($client, $environment, $logger);
    }

    public function testCreateOAuthAccessToken()
    {
        $this->client->createOAuthAccessToken(
            '127.0.0.1',
            'dev-module@paygreen.fr',
            'name',
            '0102030405',
            '127.0.0.1'
        );
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/api/auth', $request->getUri()->getPath());
        $this->assertEquals('127.0.0.1', $content->ipAddress);
        $this->assertEquals('dev-module@paygreen.fr', $content->email);
        $this->assertEquals('name', $content->name);
        $this->assertEquals('0102030405', $content->phoneNumber);
        $this->assertEquals('127.0.0.1', $content->serverAddress);
    }

    public function testGetOAuthAuthentication()
    {
        $url = $this->client->getOAuthAuthenticationPage(
            'client_id',
            'http://localhost'
        );
        
        $this->assertEquals(
            'https://sandbox.paygreen.fr/api/auth/authorize?client_id=client_id&redirect_uri=http%3A%2F%2Flocalhost&response_type=code',
            $url
        );
    }

    public function testGetAuthenticationControl()
    {
        $this->client->controlOAuthAuthentication(
            'client_id',
            'authorization_code',
            'code'
        );
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/api/auth/accessToken', $request->getUri()->getPath());
        $this->assertEquals('client_id', $content->client_id);
        $this->assertEquals('authorization_code', $content->grant_type);
        $this->assertEquals('code', $content->code);
    }


    public function testGetShop()
    {
        $this->client->getShop();
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/api/public_key/shop', $request->getUri()->getPath());

    }

    public function testRequestCreateCash()
    {
        $paymentOrder = $this->buildPaymentOrder();
        $paymentOrder->setPaymentType('CB');
        $paymentOrder->setType('CASH');

        $this->client->createCashPayment($paymentOrder);
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/api/public_key/payins/transaction/cash', $request->getUri()->getPath());
        $this->assertEquals($paymentOrder->getType(), $content->type);
        $this->assertEquals($paymentOrder->getPaymentType(), $content->paymentType);
        $this->assertEquals($paymentOrder->getOrder()->getAmount(), $content->amount);
    }

    public function testRequestCreateCashWithEligibleAmount()
    {
        $paymentOrder = $this->buildPaymentOrder();
        $paymentOrder->setType('CASH');
        $paymentOrder->setPaymentType(PaymentTypeEnum::TRD);
        $paymentOrder->setEligibleAmount([PaymentTypeEnum::TRD => 5000]);
        $paymentOrder->setCardToken('my-card-token');

        $this->client->createCashPayment($paymentOrder);
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/api/public_key/payins/transaction/cash', $request->getUri()->getPath());
        $this->assertEquals($paymentOrder->getType(), $content->type);
        $this->assertEquals($paymentOrder->getOrder()->getAmount(), $content->amount);
        $this->assertEquals($paymentOrder->getEligibleAmount()[PaymentTypeEnum::TRD], $content->eligibleAmount->TRD);
        $this->assertEquals($paymentOrder->getCardToken(), $content->card->token);
    }

    public function testRequestCreateRecurring()
    {
        $paymentOrder = $this->buildPaymentOrder();
        $paymentOrder->setType('RECURRING');

        $multiplePayment = new MultiplePayment();
        $multiplePayment->setCycle(40);
        $multiplePayment->setCount(12);
        $multiplePayment->setFirstAmount(6500);
        $multiplePayment->setDay(18);
        $multiplePayment->setStartAt(1637227163);

        $paymentOrder->setMultiplePayment($multiplePayment);

        $this->client->createRecurringPayment($paymentOrder);
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/api/public_key/payins/transaction/subscription', $request->getUri()->getPath());
        $this->assertEquals($paymentOrder->getType(), $content->type);
        $this->assertEquals($paymentOrder->getOrder()->getAmount(), $content->amount);
    }

    public function testRequestCreateXtime()
    {
        $paymentOrder = $this->buildPaymentOrder();
        $paymentOrder->setType('XTIME');

        $multiplePayment = new MultiplePayment();
        $multiplePayment->setCycle(40);
        $multiplePayment->setCount(3);

        $paymentOrder->setMultiplePayment($multiplePayment);

        $this->client->createXtimePayment($paymentOrder);
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/api/public_key/payins/transaction/xtime', $request->getUri()->getPath());
        $this->assertEquals($paymentOrder->getType(), $content->type);
        $this->assertEquals($paymentOrder->getOrder()->getAmount(), $content->amount);
    }

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

    public function testRequestCancelPayment()
    {
        $this->client->cancelPayment('tr15acde62ecfc1b8a2a1706b3f17a714e');
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/api/public_key/payins/transaction/cancel', $request->getUri()->getPath());
        $this->assertEquals('tr15acde62ecfc1b8a2a1706b3f17a714e', $content->id);
    }

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

    public function testRequestUpdateTransactionAmount()
    {
        $transactionId = 'tr15acde62ecfc1b8a2a1706b3f17a714e';

        $this->client->updateTransactionAmount($transactionId, 500);
        $request = $this->client->getLastRequest();

        $content = json_decode($request->getBody()->getContents());

        $this->assertEquals('PATCH', $request->getMethod());
        $this->assertEquals(
            "/api/public_key/payins/transaction/{$transactionId}",
            $request->getUri()->getPath()
        );
        $this->assertEquals(500, $content->amount);
    }

    public function testRequestAvailablePaymentType()
    {
        $this->client->getAvailablePaymentType();
        $request = $this->client->getLastRequest();

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            '/api/public_key/availablepaymenttype',
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
        $customer->setFirstName('John');
        $customer->setLastName('Doe');

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
